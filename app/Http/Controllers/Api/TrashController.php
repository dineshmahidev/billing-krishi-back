<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Invoice;
use App\Models\Parameter;
use App\Models\ReportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrashController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type', 'reports');

        $query = Report::onlyTrashed()->with(['reportType', 'creator', 'customer'])->latest('deleted_at');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('report_no', 'like', "%$search%")
                  ->orWhere('party_name', 'like', "%$search%")
                  ->orWhere('customer_name', 'like', "%$search%")
                  ->orWhere('sample_name', 'like', "%$search%");
            });
        }
        $perPage = $request->input('per_page', 15);
        $trashedReports = $query->paginate($perPage);

        $invoiceQuery = Invoice::onlyTrashed()->with('report')->latest('deleted_at');
        if ($search) {
            $invoiceQuery->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%$search%")
                  ->orWhere('party_name', 'like', "%$search%")
                  ->orWhere('customer_name', 'like', "%$search%");
            });
        }
        $trashedInvoices = $invoiceQuery->get();

        $paramQuery = Parameter::onlyTrashed()->with('reportType')->latest('deleted_at');
        if ($search) {
            $paramQuery->where('name', 'like', "%$search%");
        }
        $trashedParameters = $paramQuery->get();

        $reportTypeQuery = ReportType::onlyTrashed()->latest('deleted_at');
        if ($search) {
            $reportTypeQuery->where('name', 'like', "%$search%");
        }
        $trashedReportTypes = $reportTypeQuery->get();

        return response()->json([
            'reports' => $trashedReports,
            'invoices' => $trashedInvoices,
            'parameters' => $trashedParameters,
            'report_types' => $trashedReportTypes,
            'counts' => [
                'reports' => Report::onlyTrashed()->count(),
                'invoices' => Invoice::onlyTrashed()->count(),
                'parameters' => Parameter::onlyTrashed()->count(),
                'report_types' => ReportType::onlyTrashed()->count(),
            ]
        ]);
    }

    public function restoreReport(Request $request, $id)
    {
        $report = Report::onlyTrashed()->findOrFail($id);
        DB::transaction(function () use ($report) {
            $report->restore();
            // Restore corresponding invoice if soft-deleted
            Invoice::onlyTrashed()->where('report_id', $report->id)->restore();
        });
        return response()->json(['message' => "Report {$report->report_no} and its invoice restored successfully."]);
    }

    public function forceDeleteReport(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden - Admin access required for permanent deletion'], 403);
        }

        $report = Report::onlyTrashed()->findOrFail($id);
        $reportNo = $report->report_no;

        DB::transaction(function () use ($report) {
            Invoice::withTrashed()->where('report_id', $report->id)->forceDelete();
            $report->results()->delete();
            $report->forceDelete();
        });

        return response()->json(['message' => "Report {$reportNo} permanently deleted."]);
    }

    public function restoreInvoice(Request $request, $id)
    {
        $invoice = Invoice::onlyTrashed()->findOrFail($id);
        $invoice->restore();
        return response()->json(['message' => "Invoice {$invoice->invoice_no} restored successfully."]);
    }

    public function forceDeleteInvoice(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden - Admin access required'], 403);
        }
        $invoice = Invoice::onlyTrashed()->findOrFail($id);
        $invNo = $invoice->invoice_no;
        $invoice->items()->delete();
        $invoice->forceDelete();
        return response()->json(['message' => "Invoice {$invNo} permanently deleted."]);
    }

    public function restoreParameter(Request $request, $id)
    {
        $param = Parameter::onlyTrashed()->findOrFail($id);
        $param->restore();
        return response()->json(['message' => "Parameter {$param->name} restored successfully."]);
    }

    public function forceDeleteParameter(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden - Admin access required'], 403);
        }

        $param = Parameter::onlyTrashed()->findOrFail($id);
        $name = $param->name;
        $param->forceDelete();

        return response()->json(['message' => "Parameter {$name} permanently deleted."]);
    }

    public function restoreReportType(Request $request, $id)
    {
        $type = ReportType::onlyTrashed()->findOrFail($id);
        $type->restore();
        return response()->json(['message' => "Report type {$type->name} restored successfully."]);
    }

    public function forceDeleteReportType(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden - Admin access required'], 403);
        }
        $type = ReportType::onlyTrashed()->findOrFail($id);
        $name = $type->name;
        $type->forceDelete();
        return response()->json(['message' => "Report type {$name} permanently deleted."]);
    }

    public function emptyTrash(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden - Admin access required'], 403);
        }

        DB::transaction(function () {
            $trashed = Report::onlyTrashed()->get();
            foreach ($trashed as $report) {
                $report->results()->delete();
                $report->forceDelete();
            }
            Invoice::onlyTrashed()->forceDelete();
            Parameter::onlyTrashed()->forceDelete();
            ReportType::onlyTrashed()->forceDelete();
        });

        return response()->json(['message' => 'Trash emptied successfully.']);
    }
}
