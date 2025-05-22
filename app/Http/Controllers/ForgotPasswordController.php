<?php

namespace App\Http\Controllers;

use App\Mail\MailForgotPassword;
use App\Models\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function forgotPassword()
    {
        return view('forgotpass');
    }

    public function otpSendToMail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $emails = $request->input('email');
        $otp = rand(100000, 999999);

        $forgotpassData = new ForgotPassword();
        $forgotpassData->email = $emails;
        $forgotpassData->otp = $otp;
        $forgotpassData->created_at = now();
        $forgotpassData->expires_at = now()->addMinutes(2);

        try {
            $forgotpassData->save();
            //ส่งเมล
            Mail::to($emails)->send(new MailForgotPassword($otp));
            session()->put('otp_sent', true);
            session()->put('email', $emails);
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'OTP sent']);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            // ถ้ามีข้อผิดพลาดในการบันทึกข้อมูล
            Log::error('ForgotPassword save error: '.$e->getMessage());
            session()->put('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล');
            return redirect()->back(); // กลับไปที่ฟอร์มพร้อมข้อมูลที่กรอกไว้
        }
    }

    public function chkEmailVerify(Request $request)
    {
        $getEmail = $request->input('email');

        $emailVerify = User::where('email',$getEmail)->orderBy('id', 'desc')->first();

        if (!$emailVerify) {
            return response()->json(['not_found' => true]);
        }

        if ($emailVerify->person_id != null) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function chkOtp(Request $request)
    {
        $getEmailOtp = $request->input('email');
        $getOtp = $request->input('otp');

        $otpVerify = ForgotPassword::where('email',$getEmailOtp)->orderBy('id', 'desc')->first();

        if ($otpVerify->expires_at > now()) {
            return response()->json(['expire' => true]);
        }

        if ($otpVerify->otp == $getOtp) {
            return response()->json(['exists' => false]);
        }else{
            return response()->json(['exists' => true]);
        }

    }

    public function otpVerify(Request $request)
    {
        $getEmailFinal = $request->input('email');
        $getOtpFinal = $request->input('otpverify');
        $getOtpData = ForgotPassword::where('email',$getEmailFinal)->orderBy('id', 'desc')->first();
        if($getOtpFinal == $getOtpData->otp){
            session()->forget('otp_sent');
            session()->forget('email');

            session()->put('otp_pass',true);
            session()->put('email',$getEmailFinal);
            return redirect()->back();
        }else{
            session()->put('error', 'เกิดข้อผิดพลาดในการตรวจสอบ');
            return redirect()->back();
        }

    }

    public function renewPassword(Request $request)
    {
        $getEmailUser = $request->input('email');
        $getRenewPassword = $request->input('renewpassword');

        $getUserData = User::where('email',$getEmailUser)->first();

        $getUserData->password = Hash::make($getRenewPassword);

        if($getUserData->update())
        {
            session()->forget('otp_pass');
            session()->forget('email');

            session()->put('success','เปลี่ยนรหัสผ่านสำเร็จ');
            return redirect()->route('login');
        }else{
            session()->put('error', 'เกิดข้อผิดพลาดในบันทึก');
            return redirect()->back();
        }
    }
}
