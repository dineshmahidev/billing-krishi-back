<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LabSetting;
use Illuminate\Http\Request;

class LabSettingController extends Controller
{
    public function index()
    {
        return response()->json(LabSetting::current());
    }

    public function update(Request $request)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        if ($request->user()->is_demo) return response()->json(['message'=>'Demo mode: lab settings are read-only'], 403);
        $lab = LabSetting::current();
        $data = $request->validate([
            'lab_name'=>'sometimes|required|string',
            'tagline'=>'sometimes|nullable|string',
            'address'=>'sometimes|nullable|string',
            'phone'=>'sometimes|nullable|string',
            'email'=>'sometimes|nullable|email',
            'website'=>'sometimes|nullable|string|max:120',
            'default_gst_percent'=>'sometimes|nullable|numeric|min:0|max:100',
            'gst_enabled'=>'sometimes|boolean',
            'gstin'=>'sometimes|nullable|string|max:30',
            'invoice_prefix'=>'sometimes|nullable|string|max:20',
            'logo'=>'sometimes|nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'seal'=>'sometimes|nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'signature'=>'sometimes|nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'smtp_host'=>'sometimes|nullable|string|max:190',
            'smtp_port'=>'sometimes|nullable|integer|min:1|max:65535',
            'smtp_username'=>'sometimes|nullable|string|max:190',
            'smtp_password'=>'sometimes|nullable|string|max:190',
            'smtp_encryption'=>'sometimes|nullable|in:none,tls,ssl',
            'mail_from_address'=>'sometimes|nullable|email',
            'mail_from_name'=>'sometimes|nullable|string|max:120',
        ]);
        // blank password field in the UI = keep the stored one
        if (array_key_exists('smtp_password', $data) && $data['smtp_password'] === '') {
            unset($data['smtp_password']);
        }
        foreach (['logo','seal','signature'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('lab','public');
                $data[$field.'_path'] = 'storage/'.$path;
                unset($data[$field]);
            }
        }
        if ($request->has('logo_path')) $data['logo_path'] = $request->input('logo_path');
        $lab->update($data);
        return response()->json($lab);
    }

    public function testMail(Request $request)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $request->validate([
            'email' => 'required|email'
        ]);

        try {
            \App\Support\MailConfig::apply();
            $lab = LabSetting::current();
            $to = $request->input('email');

            \Illuminate\Support\Facades\Mail::raw("Hello,\n\nThis is a test email sent from Krishi Analytical Lab Billing Software to verify that your SMTP mail settings are working perfectly.\n\nRegards,\n{$lab->lab_name}", function($message) use ($to, $lab) {
                $message->to($to)
                        ->subject("SMTP Test Email - {$lab->lab_name}");
            });

            return response()->json(['message' => "Test email successfully sent to {$to}!"]);
        } catch (\Throwable $e) {
            return response()->json(['message' => "Failed to send email: " . $e->getMessage()], 422);
        }
    }
}
