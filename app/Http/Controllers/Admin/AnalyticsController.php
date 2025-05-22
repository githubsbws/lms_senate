<?php

namespace App\Http\Controllers;

use App\Services\GoogleAnalyticsService;

class AnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(GoogleAnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function index()
    {
        $activeUsers = $this->analyticsService->getActiveUsers();
        return view('analytics', compact('activeUsers'));
    }
}
