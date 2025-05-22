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
                                <input type="text" name="period" class="form-control"/>
                                <br>
                                <label for="name" class="form-label">ครั้งที่ประชุม</label>
                                <input type="text" name="meet" class="form-control"/>
                                <br>
                                <label for="name" class="form-label">ประเภทที่ประชุม</label>
                                <input type="text" name="cate" class="form-control"/>
                                <br>
                                <label for="name" class="form-label">รัฐธรรมนูญแห่งราชอาณาจักรไทย</label>
                                <input type="text" name="con" class="form-control"/>
                                <br>
                                <label for="name" class="form-label">ข้อบังคับการประชุม</label>
                                <input type="text" name="rule" class="form-control"/>
                                <br>
                                <label for="name" class="form-label">ประเภทเอกสาร</label>
                                <input type="text" name="doc" class="form-control"/>
                                <br>
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
                                            <td class="text-center">
                                                <a href="{{ route('admin.period_del', $per->id) }}" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body">
                                <table id="searchTable2" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ครั้งที่ประชุม</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($meet as $met)
                                        <tr>
                                            <td class="text-center">{{ $met->name_type_meet ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.meet_del', $met->id) }}" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body">
                                <table id="searchTable3" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ประเภทการประชุม</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cate as $ca)
                                        <tr>
                                            <td class="text-center">{{ $ca->name_type_cate ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.cate_del', $ca->id) }}" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body">
                                <table id="searchTable4" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">รัฐธรรมนูญแห่งราชอาณาจักรไทย</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($con as $co)
                                        <tr>
                                            <td class="text-center">{{ $co->name_type_con }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.con_del', $co->id) }}" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body">
                                <table id="searchTable5" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ข้อบังคับการประชุม</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rule as $ru)
                                        <tr>
                                            <td class="text-center">{{ $ru->name_type_rule }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.rule_del', $ru->id) }}" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body">
                                <table id="searchTable6" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ประเภทเอกสาร</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($doc as $do)
                                        <tr>
                                            <td class="text-center">{{ $do->name_type_doc }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.doc_del', $do->id) }}" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
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
    $(document).ready(function() {
        $('#searchTable2').DataTable({
            scrollX: true,
            language: {
                url: '/includes/languageDataTable.json',
            }
        });
    });
    $(document).ready(function() {
        $('#searchTable3').DataTable({
            scrollX: true,
            language: {
                url: '/includes/languageDataTable.json',
            }
        });
    });
    $(document).ready(function() {
        $('#searchTable4').DataTable({
            scrollX: true,
            language: {
                url: '/includes/languageDataTable.json',
            }
        });
    });
    $(document).ready(function() {
        $('#searchTable5').DataTable({
            scrollX: true,
            language: {
                url: '/includes/languageDataTable.json',
            }
        });
    });
    $(document).ready(function() {
        $('#searchTable6').DataTable({
            scrollX: true,
            language: {
                url: '/includes/languageDataTable.json',
            }
        });
    });
</script>
@endsection