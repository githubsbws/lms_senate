<?php

namespace App\Http\Controllers;

use App\Mail\RegisterSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    //
    public function index(){
        // if(Auth::check()){

        //     return view('page.index');
        // }
        return view('register');
    }

    public function store(Request $request)
    {
        // Validation ข้อมูลจากฟอร์ม
        $validator = $request->validate([
            'username' => 'required|string|min:4|regex:/^[a-zA-Z0-9]+$/|unique:user,username',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'id_card' => 'required|string|unique:user,id_card',
            'dob_day' => 'required|integer|min:1|max:31',
            'dob_month' => 'required|integer|min:1|max:12',
            'dob_year' => 'required|integer|min:1900|max:' . (now()->year + 543),
            'employee_type' => 'required|integer',
            'external_detail' => 'nullable|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:8',
            'name_title' => 'required|string',
        ]);
        // if ($this->idcardValidate($request->input('id_card')) == false) {
        //     session()->put('error', 'เลขบัตรประชาชนนี้ ไม่ถูกต้องตามหลักทะเบียนราษฎ์');
        //     return back()->withErrors($validator)->withInput();
        // }
        // if($validator->fails())
        // {

        // }


        // สร้างวันที่จากวัน เดือน ปี
        $dob = sprintf('%04d-%02d-%02d', $request->dob_year, $request->dob_month, $request->dob_day);

        // บันทึกข้อมูลลงในฐานข้อมูล
        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->id_card = str_replace('-','',$request->id_card);
        $user->dob = $dob;
        $user->employee_type = $request->employee_type;
        $user->create_date = now();

        // ตรวจสอบว่า "employee_type" เป็น 3 หรือไม่
        if ($request->employee_type == 3) {
            $user->external_detail = $request->external_detail; // ถ้าเป็น 3 ให้เพิ่ม "external_detail"
        }

        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->name_title = $request->name_title;

        // ลองบันทึกข้อมูล
        try {
            $user->save();
            //ส่งเมล
            Mail::to($user->email)->send(new RegisterSuccess($user));
            // ส่ง success message
            session()->put('success', 'ลงทะเบียนสำเร็จ');
            return redirect()->route('login');
        } catch (\Exception $e) {
            // ถ้ามีข้อผิดพลาดในการบันทึกข้อมูล
            session()->put('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล');
            return back()->withErrors($validator)->withInput(); // กลับไปที่ฟอร์มพร้อมข้อมูลที่กรอกไว้
        }
    }

    public function idcardValidate($id)
    {
        // ตัดเครื่องหมาย - ออกจาก $id
        $id = str_replace('-', '', $id);

        // ตรวจสอบความยาวของ $id
        if (strlen($id) !== 13) {
            return false; // หากความยาวไม่ถูกต้อง
        }

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += intval(substr($id, $i, 1)) * (13 - $i);
        }

        if ((11 - ($sum % 11)) % 10 !== intval(substr($id, 12, 1))) {
            return false; // หากหมายเลขไม่ถูกต้อง
        }

        return true; // หากหมายเลขถูกต้อง
    }

    public function checkUsername(Request $request)
    {
        $username = $request->input('username');

        $user = User::where('username', $username)->first();

        if ($user) {
            // พบ username แล้ว
            return response()->json(['exists' => true]);
        } else {
            // ไม่พบ username
            return response()->json(['exists' => false]);
        }
    }

    public function checkEmail(Request $request)
    {
        $reciveEmail = $request->input('email');

        $email = User::where('email', $reciveEmail)->first();

        if ($email) {
            // พบ email แล้ว
            return response()->json(['exists' => true]);
        } else {
            // ไม่พบ email
            return response()->json(['exists' => false]);
        }
    }

    public function checkIdent(Request $request)
    {
        $identification = $request->input('idCard');
        $idCard = User::where('id_card', $identification)->first();

        if ($idCard) {
            // พบ idcard แล้ว
            return response()->json(['exists' => true]);
        } else {
            // ไม่พบ idcard
            return response()->json(['exists' => false]);
        }
    }
}
