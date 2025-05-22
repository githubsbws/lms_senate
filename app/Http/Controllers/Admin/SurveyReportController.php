<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyReportController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            return view('admin.page.report.surveyreport.index');
        }
        return view('admin.page.auth.login');
    }
}
