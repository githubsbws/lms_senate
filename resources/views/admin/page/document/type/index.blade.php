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
                            <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#documentTypeModal">
                                <i class="fa-solid fa-square-plus me-1"></i>
                                เพิ่มประเภทเอกสาร
                            </button>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table id="docsList" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="">ประเภทเอกสาร</th>
                                            <th class="">เปิดปิดการแสดงผล</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($doc as $do)
                                        <tr>
                                            <td class="">{{ $do->name_type_doc }}</td>
                                            <td class="">
                                                <input 
                                                    type="checkbox" 
                                                    {{ $do->status == 'y' ? 'checked' : '' }} 
                                                    data-toggle="toggle" 
                                                    data-onlabel="{{ $do->status == 'y' ? 'แสดง' : 'ไม่แสดง' }}" 
                                                    data-offlabel="ไม่แสดง" 
                                                    data-offstyle="danger"
                                                />
                                                <button class="btn btn-warning">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <button class="btn btn-danger" onclick="">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
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
        <div class="modal fade" id="documentTypeModal" tabindex="-1" aria-labelledby="documentTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="documentTypeModalLabel">เพิ่มประเภทเอกสาร</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อประเภทเอกสาร</label>
                        <input type="text" class="form-control" id="name">
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
        $('#docsList').DataTable({
            scrollX: true,
            language: {
                url: '/includes/languageDataTable.json',
            }
        });
    });
</script>
@endsection