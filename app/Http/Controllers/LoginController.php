<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    //
   public function index(Request $request)
    {
        // ตรวจสอบ session ก่อนทำการเข้าสู่ระบบ
        

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput($request->only('username'));
            }

            $credentials = $request->only('username', 'password');
            $remember = $request->has('remember');

            if ($remember) {
                Cookie::queue('remembered_username', $request->username, 43200); // 30 วัน
            } else {
                // ถ้าไม่เลือก remember ให้ลบ cookie
                Cookie::queue(Cookie::forget('remembered_username'));
            }

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if ($user->type_user_id == 6) {
                    return redirect()->intended('/admin');
                }
                return redirect()->route('index');
            }

            try {
                $response = Http::post('https://webservice.senate.go.th/app/user/authen', [
                    'username' => $request->username,
                    'password' => $request->password
                ]);

                if ($response->ok() && $response->json('message.success') === 'Login successful') {
                    // ดึงข้อมูลจาก response

                    $emailApi = $response->json('message.success.email'); // ปรับตามโครงสร้างจริงของ response
                    $personIdApi = $response->json('message.success.person_id');
                    $idcardTokenApi = $response->json('message.success.idcard');
                    // ตรวจว่ามี user นี้ใน DB หรือยัง
                    $user = User::where('username', $request->username)->first();

                    if (!$user) {
                        // สร้าง user ใหม่ในระบบ
                        $user = new User();
                        $user->username = $request->username;
                        $user->password = Hash::make($request->password);
                        $user->email = $emailApi;  
                        $user->person_id = $personIdApi;
                        $user->idcard_token = $idcardTokenApi;   
                    }

                    // ล็อกอินผู้ใช้เข้าระบบ
                    Auth::login($user);
                    return redirect()->route('index');
                }

            } catch (\Exception $e) {
                // ล็อก error ไว้สำหรับ debug
                Log::error('External Login Error: ' . $e->getMessage());
            }

            session()->put('loginError', 'ชื่อผู้ใช้หรือรหัสผ่านผิด');
            return redirect()->back()->withInput($request->only('username'));
        }
        $remembered_username = Cookie::get('remembered_username');
        return view('login',compact('remembered_username'));
    }

    // public function login(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $validator = Validator::make($request->all(), [
    //             'username' => 'required',
    //             'password' => 'required',
    //         ]);
    //         if ($validator->fails()) {
    //             return back()->withErrors($validator)->withInput($request->only('username'));
    //             // return back()->withErrors($validator)->withInput($request->only('username'));
    //         }
    //         // ตรวจสอบความถูกต้องของข้อมูลผู้ใช้งาน
    //         $credentials = $request->only('username', 'password');
    //         if (Auth::attempt($credentials)) {
    //             $user = Auth::user();
    //             // dd($user->type_user_id);
    //             if($user->type_user_id == 6){
    //                 return redirect()->intended('/admin');
    //             }
    //             return redirect()->route('index');
    //         } else {
    //            return redirect()->back()->with('loginError', 'ชื่อผู้ใช้หรือรหัสผ่านผิด');
    //         }
    //     }
    // }

    public function logout(Request $request)
    {
        Auth::logout(); // ล็อกเอาท์ผู้ใช้
        $request->session()->invalidate(); // ทำให้ session ปัจจุบันเป็นโมฆะ
        $request->session()->regenerateToken(); // ป้องกัน CSRF หลัง logout

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

}
