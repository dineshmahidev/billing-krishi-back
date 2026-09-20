<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $total = Report::count();
        $today = Report::whereDate('created_at', now()->toDateString())->count();
        $month = Report::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $recent = Report::with(['reportType','creator'])->latest()->take(10)->get();
        return response()->json([
            'metrics'=>[
                'total_reports'=>$total,
                'today_reports'=>$today,
                'month_reports'=>$month,
            ],
            'recent_reports'=>$recent
        ]);
    }
}
