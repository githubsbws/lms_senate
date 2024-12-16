@extends('admin/layouts/main')
@section('content')
    <body id="body">
        <div class="warpper">
            <div class="content">
                <main>
                    <div class="section">
                        <div class="section-header mb-3">
                            <h5 class="mb-0"></h5>
                        </div>
                        <div class="section-body">
                            <div class="card">
                                <div class="card-body">
                                    <table id="searchTable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">สมัยที่ประชุม</th>
                                                <th class="text-center">ปีที่ประชุม</th>
                                                <th class="text-center">ประเภทการประชุม</th>
                                                <th class="text-center">ครั้งที่ประชุม</th>
                                                <th class="text-center">ชื่อเอกสาร</th>
                                                <th class="text-center">รายละเอียด</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($file as $item)
                                                <tr>
                                                    <td class="text-center">{{ $item->period->name_type_period }}</td>
                                                    <td class="text-center">{{ $item->years->name_type_years }}</td>
                                                    <td class="text-center">{{ $item->cate->name_type_cate }}</td>
                                                    <td class="text-center">{{ $item->meet->name_type_meet }}</td>
                                                    <td class="text-center">{{ $item->file->name_file }}</td>
                                                    <td class="text-center">
                                                        {!! htmlspecialchars_decode(Str::limit(strip_tags($item->text), 150)) !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
@endsection
