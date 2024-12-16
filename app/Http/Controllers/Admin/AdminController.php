<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AdminController extends Controller
{
    public function index()
    {
        if(Auth::check()){

            return view('admin.page.index');
        }
        return view('admin.page.auth.login');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput($request->only('username'));
            }
            // ตรวจสอบความถูกต้องของข้อมูลผู้ใช้งาน
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                return redirect()->intended('/admin');
            } else {
                // Authentication failed
                return back()->withErrors(['username' => 'username or password is incorrect']);
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // ล็อกเอาท์ผู้ใช้
        $request->session()->invalidate(); // ทำให้ session ปัจจุบันเป็นโมฆะ
        $request->session()->regenerateToken(); // ป้องกัน CSRF หลัง logout

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}