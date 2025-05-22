<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Elastic\Elasticsearch\ClientBuilder;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        // $client = ClientBuilder::create()
        //     ->setHosts([config('scout.elasticsearch.host')])  // แก้ไขเป็น array
        //     ->setBasicAuthentication(config('scout.elasticsearch.user'), config('scout.elasticsearch.pass'))
        //     ->build();

        // dd($client);

        return view('page.index');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // ล็อกเอาท์ผู้ใช้
        $request->session()->invalidate(); // ทำให้ session ปัจจุบันเป็นโมฆะ
        $request->session()->regenerateToken(); // ป้องกัน CSRF หลัง logout

        return response()->json(['message' => 'Logged out successfully'], 200);
        
    }

    public function apiMenuFile($doc,$year)
    {
        $query = File::where('doc_id',$doc)->where('active','y')->orderBy('date_meet','DESC')->limit(20);
        if ($year == 2559) {
            $query->whereBetween('years', [2535, 2559]);
        } else {
            $query->where('years', $year);
        }
        $formatted = $query->get()->map(function ($file) {
            $date = \Carbon\Carbon::createFromFormat('Y-m-d', $file->date_meet)->locale('th')->translatedFormat('วันlที่ j F Y');

            $date = preg_replace_callback('/\d{4}/', function ($matches) {
                return $matches[0] + 543; // เพิ่ม 543 ปีในกรณีที่พบปี ค.ศ.
            }, $date);

            return [
                'name' => '- '.$file->type_name.' '.$date,
                'url' => asset('uploads/pdf/' . $file->name_file),
            ];
        });
        return response()->json(['files' => $formatted]);
    }
}