<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\GoogleAnalyticsService;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    // public function index()
    // {
    //     if(Auth::check()){

    //         return view('admin.page.dashboard.index');
    //     }
    //     return view('admin.page.auth.login');
    // }

    protected $analyticsService;

    public function __construct(GoogleAnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function index()
    {
        $labelMap = [
            5 => 'พอใจมากที่สุด',
            4 => 'พอใจมาก',
            3 => 'พอใจปานกลาง',
            2 => 'พอใจน้อย',
            1 => 'ไม่พึงพอใจ'
        ];

        $data = DB::table('survey_responses')
        ->whereNotNull('scale_value')
        ->select('scale_value', DB::raw('count(*) as total'))
        ->groupBy('scale_value')
        ->orderBy('scale_value')
        ->get();

    // แปลงให้อยู่ในรูปแบบที่ Chart.js ใช้ได้
        $labels = $data->pluck('scale_value')->map(fn($v) => $labelMap[$v]);
        $totals = $data->pluck('total');

        $activeUsers = $this->analyticsService->getActiveUsers();
        return view('admin.page.dashboard.index', compact('activeUsers','labels', 'totals'));
    }
}