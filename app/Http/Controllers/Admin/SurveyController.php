<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class SurveyController extends Controller
{
    public function index()
    {
        if(Auth::check()){

            return view('admin.page.setting.survey.index');
        }
        return view('admin.page.auth.login');
    }
}