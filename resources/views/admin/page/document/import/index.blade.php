@extends('admin/layouts/main')
@section('content')
@php
$years = array_map(function ($year) {
    return $year + 543; // แปลงปี ค.ศ. เป็น พ.ศ.
}, range(date('Y'),1992));    
@endphp
<body id="body">
    <div class="warpper">
        <div class="content">
            <main>
                <div class="section">
                    <div class="section-header mb-3">
                        <h5 class="mb-2"></h5>
                        <div class="section d-flex mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#documentModal">
                                <i class="fa-solid fa-square-plus me-1"></i>
                                เพิ่มเอกสาร
                            </button>
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="col">
                                <label for="name" class="form-label">ชื่อเอกสาร</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="col">
                                <label for="name" class="form-label">สมัยที่ประชุม</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="col">
                                <label for="dateMeeting" class="form-label">ปีที่ประชุม</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <label for="MeetingCount" class="form-label">ครั้งที่ประชุม</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="col">
                                <label for="typeMeeting" class="form-label">ประเภทการประชุม</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="card">
                            <div class="card-body">
                                <table id="searchTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ชื่อเอกสาร</th>
                                            <th class="text-center">ปีที่ประชุม</th>
                                            <th class="text-center">สมัยที่ประชุม</th>
                                            <th class="text-center">ครั้งที่ประชุม</th>
                                            <th class="text-center">ประเภทการประชุม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">ชื่อเอกสาร</td>
                                            <td class="text-center">2567</td>
                                            <td class="text-center">วุฒิสภา ปีที่ 1  ปี พ.ศ. 2567</td>
                                            <td class="text-center">37</td>
                                            <td class="text-center">การประชุมวุฒิสภา</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">ชื่อเอกสาร</td>
                                            <td class="text-center">2567</td>
                                            <td class="text-center">วุฒิสภา ปีที่ 1  ปี พ.ศ. 2567</td>
                                            <td class="text-center">37</td>
                                            <td class="text-center">การประชุมวุฒิสภา</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">ชื่อเอกสาร</td>
                                            <td class="text-center">2567</td>
                                            <td class="text-center">วุฒิสภา ปีที่ 1  ปี พ.ศ. 2567</td>
                                            <td class="text-center">37</td>
                                            <td class="text-center">การประชุมวุฒิสภา</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">ชื่อเอกสาร</td>
                                            <td class="text-center">2567</td>
                                            <td class="text-center">วุฒิสภา ปีที่ 1  ปี พ.ศ. 2567</td>
                                            <td class="text-center">37</td>
                                            <td class="text-center">การประชุมวุฒิสภา</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">ชื่อเอกสาร</td>
                                            <td class="text-center">2567</td>
                                            <td class="text-center">วุฒิสภา ปีที่ ๑  ปี พ.ศ. 2567</td>
                                            <td class="text-center">37</td>
                                            <td class="text-center">การประชุมวุฒิสภา</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <form action="{{ route('admin.document_import') }}" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="documentModalLabel">เพิ่มเอกสาร</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3 mb-3">
                            <div class="col">
                                <label for="name" class="form-label">ชื่อการประชุม</label>
                                <input type="text" class="form-control" id="name" name="type_name">
                            </div>
                            <div class="col">
                                <label for="" class="form-label">สมัยที่ประชุม</label>
                                <select name="period" class="form-select">
                                    <option value="">--- เลือกสมัยที่ประชุม ---</option>
                                    @foreach ($period as $per)
                                        <option value="{{ $per->id }}">{{ $per->name_type_period }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="yearMeeting" class="form-label">ปีที่ประชุม</label>
                                <select name="year" class="form-select">
                                    <option value="">--- เลือกปีที่ประชุม ---</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col">
                                <label for="" class="form-label">ครั้งที่ประชุม</label>
                                <select name="meet" class="form-select">
                                    <option value="">--- เลือกครั้งที่ประชุม ---</option>
                                    @foreach ($meet as $met)
                                        <option value="{{ $met->id }}">{{ $met->name_type_meet }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">ประเภทการประชุม</label>
                                <select name="cate" class="form-select">
                                    <option value="">--- เลือกประเภทการประชุม ---</option>
                                    @foreach ($cate as $ca)
                                        <option value="{{ $ca->id }}">{{ $ca->name_type_cate }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">รัฐธรรมนูญแห่งราชอาณาจักรไทย</label>
                                <select name="con" class="form-select">
                                    <option value="">--- เลือกประเภทการประชุม ---</option>
                                    @foreach ($con as $co)
                                        <option value="{{ $co->id }}">{{ $co->name_type_con }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <label for="" class="form-label">ข้อบังคับการประชุม</label>
                                <select name="rule" class="form-select">
                                    <option value="">--- เลือกประเภทการประชุม ---</option>
                                    @foreach ($rule as $ru)
                                        <option value="{{ $ru->id }}">{{ $ru->name_type_rule }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">วันที่ประชุม</label>
                                {{-- <input type="text" class="form-control" id="datepicker" name="date" placeholder="dd/mm/yyyy"> --}}
                                <input type="date" class="form-control" id="" name="date">
                            </div>
                            <div class="col">
                                <div class="d-grid align-items-end h-100">
                                    <button class="btn btn-primary"  type="button" id="file_button">
                                        <i class="fa-solid fa-file-arrow-up me-1"></i>
                                        <span id="button_text">อัพโหลดเอกสาร</span>
                                    </button>
                                    <input type="file" name="scan" id="file_input" style="display: none;" />
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <label for="" class="form-label">ประเภทเอกสาร</label>
                                <select name="doc" class="form-select">
                                    <option value="">--- เลือกประเภทเอกสาร ---</option>
                                    @foreach ($doc as $do)
                                        <option value="{{ $do->id }}">{{ $do->name_type_doc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#searchTable').DataTable({
            scrollX: true,
            language: {
                url: '/includes/languageDataTable.json',
            }
        });
    });

    document.getElementById('file_button').addEventListener('click', function() {
        document.getElementById('file_input').click();  // เปิด dialog เลือกไฟล์
    });

    document.getElementById('file_input').addEventListener('change', function() {
        var fileName = this.files[0] ? this.files[0].name : 'ไม่มีไฟล์ที่เลือก';
        var buttonText = document.getElementById('button_text');

        // เปลี่ยนข้อความของปุ่มเมื่อเลือกไฟล์
        if (this.files.length > 0) {
            buttonText.textContent = 'ไฟล์: ' + fileName;  // แสดงชื่อไฟล์ที่เลือก
        } else {
            buttonText.textContent = 'อัพโหลดเอกสาร';  // ถ้าไม่ได้เลือกไฟล์
        }
    });
</script>
@endsection