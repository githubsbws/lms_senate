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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1/2567</td>
                                            <td class="text-center">เขียว ชะอุ่ม</td>
                                            <td class="">แบบคำขอหนังสือรับรองของที่ปรึกษาผู้ชำนาญการนักวิชาการและเลขานุการประจำคณะกรรมาธิการฯ</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2/2567</td>
                                            <td class="text-center">สมมติ ตัวอย่าง</td>
                                            <td class="">แบบคำขอมีบัตรแสดงตนบุคคลในคณะกรรมาธิการฯ</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3/2567</td>
                                            <td class="text-center">สมมติ ตัวอย่าง</td>
                                            <td class="">แบบคำขอมีบัตรแสดงตนบุคคลในคณะกรรมาธิการฯ</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4/2567</td>
                                            <td class="text-center">สมมติ ตัวอย่าง</td>
                                            <td class="">แบบคำขอมีบัตรแสดงตนบุคคลในคณะกรรมาธิการฯ</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5/2567</td>
                                            <td class="text-center">สมมติ ตัวอย่าง</td>
                                            <td class="">แบบคำขอมีบัตรแสดงตนบุคคลในคณะกรรมาธิการฯ</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">6/2567</td>
                                            <td class="text-center">สมมติ ตัวอย่าง</td>
                                            <td class="">แบบคำขอมีบัตรแสดงตนบุคคลในคณะกรรมาธิการฯ</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">7/2567</td>
                                            <td class="text-center">สมมติ ตัวอย่าง</td>
                                            <td class="">แบบคำขอมีบัตรแสดงตนบุคคลในคณะกรรมาธิการฯ</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">8/2567</td>
                                            <td class="text-center">สมมติ ตัวอย่าง</td>
                                            <td class="">แบบคำขอมีบัตรแสดงตนบุคคลในคณะกรรมาธิการฯ</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">9/2567</td>
                                            <td class="text-center">สมมติ ตัวอย่าง</td>
                                            <td class="">แบบคำขอมีบัตรแสดงตนบุคคลในคณะกรรมาธิการฯ</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">10/2567</td>
                                            <td class="text-center">สมมติ ตัวอย่าง</td>
                                            <td class="">แบบคำขอมีบัตรแสดงตนบุคคลในคณะกรรมาธิการฯ</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">11/2567</td>
                                            <td class="text-center">สมมติ ตัวอย่าง</td>
                                            <td class="">แบบคำขอมีบัตรแสดงตนบุคคลในคณะกรรมาธิการฯ</td>
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