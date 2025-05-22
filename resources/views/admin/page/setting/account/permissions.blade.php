@extends('admin/layouts/main')
@section('content')
<body id="body">
    <div class="warpper">
        <div class="content">
            <main>
                <div class="section">
                    <div class="section-body">
                        <div class="section mb-3">
                            <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#documentTypeModal">
                                <i class="fa-solid fa-square-plus me-1"></i>
                                เพิ่มสิทธิ์
                            </button>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table id="userTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="">ชื่อสิทธิ์</th>
                                            <th class="">สิทธิ์การใช้งาน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($type as $ty)
                                        <tr>
                                            <td class="">
                                                <p class="mb-0">{{ $ty->name }}</p>
                                            </td>
                                            <td class="">
                                                <a type="button" class="btn btn-primary" href="{{ route('admin.permission_type_edit', $ty->id) }}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <a type="button" class="btn btn-danger" href="{{ route('admin.permission_delete', $ty->id) }}">
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
    <div class="modal fade" id="documentTypeModal" tabindex="-1" aria-labelledby="documentTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="documentTypeModalLabel">เพิ่มสิทธิ์</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.permission_type_create') }}" method="POST" id="permissionForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">ชื่อสิทธิ์</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" form="permissionForm">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    @if (session('success_per_create'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: '{{ session('success_per_create') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    @endif
    @php
        session()->forget('success_per_create'); // ล้างเองหลังแสดง
    @endphp
</body>
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            scrollX: true,
            language: {
                url: '/includes/languageDataTable.json',
            }
        });
    });
</script>
@endsection