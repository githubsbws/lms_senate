<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchApiController extends Controller
{
    public function searchQuery(Request $request)
    {
        // รับข้อมูลจาก body
        $payload = $request->all();

        // ยิงไปยัง API ภายนอก (เปลี่ยน URL ตามต้องการ)
        $response = Http::post('https://httpbin.org/post', $payload);

        // ส่ง response กลับ
        return response()->json([
            'success' => true,
            'your_input' => $payload,
            'api_response' => $response->json()
        ]);
    }

    public function searchRequest(Request $request)
    {
        if($request->input())
        {
            // รับข้อมูลจาก body
            $dateMeet = $request->input('dateMeet');       // อาจ null ได้
            $meet = $request->input('meet');       // อาจ null ได้
            $years = $request->input('year');         // เพิ่ม field ได้ตามต้องการ

            $dateMeetParse = \Carbon\carbon::parse($dateMeet)->subYears(543)->format('Y-m-d');
            
            $query = File::where('active','y');
            if($dateMeet)
            {
                $query->where('date_meet',$dateMeetParse);
            }
            
            if($meet)
            {
                $query->whereHas('meet', function ($q) use ($meet) {
                    $q->where('name_type_meet', $meet);
                });
            }

            if($years)
            {
                $query->where('years',$years);
            }

            $results = $query->get();
            if($results)
            {
                return response()->json([
                    'success' => true,
                    'results' => $results
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'results' => "no data"
                ]);
            }
           
        }
        return response()->json([
                'success' => false,
                'results' => "no input data"
            ]);
    }
}
