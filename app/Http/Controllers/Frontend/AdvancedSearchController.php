<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TextFile;
use Illuminate\Http\Request;

class AdvancedSearchController extends Controller
{
    public function index()
    {
        return view('page.search.a-search');
    }

    public function advancedSearch(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            // ค้นหาใน Meilisearch
            $results = TextFile::search($query)->get();

            return view('page.search.a-search', compact('results', 'query'));
        }

        return view('page.search.a-search', ['results' => [], 'query' => '']);
    }
    
}
