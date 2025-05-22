<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SynonymController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            $content = Storage::disk('public')->exists('synonym/synonym.txt') 
                ? Storage::disk('public')->get('synonym/synonym.txt') 
                : '';
            return view('admin.page.synonym.index',compact('content'));
        }
        return view('admin.page.auth.login');
    }

    public function update(Request $request)
    {
        $request->validate([
            'synonym' => 'required|string'
        ]);
         // เขียนไฟล์ใหม่ลงใน storage/app/public/synonym/synonym.txt
        $test = Storage::disk('public')->put('synonym/synonym.txt', $request->input('synonym'));
        session()->put('success','บันทึกไฟล์เรียบร้อยแล้ว');
        return redirect()->back();
    }
}
