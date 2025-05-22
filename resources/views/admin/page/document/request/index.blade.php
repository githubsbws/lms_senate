@extends('admin/layouts/main')
@section('content')
<body id="body">
    <div class="warpper">
        <div class="content">
            <main>
                <div class="section">
                    <div class="section-header mb-3">
                        <h5 class="mb-2">ค้นหาเอกสาร</h5>
                        <div class="row g-3">
                            <div class="col">
                                <label for="number" class="form-label">เลขที่</label>
                                <input type="text" class="form-control" id="number">
                            </div>
                            <div class="col">
                                <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="col">
                                <label for="date" class="form-label">วันที่</label>
                                <input type="date" class="form-control" id="date">
                            </div>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="card">
                            <div class="card-body">
                                <table id="searchTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">เลขที่</th>
                                            <th class="text-center">ชื่อนามสกุล</th>
                                            <th class="text-center">รายการคำขอเอกสาร</th>
                                            <th class="text-center">วันที่ร้องขอเอกสาร</th>
                                            <th class="text-center">เหตุผลที่ร้องขอ</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($approve as $ap)
                                        <tr>
                                            <td class="text-center">{{ $ap->number }}</td>
                                            <td class="text-center">{{ $ap->user->firstname }} {{ $ap->user->lastname }}</td>
                                            <td class="text-center">{{ $ap->type_detail}}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($ap->the_date)->addYear(543)->format('Y-m-d') ?? '-'}}</td>
                                            <td class="text-center">                                  
                                                @if ($ap->detail === 'government_work')
                                                    ใช้ประโยชน์ในงานราชการ
                                                @elseif ($ap->detail === 'education_research')
                                                    เพื่อการศึกษา/วิจัย
                                                @else
                                                    {{ $ap->detail ?? '-' }}
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <div class="">
                                                    <button type="button" 
                                                            class="btn btn-success" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#approveModal" 
                                                            data-id="{{ $ap->id }}">
                                                        อนุมัติ
                                                    </button>
                                                    <button type="button" class="btn btn-danger" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deniedModal" 
                                                            data-id="{{ $ap->id }}">
                                                        ไม่อนุมัติ
                                                    </button>
                                                </div>
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
    <!-- Approve Modal -->
    <form id="approveForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="approveModalLabel">อนุมัติเอกสาร</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <label for="fileUpload" class="btn btn-primary">
                                <i class="fa-solid fa-file-arrow-up me-1"></i>
                                อัพโหลดเอกสาร
                            </label>
                            <input type="file" id="fileUpload" name="file" class="d-none">

                            <span id="fileName" class="text-muted"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Denied Modal -->
    <form id="deniedForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="deniedModal" tabindex="-1" aria-labelledby="deniedModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deniedModalLabel">ไม่อนุมัติเอกสาร</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="reason" class="form-label">กรอกเหตุผลที่ไม่อนุมัติคำขอ</label>
                        <select class="form-select" name="reason" id="reason" onchange="toggleOtherReason()">
                            <option value="เป็นข้อมูลข่าวสารที่หน่วยงานได้พิจารณาแล้วไม่อาจเปิดเผยได้ตามพระราชบัญญัติข้อมูล ของราชการ รายการ พ.ศ.2540 มาตรา 14">1.เป็นข้อมูลข่าวสารที่หน่วยงานได้พิจารณาแล้วไม่อาจเปิดเผยได้ตามพระราชบัญญัติข้อมูล ของราชการ รายการ พ.ศ.2540 มาตรา 14</option>
                            <option value="เป็นข้อมูลข่าวสารที่หน่วยงานได้พิจารณาแล้วไม่อาจเปิดเผยได้ตามพระราชบัญญัติข้อมูล ของราชการ รายการ พ.ศ.2540 มาตรา 15">2.เป็นข้อมูลข่าวสารที่หน่วยงานได้พิจารณาแล้วไม่อาจเปิดเผยได้ตามพระราชบัญญัติข้อมูล ของราชการ รายการ พ.ศ.2540 มาตรา 15</option>
                            <option value="เป็นข้อมูลข่าวสารที่ไม่ได้อยู่ในความครอบครองของหน่วยงาน">3.เป็นข้อมูลข่าวสารที่ไม่ได้อยู่ในความครอบครองของหน่วยงาน</option>
                            <option value="other">4.อื่นๆ</option>
                        </select>
                    </div>
                    <div class="modal-body" id="other-reason" style="display: none; margin-top: 10px;">
                        <label for="other_reason" class="form-label">กรอกเหตุผลเพิ่มเติม</label>
                        <textarea class="form-control" name="other_reason" id="other_reason" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
<script>
    $(document).ready(function() {
         $.fn.dataTable.ext.errMode = 'none'; // ปิด warning
        $('#searchTable').DataTable({
            scrollX: true,
            language: {
                url: '/includes/languageDataTable.json',
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const approveModal = document.getElementById('approveModal');
        const approveForm = document.getElementById('approveForm');

        approveModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // ปุ่มที่ถูกคลิก
            const id = button.getAttribute('data-id'); // ดึงค่า id
            const routeUrl = `/admin/document_approve/${id}`; // สร้าง URL ใหม่

            approveForm.setAttribute('action', routeUrl); // ตั้งค่า action ให้กับฟอร์ม
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
        const approveModal = document.getElementById('deniedModal');
        const approveForm = document.getElementById('deniedForm');

        approveModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // ปุ่มที่ถูกคลิก
            const id = button.getAttribute('data-id'); // ดึงค่า id
            const routeUrl = `/admin/document_deny/${id}`; // สร้าง URL ใหม่

            approveForm.setAttribute('action', routeUrl); // ตั้งค่า action ให้กับฟอร์ม
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('fileUpload');
        const fileNameDisplay = document.getElementById('fileName');

        fileInput.addEventListener('change', function () {
            const file = fileInput.files[0]; // ดึงไฟล์ที่เลือก
            if (file) {
                fileNameDisplay.textContent = file.name; // แสดงชื่อไฟล์
            } else {
                fileNameDisplay.textContent = 'ยังไม่ได้เลือกไฟล์'; // กรณีไม่ได้เลือกไฟล์
            }
        });
    });

    function toggleOtherReason() {
        const reasonSelect = document.getElementById('reason');
        const otherContainer = document.getElementById('other-reason');

        if (reasonSelect.value === "other") {
            otherContainer.style.display = "block";
        } else {
            otherContainer.style.display = "none";
        }
    }
</script>
@endsection