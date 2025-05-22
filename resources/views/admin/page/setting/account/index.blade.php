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
                                        @foreach ($user as $us)
                                        <tr>
                                            <td class="">
                                                <p class="mb-0">{{ $us->firstname }} {{ $us->lastname }}</p>
                                                <p class="mb-0 text-body-tertiary">{{ $us->email ?? '-'}}</p>
                                            </td>
                                            <td class="">
                                                @switch($us->employee_type)
                                                    @case(0)
                                                        <p class="mb-0">ผู้ดูแลระบบ</p>
                                                        <p class="mb-0 text-body-tertiary">-</p>
                                                        @break
                                                    @case(1)
                                                        <p class="mb-0">สมาชิกวุฒิสภา</p>
                                                        <p class="mb-0 text-body-tertiary">-</p>
                                                        @break

                                                    @case(2)
                                                        <p class="mb-0">บุคคลในวงงานรัฐสภา</p>
                                                        <p class="mb-0 text-body-tertiary">-</p>
                                                        @break

                                                    @default
                                                        <p class="mb-0">หน่วยงาน/บุคคลภายนอก</p>
                                                        <p class="mb-0 text-body-tertiary">{{ $us->external_detail ?? '-' }}</p>
                                                @endswitch
                                            </td>
                                            <td class="">{{ $us->typeuser->name ?? '-'  }}</td>
                                            <td class="">
                                                <a type="button" class="btn btn-primary" href="{{ route('admin.permission_edit', $us->id) }}">
                                                    <i class="fa-solid fa-pen"></i>
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
    @if (session('success_update'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: '{{ session('success_update') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    @endif
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