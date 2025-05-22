<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutSenateController extends Controller
{
    public function orgChartSenate()
    {
        return view('page.about.org_senate');
    }
}
