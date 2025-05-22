@extends('layout/mainlayout')
@section('content')
<head>
    <style>
        mark {
            background: 0%;
            color: red;
        }
        .detail-a {
            line-height: 1.5;
            margin: 10px 0;
        }
        
    </style>
</head>
<body>
    <div class="search_normal">
        <section class="banner-toggle">
            <div class="warp">
                <div class="card">
                    <p>ระบบสืบค้นข้อมูลรายงานการประชุม บันทึกการประชุม </p>
                    <p>และบันทึกการออกเสียงลงคะแนน ของสำนักงานเลขาธิการวุฒิสภา</p>
                    <div class="warp-toggle">
                        <a class="btn btn-light active" href="#">ค้นหารายงานการประชุม</a>
                        <a class="btn btn-light" href="{{route ('frontend.n_search') }}">ค้นหารายงานการประชุมขั้นสูง</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="search_advance main-form ">
            <div class="container">
                <div class="warp">
                    <div class="card text-center">
                        <h3>ค้นหารายงานการประชุม</h3>
                        <form action="{{ route('frontend.search')}}" method="GET">
                            <input type="text" class="form-control mt-4 mb-4" id="form1" name="search" aria-describedby="form1" placeholder="ค้นหารายงานการประชุม" value="{{request()->search}}" required>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">ค้นหา</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        @if (@$data)
            <section id="advance-content" class="advance-content mt-5">
                <div class="container">
                    <div class="head">
                        <div class="title">
                            <span>ผลการค้นหา :</span><span class="text-danger">{{ $words }}</span>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="result">
                             {{-- @php
                                $start = (($page - 1) * 10) + 1;
                                $end = min($start + 9, $totalHits);
                            @endphp
                            <p>การค้นหารายการที่ {{ $start }} - {{ $end }} จากผลการค้นหาทั้งหมด {{ $totalHits }} รายการของคำค้น "{{ $word }}"</p>
                            <p class="word"><span>ผลการค้นหา :</span><span class="text-danger">{{ $word }}</span></p> --}}
                            <p>จากผลการค้นหาทั้งหมด {{ $totalHits }} รายการของคำค้น "{{ $words }}"</p>
                            <p class="note">หมายเหตุ : เอกสารที่มีสัญลักษณ์    เป็นเอกสารที่ถูกแสกนเข้ามาในลักษณะของรูปภาพ ทำให้ไม่สามารถสืบค้นทั้งเอกสารได้ </p>
                            <p class="note">หากต้องการดูเนื้อหาของเอกสารทั้งหมดจะต้องคลิกเพื่อดาวน์โหลดเอกสารนั้นๆ</p>
                        </div>
                    </div>
                   
                    @foreach ($data as $search)
                        {{-- @php
                        dd($search)
                        @endphp --}}
                    <div class="card-resault card">
                        <p class="title">
                            {{ $search['_source']['cate'] }} > ครั้งที่ {{ $search['_source']['meet'] }} > 
                            {{ $search['_source']['date_meet'] ? \Carbon\Carbon::createFromFormat('Y-m-d', $search['_source']['date_meet'])
                                ->locale('th')->translatedFormat('วันlที่ j F') . ' ' . 
                                (\Carbon\Carbon::createFromFormat('Y-m-d', $search['_source']['date_meet'])->year + 543) : ' '; 
                            }}
                        </p>
                        <div class="find">
                            {{-- <span class="text-success">{{ $word }} </span> <span>ค้นพบ {{$search['word_count']}} แห่ง</span> --}} {{-- 00 --}} 
                        </div>
                        <div class="detail-a">
                            @if(isset($search['highlight']['text']))
                                @foreach($search['highlight']['text'] as $highlightedText)
                                    <span>{!! $highlightedText !!}</span>
                                @endforeach
                            @else
                                <span>{{ $search['_source']['text'] }}</span>
                            @endif
                            
                        </div>
                        <div class="group">
                            <p>
                                <span style="color:red">จากเอกสาร {{ $search['_source']['file'] }} หน้าที่ {{ $search['_source']['page'] }}</span>
                            </p>
                        </div>

                        <div class="group">
                            <div class="wrap-btn">
                                @if (($search['_source']['cate_id'] && $search['_source']['meet_id']) != null)                                  
                                    <a href="{{ route('frontend.relatefile', ['id' => $search['_source']['cate_id'],
                                        'years' => $search['_source']['year'],
                                        'meet' => $search['_source']['meet_id'],
                                        'filename' => $search['_source']['file'],
                                        'date' => $search['_source']['date_meet']
                                        ])}}" class="btn btn-primary text-white">
                                        ดูเอกสารที่เกี่ยวข้องทั้งหมด
                                    </a>
                                @else
                                @endif
                                <button type="button" class="btn btn-primary view-file" 
                                    data-fileid= " {{ $search['_source']['file_id'] }} "
                                    data-filename = " {{ $search['_source']['file'] }} "
                                    data-datetime = " {{ \Carbon\Carbon::parse($search['_source']['date_meet'])->translatedFormat('lที่ j F'). ' ' . 
                                    (\Carbon\Carbon::createFromFormat('Y-m-d', $search['_source']['date_meet'])->year + 543) }} ">ดูคำที่ค้นพบทั้งหมด
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                
        </section>
        @endif
</body>

<!-- Bootstrap Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white bg-primary" id="modal-header">
                <h5 class="modal-title">ผลลัพธ์ที่พบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modal-content">
                    <p>กำลังโหลดข้อมูล...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // console.log(document.querySelectorAll('.view-file').length); // เช็คว่าเจอปุ่มหรือไม่
        document.querySelectorAll('.view-file').forEach(button => {
            button.addEventListener('click', function () {
                console.log("true");
                let fileId = this.getAttribute('data-fileid');
                let filename = this.getAttribute('data-filename');
                let dateMeet = this.getAttribute('data-datetime');
                let query = "{{ request('search')}}";
                let modalHeader = document.getElementById('modal-header');
                let modalContent = document.getElementById('modal-content');
                console.log(dateMeet); 
                console.log(query); 

                modalContent.innerHTML = "<p>กำลังโหลดข้อมูล...</p>";

                fetch(`/frontend/search_by_file?search=${encodeURIComponent(query)}&fileId=${encodeURIComponent(fileId)}`,{
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data.data);

                    let resultHtmlHeader = "";
                    let resultHtmlContent = "";

                    resultHtmlHeader += `
                        <div class="modal-header text-white bg-primary d-flex flex-column w-100" 
                            id="modal-header" style="border-bottom: none !important; gap: 5px; word-break: break-word;">
                            <div class="d-flex justify-content-between w-100 align-items-center">
                                <h5 class="modal-title mb-0 text-wrap">
                                    ผลการค้นหา "<mark>${query}</mark>" ในเอกสาร ${filename}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" ></button>
                            </div>
                            <h5 class="modal-title mb-0 text-wrap">วัน ${dateMeet}</h5>
                        </div>
                    `;

                    data.data.forEach(item => {
                        resultHtmlContent += `
                            <div class="card" style="padding: 10px; margin-bottom: 10px;">
                                <p><strong>หน้า:</strong> ${item._source.page} 
                                    <a href="{{ asset ('uploads/pdf/${item._source.name_file}#page=${item._source.page}') }}" class="link-primary" target="_blank" style="color: blue !important; text-decoration: underline !important;">
                                        (คลิกเพื่อดูเอกสารหน้าที่ ${item._source.page})
                                    </a>
                                </p>
                                <p>ตำแหน่งคำค้น <mark>${query}</mark></p>
                                <p>...${item.highlight.text}...</p>
                            </div>
                        `;
                    });
                    modalHeader.innerHTML = resultHtmlHeader;
                    modalContent.innerHTML = resultHtmlContent;
                })
                .catch(error =>{
                    modalHeader.innerHTML = "<p>เกิดข้อมผิดพลาดในการโหลดข้อมูล</p>"
                    modalContent.innerHTML = "<p>เกิดข้อมผิดพลาดในการโหลดข้อมูล</p>"
                });
                let searchModal = new bootstrap.Modal(document.getElementById('searchModal'));
                searchModal.show();
            });
        });
    });
</script>