<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .nav-sidebar {
        left: 260px !important;
        float: right;
        padding-left: 274px;
    }
    .badge-notify {
        position: absolute;
        top: -5px;
        right: -5px;
        background: red;
        color: white;
        font-size: 12px;
        padding: 2px 6px;
        border-radius: 50%;
        font-weight: bold;
        line-height: 1;
        min-width: 20px;
        text-align: center;
        display: none;
    }
    .disabled-link {
        pointer-events: none;
        cursor: default;
    }
</style>

<sidebar id="sidebar">
    <div class="sidebar-header justify-content-between justify-content-md-center text-white">
        ADMIN
        <button class="sidebar-btn d-md-none d-flex align-items-center" onclick="slice()">
            <svg xmlns="http://www.w3.org/2000/svg" style="color: #ffffff" width="32" height="32" viewBox="0 0 16 16">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="1.5" d="M2.75 12.25h10.5m-10.5-4h10.5m-10.5-4h10.5" />
            </svg>
        </button>
    </div>
    <div class="sidebar-body">
        <ul class="nav sidebar-section">
            @if(in_array('admin', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin') }}" class="nav-link">
                    หน้าแรก
                </a>
            </li>
            @endif
            @if(in_array('dashboard', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    ภาพรวมเว็บไซต์
                </a>
            </li>
            @endif
            @if(in_array('document_request', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.document_request') }}" class="nav-link">
                    คำขอเอกสาร
                </a>
            </li>
            @endif
            @if(in_array('setting', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.setting') }}" class="nav-link">
                    จัดการเมนู
                </a>
            </li>
            @endif
            @if(in_array('synonym', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.synonym') }}" class="nav-link">
                    แก้ไขคำพ้องความหมาย
                </a>
            </li>
            @endif
        </ul>
        @php
             $menu_document = array("document","document_file","document_import","document_period","document_type");
        @endphp
         @if(array_intersect($menu_document, $currentPermissions))
        <p class="text-white mt-3 mb-2 fw-semibold">จัดการเอกสาร</p>
        @endif
        <ul class="nav sidebar-section">
            @if(in_array('document', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.document') }}" class="nav-link">
                    เอกสาร
                </a>
            </li>
            @endif
            @if(in_array('document_file', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.document_file') }}" class="nav-link">
                    แก้เอกสาร
                </a>
            </li>
            @endif
            @if(in_array('document_import', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.document_import') }}" class="nav-link">
                    นำเข้าเอกสาร
                </a>
            </li>
            @endif
            @if(in_array('document_period', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.document_period') }}" class="nav-link">
                    เอกสารสมัยประชุม
                </a>
            </li>
            @endif
            @if(in_array('document_type', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.document_type') }}" class="nav-link">
                    ประเภทเอกสาร
                </a>
            </li>
            @endif
        </ul>
        @php
             $menu_permission = array("permission_type","permission","document_type");
        @endphp
         @if(array_intersect($menu_permission, $currentPermissions))
        <p class="text-white mt-3 mb-2 fw-semibold">จัดการบัญชีผู้ใช้งาน</p>
        @endif
        <ul class="nav sidebar-section">
            @if(in_array('permission_type', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.permission_type') }}" class="nav-link">
                    สิทธิ์ผู้ดูแล
                </a>
            </li>
            @endif
            @if(in_array('permission', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.permission') }}" class="nav-link">
                    กำหนดสิทธิ์ผู้ดูแล
                </a>
            </li>
            @endif
        </ul>
        @php
             $menu_survey = array("survey","document_type");
        @endphp
         @if(array_intersect($menu_survey, $currentPermissions))
        <p class="text-white mt-3 mb-2 fw-semibold">จัดการแบบสำรวจ</p>
        @endif
        <ul class="nav sidebar-section">
            @if(in_array('survey', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.survey') }}" class="nav-link">
                    แบบสำรวจความพึงพอใจ
                </a>
            </li>
            @endif
        </ul>
          @php
             $menu_report = array("request","approved","document_type","surveyreport");
        @endphp
         @if(array_intersect($menu_report, $currentPermissions))
        <p class="text-white mt-3 mb-2 fw-semibold">รายงาน</p>
        @endif
        <ul class="nav sidebar-section">
            @if(in_array('request', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.request') }}" class="nav-link">
                    รายงานผู้ขอรับเอกสาร
                </a>
            </li>
            @endif
            @if(in_array('approved', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.approved') }}" class="nav-link">
                    รายงานการอนุมัติเอกสาร
                </a>
            </li>
            @endif
            @if(in_array('surveyreport', $currentPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.survey_report') }}" class="nav-link">
                    รายงานแบบสำรวจความพึงพอใจ
                </a>
            </li>
            @endif
        </ul>
    </div>
</sidebar>
<div class="nav-sidebar shadow-sm">
    <div class="d-flex align-items-center">
        <button class="nav-btn d-md-none me-3" onclick="slice()">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="1.5" d="M2.75 12.25h10.5m-10.5-4h10.5m-10.5-4h10.5" />
            </svg>
        </button>
        <h4 class="mb-0">
            @switch(Route::currentRouteName())
                @case('admin')
                    หน้าหลัก
                    @break
                @case('admin.document')
                    เอกสาร
                    @break
                @case('admin.document_import')
                    คำขอเอกสาร
                    @break
                @case('admin.synonym')
                    แก้ไขคำพ้องความหมาย
                    @break
                @case('admin.document_import')
                    ประเภทเอกสาร
                    @break
                @case('admin.document_period')
                    นำเข้าเอกสาร
                    @break
                @case('admin.document_year')
                    นำเข้าเอกสาร
                    @break
                @case('admin.document_cate')
                    นำเข้าเอกสาร
                    @break
                @case('admin.document_meet')
                    นำเข้าเอกสาร
                    @break
                @case('admin.dashboard')
                    ภาพรวมเว็บไซต์
                    @break
                @case('admin.setting')
                    จัดการเมนู
                    @break
                @case('admin.permission')
                    กำหนดสิทธิ์ผู้ดูแล
                    @break
                @case('admin.survey')
                    แบบสำรวจความพึงพอใจ
                    @break
                @case('admin.request')
                    รายงานผู้ขอรับเอกสาร
                    @break
                @case('admin.approved')
                    รายงานการอนุมัติเอกสาร
                    @break
                @case('admin.survey_report')
                    รายงานแบบสำรวจความพึงพอใจ
                    @break
                @default
                    หน้าหลัก
            @endswitch 
        </h4>
    </div>
    <div class="ms-auto d-flex align-items-center">
        <a href="{{ route('admin.document_request') }}" class="notify-link disabled-link" id="notifyLink">
            <button class="notify-btn me-3 position-relative">
                <i class="fa-regular fa-bell" style="color: #FE5C73; font-size: 24px;"></i>
                    <span class="badge-notify" ></span>
            </button>
        </a>
        <div class="dropdown position-relative">
            <button class="dropdown-btn d-flex align-items-center dropdown-toggle" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->username }}
            </button>
            <ul class="dropdown-menu end-0">
                <li>
                    <button class="dropdown-item" href="#">คู่มือการใช้ระบบ</button>
                </li>
                <li>
                    <button class="dropdown-item" href="#">วิธีการใช้งาน</button>
                </li>
                <li>
                    <button class="dropdown-item" onclick="logout()">ออกจากระบบ</button>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

<script>
    const echo = new Echo({
        broadcaster: 'pusher',
        key: 'acd5d945f37cc74a3cfd',
        cluster: 'ap1',
        forceTLS: true,
    });
</script> --}}
<script type="text/javascript">
    function slice() {
        const element = document.getElementById("sidebar");
        element.classList.toggle("show");
        const body = document.getElementById("body");
        body.classList.toggle("overflow-hidden");
    };

    function logout() {
        fetch("{{ route('admin.logout') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}", // ใช้ CSRF Token สำหรับความปลอดภัย
                "Content-Type": "application/json"
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.href = "/admin"; // เปลี่ยนเส้นทางไปที่หน้าล็อกอิน
            } else {
                console.error("Logout failed");
            }
        })
        .catch(error => console.error("Error:", error));
    }

    function fetchDocRequestCount() {
        fetch('/admin/count_doc_request')
            .then(response => response.json())
            .then(data => {
                const count = data.countDocRequest;
                const bell = document.querySelector('.notify-btn i');
                const badge = document.querySelector('.badge-notify');
                const link = document.getElementById('notifyLink');

                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = 'inline-block';

                    link.classList.remove('disabled-link'); // เปิดให้คลิกได้
                } else {
                    badge.style.display = 'none';                   
                    link.classList.add('disabled-link'); // ปิดคลิก
                }
            });
    }
    document.addEventListener('DOMContentLoaded', function () {
        fetchDocRequestCount();

        // ถ้าอยากให้มันอัปเดตเรื่อยๆ ทุก 30 วิ:
        // setInterval(fetchDocRequestCount, 30000);
    });
</script>
