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
                                <table id="docsList" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">เลขที่</th>
                                            <th class="text-center">ชื่อ-นามสกุล</th>
                                            <th class="text-center">รายการคำขอเอกสาร</th>
                                            <th class="text-center">วันที่ร้องขอเอกสาร</th>
                                            <th class="text-center">สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1/2567</td>
                                            <td class="text-center">เขียว ชะอุ่ม</td>
                                            <td class="">แบบคำขอหนังสือรับรองของที่ปรึกษาผู้ชำนาญการนักวิชาการและเลขานุการประจำคณะกรรมาธิการฯ</td>
                                            <td class="text-center">11 ต.ค. 2567</td>
                                            <td class="text-center">
                                                <button class="badge text-bg-success" disabled>อนุมัติ</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2/2567</td>
                                            <td class="text-center">เขียว ชะอุ่ม</td>
                                            <td class="">แบบคำขอหนังสือรับรองของที่ปรึกษาผู้ชำนาญการนักวิชาการและเลขานุการประจำคณะกรรมาธิการฯ</td>
                                            <td class="text-center">11 ต.ค. 2567</td>
                                            <td class="text-center">
                                                <button class="badge text-bg-danger" data-bs-toggle="modal" data-bs-target="#viewDetailModal">ไม่อนุมัติ</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3/2567</td>
                                            <td class="text-center">เขียว ชะอุ่ม</td>
                                            <td class="">แบบคำขอหนังสือรับรองของที่ปรึกษาผู้ชำนาญการนักวิชาการและเลขานุการประจำคณะกรรมาธิการฯ</td>
                                            <td class="text-center">11 ต.ค. 2567</td>
                                            <td class="text-center">
                                                <button class="badge text-bg-success" disabled>อนุมัติ</button>
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
        <!-- Modal -->
        <div class="modal fade" id="viewDetailModal" tabindex="-1" aria-labelledby="viewDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewDetailModalLabel">สาเหตุของการไม่อนุมัติคำขอรับบริการ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reason" class="form-label">เหตุผลที่ไม่อนุมัติคำขอรับบริการ</label>
                            <textarea class="form-control" id="reason" rows="3" disabled></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#docsList').DataTable({
            scrollX: true,
            language: {
                url: '/council/Admin/includes/languageDataTable.json',
            }
        });
    });
</script>
@endsection