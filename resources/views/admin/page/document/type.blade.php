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
                                                <th class="text-center">รัฐธรรมนูญแห่งราชอาณาจักรไทย</th>
                                                <th class="text-center">ข้อบังคับการประชุม</th>
                                                <th class="text-center">วันที่ประชุม</th>
                                                <th class="text-center">ชื่อเอกสาร</th>
                                                <th class="text-center">ชื่อไฟล์</th>
                                                <th class="text-center">ประเภทเอกสาร</th>
                                                <th class="text-center">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
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
    <script>
        $(document).ready(function() {
            $('#searchTable').DataTable({
                serverSide: true, // เปิดใช้งาน Server-Side Processing
                processing: true, // แสดง Loading Animation
                ajax: "{{ route('admin.file_data') }}", // URL ของ API สำหรับดึงข้อมูล
                columns: [
                    { data: 'period_name', name: 'file.period_id' },
                    { data: 'years', name: 'file.years' },
                    { data: 'cate_name', name: 'file.cate_id' },
                    // { data: 'date_meet', name: 'file.date_meet' },
                    { data: 'meet_name', name: 'file.meet_id' },
                    { data: 'con_name', name: 'file.con_id' },
                    { data: 'rule_name', name: 'file.rule_id' },
                    { data: 'date_meet', name: 'file.date_meet' },
                    { data: 'type_name', name: 'file.type_name' },
                    { data: 'name_file', name: 'file.name_file' },
                    { data: 'doc_name', name: 'file.doc_id' },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    url: '/includes/languageDataTable.json' // ระบุไฟล์ JSON สำหรับข้อความภาษา
                },
                pageLength: 10 // ตั้งค่าจำนวนข้อมูลต่อหน้า
            });
        });
    </script>
@endsection
