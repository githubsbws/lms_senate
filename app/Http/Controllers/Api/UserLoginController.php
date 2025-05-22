<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserLoginController extends Controller
{
    public function testApiLogin(Request $request)
    {
        $response = Http::post('https://webservice.senate.go.th/app/user/authen', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $data = $response->json();

        if ($response->successful()) {
            // ประมวลผลข้อมูล $data ต่อ
            // $data = $response->json();
            return response()->json([
                    'status'=>'result',
                    'message'=> $data
                ]);
            // ประมวลผลข้อมูล $data ต่อ
        }
    }
}
