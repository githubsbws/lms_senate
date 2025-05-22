<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TextFile;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use ONGR\ElasticsearchDSL\Query\TermLevel\FuzzyQuery;

class AdvancedSearchController extends Controller
{
    public function index()
    {
        return view('page.search.a-search');
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $fileId = $request->input('fileId');
        $words = $query;
        // $search_terms = explode(' ', $query);
        // dd($fileId);
    
        // เชื่อมต่อกับ Elasticsearch
        
        $client = ClientBuilder::create()->setHosts(['localhost:9200'])
        ->setBasicAuthentication(config('scout.elasticsearch.user'), config('scout.elasticsearch.pass'))->build();
            $params = [
            'index' => 'textfile',
            'body'  => [
                'size' => 50,
                'track_scores' => true,
                'query' => [
                    'bool' => [
                        'should' => [
                            // การจับคู่วลีที่ตรงกันพอดี (ความสำคัญสูงสุด)
                            [
                                'match_phrase' => [
                                    'text' => [
                                        'query' => $query,
                                        'boost' => 3.0, // ให้คะแนนการตรงกันพอดีสูงขึ้น
                                    ]
                                ]
                            ],
                            // ทุกคำต้องตรงกัน
                            [
                                'match' => [
                                    'text' => [
                                        'query' => $query,
                                        'operator' => 'AND',
                                        'boost' => 2.0,
                                    ]
                                ]
                            ],
                            // เพิ่มการค้นหาแบบ wildcard เพื่อหาคำที่มีคำค้นหาเป็นส่วนหนึ่ง
                            // คำใดคำหนึ่งตรงกันก็ได้ (ความสำคัญต่ำสุด)
                            
                            [
                                'match' => [
                                    'text' => [
                                        'query' => $query,
                                        'operator' => 'OR',
                                        'boost' => 1.0,
                                    ]
                                ]
                            ],

                            [
                                'wildcard' => [
                                    'text' => [
                                        'value' => "*$query*",
                                        'boost' => 0.7,
                                        
                                    ]
                                ]
                            ],
                        ],
                        'minimum_should_match' => '70%',
                        
                    ]
                ],

               'highlight' => [
                    'fields' => [
                        'text' => new \stdClass(),
                    ],
                    'type' => 'unified',
                    'pre_tags' => ['<mark>'],
                    'post_tags' => ['</mark>'],
                    'fragment_size' => 200,
                    'number_of_fragments' => 3,
                    'boundary_scanner' => 'sentence',
                    'boundary_scanner_locale' => 'th-TH',
                    'require_field_match' => false,
                ],
                'sort' => [
                    ['date_meet' => ['order' => 'desc']], // ✅ เพิ่มเงื่อนไขการเรียงลำดับตรงนี้
                    ['_score' => ['order' => 'desc']],
                ],
                // 'terminate_after' => 50
    
            ]
        ];
        //ดูแบบทีละไฟล์
        if ($fileId) {
            $params['body']['query']['bool']['filter'] = [
                ['term' => ['file_id' => $fileId]]
            ];
        }

        // ค้นหาผ่าน Elasticsearch Client
        // dd($params);
        $results = $client->search($params);
        $data = $results['hits']['hits'];
        $totalHits = count($data);
        // dd($data);
        
        // foreach ($data as $key => $hit) {
        //     // ดึงข้อความต้นฉบับจากผลลัพธ์
        //     if (isset($hit['highlight']['text'])) {
        //         $highlightedText = $hit['highlight']['text'];

        //         $queryWords = preg_split('/\s+/u', trim($query)); // แยกคำตามช่องว่าง
        //         // dd($queryWords);
        //         // ปรับปรุงการ highlight ใหม่
        //         foreach ($highlightedText as $i => $fragment) {
        //             // ลบ highlight เดิมทั้งหมด
        //             $plainText = strip_tags($fragment);
        //             // สร้าง highlight ใหม่เฉพาะคำค้นหาที่เป๊ะๆ
        //             foreach($queryWords as $word)
        //             {
        //                 if(!empty($word))
        //                 {
        //                     $plainText = preg_replace('/(' . preg_quote($word, '/') . ')/ui', '<mark>$1</mark>', $plainText);
        //                 }
        //             }
        //             $highlightedText[$i] = $plainText;
        //         }
                
        //         // อัปเดตข้อมูล highlight
        //         $data[$key]['highlight']['text'] = $highlightedText;
        //     }
        //     // $text = $hit['highlight']['text'][0];
        //     // $wordCount = preg_match_all('/(' . preg_quote($query, '/') . ')/ui', $text);
        //     // // dd($wordCount);
        //     // $data[$key]['word_count'] = $wordCount;
        // }

        //หากมีการขอ จาก Ajax
        if ($request->ajax()) {
            return response()->json([
                'status' => 'Success',
                'data' => $data,
                'totalHits' => $totalHits
            ]);
        }

        // dd($data);
        return view('page.search.a-search', compact('data','words','totalHits'));
        
    }
    //backup code
    // public function search(Request $request)
    // {
    //     $query = $request->input('search');
    //     $fileId = $request->input('fileId');
    //     $words = $query;
    //     // dd($fileId);
    
    //     // เชื่อมต่อกับ Elasticsearch
        
    //     $client = ClientBuilder::create()->setHosts(['localhost:9200'])
    //     ->setBasicAuthentication(config('scout.elasticsearch.user'), config('scout.elasticsearch.pass'))->build();
    //     $params = [
    //         'index' => 'textfile',
    //         'body'  => [
    //             'size' => 50,
    //             'query' => [
    //                 'bool' => [
    //                     'should' => [
    //                         // การจับคู่วลีที่ตรงกันพอดี (ความสำคัญสูงสุด)
    //                         [
    //                             'match_phrase' => [
    //                                 'text' => [
    //                                     'query' => $query,
    //                                     'boost' => 3.0, // ให้คะแนนการตรงกันพอดีสูงขึ้น
    //                                 ]
    //                             ]
    //                         ],
    //                         // ทุกคำต้องตรงกัน
    //                         [
    //                             'match' => [
    //                                 'text' => [
    //                                     'query' => $query,
    //                                     'operator' => 'AND',
    //                                     'boost' => 2.0
    //                                 ]
    //                             ]
    //                         ],
    //                         // เพิ่มการค้นหาแบบ wildcard เพื่อหาคำที่มีคำค้นหาเป็นส่วนหนึ่ง
    //                         // คำใดคำหนึ่งตรงกันก็ได้ (ความสำคัญต่ำสุด)
                            
    //                         [
    //                             'match' => [
    //                                 'text' => [
    //                                     'query' => $query,
    //                                     'operator' => 'OR',
    //                                     'boost' => 1.0
    //                                 ]
    //                             ]
    //                         ],

    //                         [
    //                             'wildcard' => [
    //                                 'text' => [
    //                                     'value' => "*$query*",
    //                                     'boost' => 0.7
    //                                 ]
    //                             ]
    //                         ],
    //                     ],
    //                     'minimum_should_match' => 1
    //                 ]
    //             ],
    //             'highlight' => [
    //                 'fields' => [
    //                     'text' => new \stdClass(), // กำหนดให้ field "text" เป็นการทำ highlight
    //                 ],
    //                 'type' => 'unified', 
    //                 'pre_tags' => ['<mark>'], // กำหนด tag ที่ใช้ในการเน้นคำที่ตรงกัน
    //                 'post_tags' => ['</mark>'], // ปิด tag หลังจากเน้นคำ
    //                 'fragment_size' => 200, // ขนาดของ fragment ที่จะแสดง
    //                 'number_of_fragments' => 3, // จำนวน fragments ที่จะดึงมาจากข้อความ
    //                 'boundary_scanner' => 'sentence',
    //                 'boundary_scanner_locale' => 'th-TH', // ระบุภาษาไทยเพื่อให้การแบ่ง fragment เหมาะสม
    //                 'require_field_match' => false
    //             ],
    //             'sort' => [
    //                 ['date_meet' => ['order' => 'desc']] // ✅ เพิ่มเงื่อนไขการเรียงลำดับตรงนี้
    //             ],
    //             // 'terminate_after' => 50
    
    //         ]
    //     ];
    //     //ดูแบบทีละไฟล์
    //     if ($fileId) {
    //         $params['body']['query']['bool']['filter'] = [
    //             ['term' => ['file_id' => $fileId]]
    //         ];
    //     }

    //     // ค้นหาผ่าน Elasticsearch Client
    //     // dd($params);
    //     $results = $client->search($params);
    //     $data = $results['hits']['hits'];
    //     $totalHits = count($data);

    //     foreach ($data as $key => $hit) {
    //         // ดึงข้อความต้นฉบับจากผลลัพธ์
    //         if (isset($hit['highlight']['text'])) {
    //             $highlightedText = $hit['highlight']['text'];

    //             $queryWords = preg_split('/\s+/u', trim($query)); // แยกคำตามช่องว่าง
    //             // dd($queryWords);
    //             // ปรับปรุงการ highlight ใหม่
    //             foreach ($highlightedText as $i => $fragment) {
    //                 // ลบ highlight เดิมทั้งหมด
    //                 $plainText = strip_tags($fragment);
    //                 // สร้าง highlight ใหม่เฉพาะคำค้นหาที่เป๊ะๆ
    //                 foreach($queryWords as $word)
    //                 {
    //                     if(!empty($word))
    //                     {
    //                         $plainText = preg_replace('/(' . preg_quote($word, '/') . ')/ui', '<mark>$1</mark>', $plainText);
    //                     }
    //                 }
    //                 $highlightedText[$i] = $plainText;
    //             }
                
    //             // อัปเดตข้อมูล highlight
    //             $data[$key]['highlight']['text'] = $highlightedText;
    //         }
    //         // $text = $hit['highlight']['text'][0];
    //         // $wordCount = preg_match_all('/(' . preg_quote($query, '/') . ')/ui', $text);
    //         // // dd($wordCount);
    //         // $data[$key]['word_count'] = $wordCount;
    //     }

    //     //หากมีการขอ จาก Ajax
    //     if ($request->ajax()) {
    //         return response()->json([
    //             'status' => 'Success',
    //             'data' => $data,
    //             'totalHits' => $totalHits
    //         ]);
    //     }

    //     // dd($data);
    //     return view('page.search.a-search', compact('data','words','totalHits'));
        
    // }

}
