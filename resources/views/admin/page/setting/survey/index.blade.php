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
                        <div class="section mb-3">
                            <a href="./id/" type="button" class="btn btn-primary ms-auto">
                                <i class="fa-solid fa-square-plus me-1"></i>
                                เพิ่มเอกสาร
                            </a>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table id="docsList" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="w-75">ชื่อแบบสำรวจ</th>
                                            <th class="">จัดการข้อมูล</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="">แบบสำรวจความพึงพอใจที่ 1</td>
                                            <td class="">
                                                <a href="id" class="btn btn-warning">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <button class="btn btn-danger" onclick="">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <input type="checkbox" checked data-toggle="toggle" data-onlabel="" data-offlabel="" data-offstyle="danger" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">แบบสำรวจความพึงพอใจที่ 2</td>
                                            <td class="">

                                                <a href="id" class="btn btn-warning">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <button class="btn btn-danger" onclick="">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <input type="checkbox" checked data-toggle="toggle" data-onlabel="" data-offlabel="" data-offstyle="danger" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">แบบสำรวจความพึงพอใจที่ 3</td>
                                            <td class="">
                                                <a href="id" class="btn btn-warning">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <button class="btn btn-danger" onclick="">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <input type="checkbox" checked data-toggle="toggle" data-onlabel="" data-offlabel="" data-offstyle="danger" />
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
        $('#docsList').DataTable({
            scrollX: true,
            language: {
                url: '/council/Admin/includes/languageDataTable.json',
            }
        });
    });
</script>
@endsection