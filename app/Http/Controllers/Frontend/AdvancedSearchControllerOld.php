<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TextFile;
use Illuminate\Http\Request;
use Meilisearch\Client;

class AdvancedSearchOldController extends Controller
{

    public function index()
    {
        return view('page.search.a-search');
    }

    public function viewSettingMeilisearch()
    {
        $client = new Client(env('MEILISEARCH_HOST', 'http://localhost:7700'), env('MEILISEARCH_KEY'));

        // เลือก index
        $index = $client->index('textfile');

        // ดึงการตั้งค่า index ปัจจุบัน
        $settings = $index->getSettings();

        // แสดงผลการตั้งค่าปัจจุบัน
        dd($settings);
    }

    public function updateMeilisearchAttributes() {
        // เชื่อมต่อกับ Meilisearch
        $client = new Client(env('MEILISEARCH_HOST', 'http://localhost:7700'), env('MEILISEARCH_KEY'));
        $index = $client->index('textfile');

        try {
            // อัปเดต filterable attributes ให้มี 'active'
            $index->updateFilterableAttributes(['active']);

            // $index->updateRankingRules([
            //     'exactness',   // ความแม่นยำของคำที่ค้นหา
            //     'words',       // การค้นหาคำที่ตรง
            //     'typo',
            //     'proximity',
            //     'attribute',   // การค้นหาตาม attribute
            //     'sort'          // การจัดเรียง
            // ]);

            // $index->updateSettings([
            //     'typoTolerance' => [
            //         'enabled' => true, // ปิด typo tolerance
            //     ],
            //     'proximityPrecision' =>[
            //         'enabled' => true,
            //     ]
            // ]);

            $client->index('textfile')->updateSettings([
                'searchableAttributes' => ['text'], // ค้นหาเฉพาะ text
                'displayedAttributes' => ['id','text', 'file', 'period','period_id', 'cate', 'meet','years_id'], // แสดงฟิลด์อื่นๆ
            ]);
            


            return response()->json([
                'message' => 'Filterable attributes updated successfully',
                'filterableAttributes' => ['active']
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function search(Request $request)
    {
        $word = $request->input('search');
        $perPage = 10;
        $results = [];
        $totalHits = 0;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;

        if ($word) {
        // เชื่อมต่อกับ Meilisearch Client
        $client = new Client(env('MEILISEARCH_HOST', 'http://127.0.0.1:7700'), env('MEILISEARCH_KEY'));

        // ดึงข้อมูลพร้อม Highlight และกรองเฉพาะ active = 'y'
        $searchResults = $client->index('textfile')->search($word, [
            'attributesToHighlight' => ['text'],
            'highlightPreTag' => '<mark>',
            'highlightPostTag' => '</mark>',
            'showMatchesPosition' => true,
            'limit' => $perPage,
            'offset' => $offset,
            'filter' => 'active = "y"',

        ]);
        // dd($searchResults->getHits());

        $totalHits = $searchResults->getEstimatedTotalHits();
        $lastPage = ceil($totalHits / $perPage);

        $results = collect($searchResults->getHits())->map(function ($item) {
            // dd($item);exit();
            $fullText = $item['text'];
        
            // Get highlighted text with mark tags
            $highlightedText = strip_tags($item['_formatted']['text'] ?? $item['text'], '<mark>');
            
            // Split text into lines
            $lines = explode("\n", $highlightedText);
            
            // Find the first line with highlight
            $firstHighlightLineIndex = -1;
            foreach ($lines as $index => $line) {
                if (strpos($line, '<mark>') !== false) {
                    $firstHighlightLineIndex = $index;
                    break;
                }
            }
            
            // Get up to 3 lines of context (the highlighted line and up to 2 following lines)
            $contextLines = [];
            if ($firstHighlightLineIndex >= 0) {
                for ($i = $firstHighlightLineIndex; $i < min($firstHighlightLineIndex + 5, count($lines)); $i++) {
                    $contextLines[] = $lines[$i];
                }
            }
            
            // Join the context lines back together
            $contextText = implode("\n", $contextLines);
    
            return [
                'id' => $item['id'],
                'text' => $contextText, // Now contains only up to 3 lines with highlight
                'match_count' => isset($item['_matchesPosition']['text']) ? count($item['_matchesPosition']['text']) : 0,
                'cate' => $item['cate'] ?? "-",
                'file' => $item['file'] ?? "-",
                'period' => $item['period'] ?? "-",
                'period_id' =>$item['period_id'],
                'years_id' => $item['years_id'],
                'meet' => $item['meet'] ?? "-",
            ];

        });
        // dd($results);
        return view('page.search.a-search', compact('results', 'word','totalHits', 'page','lastPage'));
        
        }
        return view('page.search.a-search', ['results' => [], 'query' => '']);
    }
    
}





