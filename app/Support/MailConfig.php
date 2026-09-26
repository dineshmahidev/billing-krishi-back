<?php

namespace App\Support;

use App\Models\LabSetting;

class MailConfig
{
    /**
     * Apply admin-panel SMTP settings (lab_settings) to the runtime mail config.
     * Falls back to .env mail config when no smtp_host is configured.
     */
    public static function apply(): void
    {
        try {
            $lab = LabSetting::current();
        } catch (\Throwable $e) {
            return;
        }
        if (!$lab || !($lab->smtp_host ?? null)) {
            return;
        }

        $encryption = $lab->smtp_encryption ?: null;
        if ($encryption === 'none') $encryption = null;

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.url' => null,
            'mail.mailers.smtp.host' => $lab->smtp_host,
            'mail.mailers.smtp.port' => (int) ($lab->smtp_port ?: 587),
            'mail.mailers.smtp.username' => $lab->smtp_username,
            'mail.mailers.smtp.password' => $lab->smtp_password,
            'mail.mailers.smtp.encryption' => $encryption,
            'mail.mailers.smtp.timeout' => 15,
            'mail.from.address' => $lab->mail_from_address ?: ($lab->email ?: config('mail.from.address')),
            'mail.from.name' => $lab->mail_from_name ?: ($lab->lab_name ?: config('mail.from.name')),
        ]);

        app('mail')->forgetMailers();
    }
}
