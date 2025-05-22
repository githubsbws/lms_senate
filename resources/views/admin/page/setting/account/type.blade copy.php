@extends('admin/layouts/main')
@section('content')
<style>
    a {
        text-decoration: none; /* Remove underline */
        color: inherit; /* Link color will be the same as the surrounding text */
    }

    a:hover {
        color: red; /* Keep the same color on hover */
        text-decoration: none; /* Prevent underline on hover */
    }
</style>
<body id="body">
    <div class="warpper">
       
        <div class="content">
            <main>
                <div class="section">
                    <div class="section-header mb-3">
                        <h5 class="mb-0"><a href="{{route('admin.permission_type')}}">ย้อนกลับ</a></h5>
                    </div>
                    <div class="section-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                <h5>{{ $type->name }}</h5>
                                </div>  

                                <div class="container mt-4">
                                    <form method="POST" action="{{ route('admin.permission_type_update', $type->id) }}"  enctype="multipart/form-data">
                                        @csrf
                                        @php
                                            $permissionGroups = [
                                                'admin' => 'หน้าแรก',
                                                'dashboard' => 'ภาพรวมเว็บไซต์',
                                                'document_request' => 'คำขอเอกสาร',
                                                'setting' => 'จัดการเมนู',
                                                'จัดการเอกสาร' => [
                                                    'document' => 'เอกสาร',
                                                    'document_file' => 'แก้เอกสาร',
                                                    'document_import' => 'นำเข้าเอกสาร',
                                                    'document_period' => 'เอกสารสมัยประชุม',
                                                    'document_type' => 'ประเภทเอกสาร',
                                                ],
                                                'จัดการบัญชีผู้ใช้งาน' => [
                                                    'permission_type' => 'สิทธิ์ผู้ดูแล',
                                                    'permission' => 'กำหนดสิทธิ์ผู้ดูแล',
                                                ],
                                                'จัดการแบบสำรวจ' => [
                                                    'survey' => 'แบบสำรวจความพึงพอใจ',
                                                ],
                                                'รายงาน' => [
                                                    'request' => 'รายงานผู้ขอรับเอกสาร',
                                                    'approved' => 'รายงานการอนุมัติเอกสาร',
                                                ],
                                            ];
                                        @endphp
                                        
                                        @foreach ($permissionGroups as $groupLabel => $items)
                                            @if (is_array($items))
                                                <div class="mt-4">
                                                    <h6 class="fw-bold">{{ $groupLabel }}</h6>
                                                    @foreach ($items as $key => $label)
                                                        <div class="form-check ms-3">
                                                            <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $key }}"
                                                                {{ in_array($key, $currentPermissions) ? 'checked' : '' }}>
                                                            <label class="form-check-label">{{ $label }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="form-check ms-3">
                                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $groupLabel }}"
                                                        {{ in_array($groupLabel, $currentPermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $items }}</label>
                                                </div>
                                            @endif
                                        @endforeach

                                        <button type="submit" class="btn btn-primary mt-4">บันทึก</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
    </div>
    @if (session('success_permission'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: '{{ session('success_permission') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    @endif
    @php
        session()->forget('success_permission'); // ล้างเองหลังแสดง
    @endphp
</body>
@endsection