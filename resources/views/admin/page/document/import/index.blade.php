@extends('admin/layouts/main')
@section('content')
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
                                <input type="text" class="form-control" id="dateMeeting">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <label for="MeetingCount" class="form-label">ครั้งที่ประชุม</label>
                                <input type="text" class="form-control" id="MeetingCount">
                            </div>
                            <div class="col">
                                <label for="typeMeeting" class="form-label">ประเภทการประชุม</label>
                                <input type="text" class="form-control" id="typeMeeting">
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
                                            <td class="text-center">วุฒิสภา ปีที่ ๑  ปี พ.ศ. ๒๕๖๗</td>
                                            <td class="text-center">37</td>
                                            <td class="text-center">การประชุมวุฒิสภา</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">ชื่อเอกสาร</td>
                                            <td class="text-center">2567</td>
                                            <td class="text-center">วุฒิสภา ปีที่ ๑  ปี พ.ศ. ๒๕๖๗</td>
                                            <td class="text-center">37</td>
                                            <td class="text-center">การประชุมวุฒิสภา</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">ชื่อเอกสาร</td>
                                            <td class="text-center">2567</td>
                                            <td class="text-center">วุฒิสภา ปีที่ ๑  ปี พ.ศ. ๒๕๖๗</td>
                                            <td class="text-center">37</td>
                                            <td class="text-center">การประชุมวุฒิสภา</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">ชื่อเอกสาร</td>
                                            <td class="text-center">2567</td>
                                            <td class="text-center">วุฒิสภา ปีที่ ๑  ปี พ.ศ. ๒๕๖๗</td>
                                            <td class="text-center">37</td>
                                            <td class="text-center">การประชุมวุฒิสภา</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">ชื่อเอกสาร</td>
                                            <td class="text-center">2567</td>
                                            <td class="text-center">วุฒิสภา ปีที่ ๑  ปี พ.ศ. ๒๕๖๗</td>
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
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="documentModalLabel">เพิ่มเอกสาร</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="name" class="form-label">ชื่อการประชุม</label>
                            <select class="form-select" id="name">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="" class="form-label">สมัยที่ประชุม</label>
                            <select class="form-select" id="">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="yearMeeting" class="form-label">ปีที่ประชุม</label>
                            <select class="form-select" id="yearMeeting">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="" class="form-label">ครั้งที่ประุม</label>
                            <select class="form-select" id="">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="" class="form-label">ประเภทการประชุม</label>
                            <select class="form-select" id="">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="" class="form-label">รัฐธรรมนูญแห่งราชอาณาจักรไทย</label>
                            <select class="form-select" id="">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label for="" class="form-label">ข้อบังคับการประชุม</label>
                            <select class="form-select" id="">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="" class="form-label">วันที่ประชุม</label>
                            <input type="date" class="form-control" id="">
                        </div>
                        <div class="col">
                            <div class="d-grid align-items-end h-100">
                                <button class="btn btn-primary" type="button">
                                    <i class="fa-solid fa-file-arrow-up me-1"></i>
                                    อัพโหลดเอกสาร
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary">บันทึก</button>
                </div>
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
</script>
@endsection