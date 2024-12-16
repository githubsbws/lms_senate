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
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1/2567</td>
                                            <td class="text-center">เขียว ชะอุ่ม</td>
                                            <td class="text-center">แบบคำขอหนังสือรับรองของที่ปรึกษาผู้ชำนาญการนักวิชาการและเลขานุการประจำคณะกรรมาธิการฯ</td>
                                            <td class="text-center">11 ต.ค. 2567</td>
                                            <td class="text-center">
                                                <div class="">
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">อนุมัติ</button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deniedModal">ไม่อนุมัติ</button>
                                                </div>
                                            </td>
                                        </tr>
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
    <form action="{{ route('admin.document_approve') }}" method="POST">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-primary">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Denied Modal -->
    <form action="{{ route('admin.document_deny') }}" method="POST">
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
                        <textarea class="form-control" id="reason" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-primary">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
<script>
    $(document).ready(function() {
        $('#searchTable').DataTable({
            scrollX: true,
            language: {
                url: '/council/Admin/includes/languageDataTable.json',
            }
        });
    });
</script>
@endsection