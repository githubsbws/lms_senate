<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\TypeYears;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $getQuery = null;
        $search = $this->loadModel();
        if(!empty($request->all()))
        {
            $getQuery = $this->querySearch($request);
            // dd($getQuery);
        }
        
        return view('page.search.n-search',compact('search','getQuery'));
    }

    public function loadModel()
    {
        $query = collect([
            'type_cate' => DB::table(DB::raw('v_type_cate'))->get(),
            'type_con' => DB::table(DB::raw('v_type_con'))->get(),
            'type_period' => DB::table(DB::raw('v_type_period'))->get(),
            'type_rule' => DB::table(DB::raw('v_type_rule'))->get(),
            'type_meet' => DB::table(DB::raw('v_type_meet'))->get()
        ]);

        // $cachedViews = Cache::remember('search_views', 3600, function () use ($query) {
        //     return $query->toArray();
        // });

        return $query;
    }

    // public function querySearch(Request $request)
    // {
        
    //     $meetName = $request->input('meet_name');
    //     $years = $request->input('years');
    //     $period = $request->input('period');
    //     $meet = $request->input('meet');
    //     $con = $request->input('con');
    //     $rule = $request->input('rule');
    //     $cate = $request->input('cate');
    //     $date = $request->input('date');

    //     $query = File::with(['period','cate','meet','con','rule'])
    //             ->where('active','y');

    //     if (!empty($meetName)) {
    //         $query->where('meet_name', 'LIKE', '%' . $meetName . '%');
    //     }
        
    //     if (!empty($years)) {
    //         $query->where('years', $years);
    //     }
        
    //     if (!empty($period)) {
    //         $query->where('period_id', $period);
    //     }
        
    //     if (!empty($meet)) {
    //         $query->where('meet_id', $meet);
    //     }
        
    //     if (!empty($con)) {
    //         $query->where('con_id', $con);
    //     }
        
    //     if (!empty($rule)) {
    //         $query->where('rule_id', $rule);
    //     }
        
    //     if (!empty($cate)) {
    //         $query->where('cate_id', $cate);
    //     }
        
    //     if (!empty($date)) {
    //         $query->where('date_meet', $date);
    //     }
        
    //     // ดึงข้อมูล
    //     $results = $query->paginate(10)->map(function ($item) {
    //         if (!empty($item->date_meet)) { // ตรวจสอบว่ามีค่า
    //             $item->date_meet = Carbon::parse($item->date_meet) // ใช้ได้ปกติ
    //                 ->locale('th')
    //                 ->translatedFormat('j F Y'); // 6 มีนาคม 2025
    //         }
    //         $item->period_name = $item->period ? $item->period->name_type_period : '-';
    //         $item->meet_name = $item->meet ? $item->meet->name_type_meet : '-';
    //         $item->con_name = $item->con ? $item->con->name_type_con : '-';
    //         $item->rule_name = $item->rule ? $item->rule->name_type_rule : '-';
    //         $item->cate_name = $item->cate ? $item->cate->name_type_cate : '-';
    //         return $item;
    //     });
        
    //     return response()->json($results);
    // }

    public function querySearch($request)
    {
        $meetName = $request->input('meetName');
        $years = $request->input('years');
        $period = $request->input('period');
        $meet = $request->input('meet');
        $con = $request->input('con');
        $rule = $request->input('rule');
        $cate = $request->input('cate');
        $date = $request->input('date');
        $searchKeyword = $request->input('search');

        $date = $request->input('date');
        // dd($date);
        if ($date) {
            // แปลงปีจาก พ.ศ. เป็น ค.ศ. (ลบ 543 ปี)
            $date = $this->convertToChristYear($date);
            // dd($date);
        }

        $query = File::with(['period','cate','meet','con','rule','textfile'])
                ->where('active','y')
                ->orderBy('date_meet','DESC');

        if (!empty($meetName)) {
            $query->where('type_name', 'LIKE', '%' . $meetName . '%');
        }
        
        if (!empty($years)) {
            $query->where('years', $years);
        }
        
        if (!empty($period)) {
            $query->where('period_id', $period);
        }
        
        if (!empty($meet)) {
            $query->where('meet_id', $meet);
        }
        
        if (!empty($con)) {
            $query->where('con_id', $con);
        }
        
        if (!empty($rule)) {
            $query->where('rule_id', $rule);
        }
        
        if (!empty($cate)) {
            $query->where('cate_id', $cate);
        }
        
        if (!empty($date)) {
            $query->where('date_meet', $date);
        }
        if (!empty($searchKeyword)) {
            // แยกคำด้วยช่องว่าง
            $keywords = preg_split('/\s+/', trim($searchKeyword));
        
            $query->whereHas('textfile', function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where('text', 'like', '%' . $word . '%');
                }
            });
        }
        // if (!empty($searchKeyword)) {
        //     $collection = $query->get(); // ดึงข้อมูลทั้งหมดก่อน
        //     $filtered = $collection->filter(function ($item) use ($searchKeyword) {
        //         return str_contains(strtolower($item->type_name), strtolower($searchKeyword)) ||
        //                str_contains(strtolower($item->summary ?? ''), strtolower($searchKeyword)) ||
        //                str_contains(strtolower($item->details ?? ''), strtolower($searchKeyword));
        //     });
    
        //     // แปลงเป็น LengthAwarePaginator เพื่อให้ใช้กับ paginate ได้
        //     $page = request()->get('page', 1);
        //     $perPage = 10;
        //     $pagedResults = new \Illuminate\Pagination\LengthAwarePaginator(
        //         $filtered->forPage($page, $perPage),
        //         $filtered->count(),
        //         $perPage,
        //         $page,
        //         ['path' => request()->url(), 'query' => request()->query()]
        //     );
    
        //     return $pagedResults;
        // }

        return $query->paginate(10)->appends($request->query());
    }

    private function convertToChristYear($date)
    {
        // แปลงวันที่ที่ได้จาก ไ.ศ. เป็น ค.ศ.
        $dateObj = new \DateTime($date);
        $year = $dateObj->format('Y'); // ปี ค.ศ.
        if($year < 2500) //ปี ค.ศ.
        {
            $buddhistYear = $year; // แปลงเป็น ค.ศ.
        }else if($year > 2500) {

            $buddhistYear = $year - 543; // แปลงเป็น พ.ศ.
        }
        // คืนค่าวันที่ในรูปแบบ "YYYY-MM-DD" หลังจากแปลงเป็น พ.ศ.
        return $dateObj->setDate($buddhistYear, $dateObj->format('m'), $dateObj->format('d'))->format('Y-m-d');
    }
}
