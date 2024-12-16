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
                                <table id="userTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="">ชื่อ-นามสกุล</th>
                                            <th class="">ตำแหน่ง</th>
                                            <th class="">สิทธิ์การใช้งาน</th>
                                            <th class=""></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="">
                                                <p class="mb-0">จักรภัทร์ สวัสดิวงศ์</p>
                                                <p class="mb-0 text-body-tertiary">Jakkapat@creative-tim.com</p>
                                            </td>
                                            <td class="">
                                                <p class="mb-0">Manager</p>
                                                <p class="mb-0 text-body-tertiary">Organization</p>
                                            </td>
                                            <td class="">Admin</td>
                                            <td class="">
                                                <button type="button" class="btn btn-primary">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                <p class="mb-0">บงกช สิริประภาชัย</p>
                                                <p class="mb-0 text-body-tertiary">Bongkoch@creative-tim.com</p>
                                            </td>
                                            <td class="">
                                                <p class="mb-0">Programator</p>
                                                <p class="mb-0 text-body-tertiary">Developer</p>
                                            </td>
                                            <td class="">Super admin</td>
                                            <td class="">
                                                <button type="button" class="btn btn-primary">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                <p class="mb-0">ปองภพ อินทรประสิทธิ์</p>
                                                <p class="mb-0 text-body-tertiary">Pongpob@creative-tim.com</p>
                                            </td>
                                            <td class="">
                                                <p class="mb-0">Executive</p>
                                                <p class="mb-0 text-body-tertiary">Organization</p>
                                            </td>
                                            <td class="">Admin</td>
                                            <td class="">
                                                <button type="button" class="btn btn-primary">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
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
</body>
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            scrollX: true,
            language: {
                url: '/council/Admin/includes/languageDataTable.json',
            }
        });
    });
</script>
@endsection