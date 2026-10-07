<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$report = \App\Models\Report::with(['reportType', 'customer.group', 'results.parameter'])->latest()->first();
$lab = \App\Models\LabSetting::first();
$pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.report', compact('report', 'lab'));
file_put_contents(__DIR__ . '/storage/app/test_details_v3.pdf', $pdf->output());
