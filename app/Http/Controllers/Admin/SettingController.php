<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Submenu;

use function Sodium\compare;

class SettingController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $menu = Submenu::where('active','y')->get();

            return view('admin.page.setting.menu.index',compact('menu'));
        }
        return view('admin.page.auth.login');
    }

    public function createMenu(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
        ]);

        // ตัวอย่างการบันทึก (สมมุติว่ามี Menu model)
        Submenu::create([
            'name_submenu' => $request->title,
            'link' => $request->url,
        ]);

        session()->put('success_menu', 'เพิ่มเมนูเรียบร้อยแล้ว');
        return redirect()->back();
    }

    public function submenu_del(Request $request,$id)
    {
        $survey = Submenu::findOrFail($id);

        // Update the status
        $survey->active = 'n';
        $survey->save();

        return redirect()->route('admin.setting');
    }
}