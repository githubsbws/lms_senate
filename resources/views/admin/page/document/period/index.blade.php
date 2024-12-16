@extends('admin/layouts/main')
@section('content')
<body id="body">
    <div class="warpper">
        <div class="content">
            <main>
                <div class="section">
                    <div class="section-header mb-3">
                        <h5 class="mb-2"></h5>
                        <form  action="{{ route('admin.document_period') }}" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto">
                            @csrf
                        <div class="row g-3 mb-2">
                            <div class="col">
                                <label for="name" class="form-label">สมัยที่ประชุม</label>
                                <input type="text" name="period" class="form-control" id="name">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-square-plus me-1"></i>
                                    บันทึก
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="section-body">
                        <div class="card">
                            <div class="card-body">
                                <table id="searchTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">สมัยที่ประชุม</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($period as $per)
                                        <tr>
                                            <td class="text-center">{{ $per->name_type_period }}</td>
                                            <td class="text-center"><a class="fa-solid fa-square-plus me-1" title="เพิ่มปีที่ประชุม" href="{{route('admin.document_year',['id'=>$per->id])}}"><i></i>เพิ่มปีที่ประชุม</a></td>
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