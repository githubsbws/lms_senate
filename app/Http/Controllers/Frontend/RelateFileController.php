<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\TextFile;
use App\Models\TypeCate;
use Illuminate\Http\Request;
use Meilisearch\Endpoints\Indexes;

class RelateFileController extends Controller
{
    public function index (Request $request)
    {
        $file_name = $request->filename;
        $date_meet = $request->date;
        $cate_id = $request->id;
        $years = $request->years;
        $meet_id = $request->meet;

        $query = $this->loadModel($cate_id,$years,$meet_id);
        // dd($query);
        return view('page.search.relatefile', compact('query','file_name','date_meet'));
    }

    public function loadModel($cate_id,$years,$meet_id)
    {
        $results = File::where('cate_id', $cate_id)
        ->where('years', $years)
        ->where('meet_id',$meet_id)
        ->get();

        return $results;
    }
}
