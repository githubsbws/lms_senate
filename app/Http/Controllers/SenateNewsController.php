<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SenateNewsController extends Controller
{
    public function news()
    {
        return view('page.news.senate_news');
    }
}
