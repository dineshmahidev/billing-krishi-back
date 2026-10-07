<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\EnquiryAutoReply;
use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use App\Models\Visit;
use App\Models\LabSetting;
use App\Support\MailConfig;
use App\Support\PdfFont;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EnquiryController extends Controller
{
    // Public: Store website enquiry & send email via SMTP if configured
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'sometimes|in:enquiry,sample',
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:190',
            'sample_type' => 'nullable|string|max:60',
            'message' => 'nullable|string|max:2000',
        ]);
        $data['type'] = $data['type'] ?? 'enquiry';

        $enquiry = Enquiry::create($data);

        try {
            MailConfig::apply();
            $lab = LabSetting::current();
            $pdfPath = $this->buildPdf($enquiry, $lab);

            try {
                $labTo = $lab->mail_from_address ?: $lab->email;
                if ($labTo) {
                    Mail::to($labTo)->send(new EnquiryReceived($enquiry, $lab, $pdfPath));
                }
                if ($enquiry->email) {
                    Mail::to($enquiry->email)->send(new EnquiryAutoReply($enquiry, $lab, $pdfPath));
                }
            } finally {
                if ($pdfPath && is_file($pdfPath)) @unlink($pdfPath);
            }
        } catch (\Throwable $e) {
            Log::error('Enquiry mail failed: '.$e->getMessage());
        }

        return response()->json([
            'message' => 'Submitted — we will contact you shortly',
            'ref' => $enquiry->ref(),
        ], 201);
    }

    // Protected: List all enquiries for Admin Panel
    public function index(Request $request)
    {
        $query = Enquiry::query()->latest();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('sample_type', 'like', "%{$q}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $enquiries = $query->paginate(20);
        return response()->json($enquiries);
    }

    // Protected: Delete enquiry
    public function destroy($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->delete();
        return response()->json(['message' => 'Enquiry deleted successfully']);
    }

    // Public: Record website visitor traffic
    public function recordVisit(Request $request)
    {
        try {
            Visit::create([
                'ip_address' => $request->ip(),
                'user_agent' => substr((string)$request->header('User-Agent'), 0, 255),
                'page_url' => substr($request->input('page_url', '/'), 0, 255),
            ]);
            return response()->json(['status' => 'recorded']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'ignored'], 200);
        }
    }

    // Protected: Get traffic statistics
    public function trafficStats()
    {
        $totalVisits = Visit::count();
        $todayVisits = Visit::whereDate('created_at', now()->today())->count();
        $uniqueIps = Visit::distinct('ip_address')->count('ip_address');

        return response()->json([
            'total_visits' => $totalVisits,
            'today_visits' => $todayVisits,
            'unique_ips' => $uniqueIps,
        ]);
    }

    private function buildPdf(Enquiry $e, LabSetting $lab): ?string
    {
        try {
            $pdf = Pdf::loadView('pdf.enquiry', ['e' => $e, 'lab' => $lab]);
            PdfFont::apply($pdf);
            $dir = storage_path('app/framework/enquiries');
            if (!is_dir($dir)) @mkdir($dir, 0755, true);
            $path = $dir.'/enquiry-'.$e->id.'.pdf';
            file_put_contents($path, $pdf->output());
            return $path;
        } catch (\Throwable $ex) {
            Log::error('Enquiry PDF failed: '.$ex->getMessage());
            return null;
        }
    }
}
