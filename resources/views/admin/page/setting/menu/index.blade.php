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
                        <div class="section d-flex mb-3">
                            <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#createMenu">
                                สร้างเมนู
                            </button>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table id="menuListTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ชื่อ</th>
                                            <th class="text-center">URL</th>
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($menu as $mu)
                                        <tr>
                                            <td class="text-center">{{ $mu->name_submenu}}</td>
                                            <td class="text-center">{{ $mu->link }}</td>
                                            <td class="text-center">
                                                <a type="button" class="btn btn-danger" href="{{ route('admin.submenu_del', $mu->id) }}">
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
        <!-- Modal -->
        <div class="modal fade" id="createMenu" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.menu.create') }}" method="POST" id="permissionForm">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="createMenuLabel">สร้างเมนู</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">ตั้งค่าหัวข้อ</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="">
                                <label for="url" class="form-label">URL</label>
                                <input type="text" class="form-control" id="url" name="url">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (session('success_menu'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: '{{ session('success_menu') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    @endif
</body>
<script>
    $(document).ready(function() {
        $('#menuListTable').DataTable({
            scrollX: true,
            language: {
                url: '/includes/languageDataTable.json',
            }
        });
    });
</script>
@endsection