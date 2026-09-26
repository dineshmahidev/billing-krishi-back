<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\EnquiryAutoReply;
use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use App\Models\LabSetting;
use App\Support\MailConfig;
use App\Support\PdfFont;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EnquiryController extends Controller
{
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
