<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Approve;


class RequestController extends Controller
{
    public function index()
    {
        if(Auth::check()){

            $request = Approve::where('active','y')->get();

            return view('admin.page.report.request.index',compact('request'));
        }
        return view('admin.page.auth.login');
    }
}