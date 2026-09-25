<?php

namespace App\Support;

class PdfFont
{
    public const FAMILY = 'Krishi';

    private static bool $registered = false;

    /**
     * Register a Unicode font (Segoe UI - supports ₹ • — × °) with DomPDF
     * so special symbols render instead of "?".
     */
    public static function apply($pdf): void
    {
        if (self::$registered) return;

        $dir = storage_path('fonts');
        if (!is_dir($dir)) @mkdir($dir, 0755, true);

        $fonts = [
            ['weight' => 'normal', 'file' => 'krishi-regular.ttf', 'win' => 'segoeui.ttf'],
            ['weight' => 'bold',   'file' => 'krishi-bold.ttf',    'win' => 'segoeuib.ttf'],
        ];

        $allOk = true;
        foreach ($fonts as $font) {
            $dest = $dir.'/'.$font['file'];
            if (!file_exists($dest)) @copy('C:/Windows/Fonts/'.$font['win'], $dest);
            if (!file_exists($dest)) { $allOk = false; continue; }

            $ok = $pdf->getDomPDF()->getFontMetrics()->registerFont([
                'family' => self::FAMILY,
                'weight' => $font['weight'],
                'style'  => 'normal',
            ], 'file://'.str_replace('\\', '/', $dest));

            if (!$ok) $allOk = false;
        }

        // Note: font subsetting stays OFF - tested, it drops ₹ glyph (CIDToGID -> 0).
        // Full embed (~1.6MB) renders all symbols correctly.
        if ($allOk) self::$registered = true;
    }
}
