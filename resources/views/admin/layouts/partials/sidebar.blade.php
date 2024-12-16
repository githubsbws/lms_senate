<style>
    .nav-sidebar {
        left: 260px !important;
        float: right;
        padding-left: 274px;
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
            <li class="nav-item">
                <a href="{{ route('admin') }}" class="nav-link">
                    หน้าแรก
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    ภาพรวมเว็บไซต์
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.document_request') }}" class="nav-link">
                    คำขอเอกสาร
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.setting') }}" class="nav-link">
                    จัดการเมนู
                </a>
            </li>
        </ul>
        <p class="text-white mt-3 mb-2 fw-semibold">จัดการเอกสาร</p>
        <ul class="nav sidebar-section">
            <li class="nav-item">
                <a href="{{ route('admin.document') }}" class="nav-link">
                    เอกสาร
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.document_import') }}" class="nav-link">
                    นำเข้าเอกสาร
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.document_period') }}" class="nav-link">
                    เอกสารสมัยประชุม
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.document_type') }}" class="nav-link">
                    ประเภทเอกสาร
                </a>
            </li>
        </ul>
        <p class="text-white mt-3 mb-2 fw-semibold">จัดการบัญชีผู้ใช้งาน</p>
        <ul class="nav sidebar-section">
            <li class="nav-item">
                <a href="{{ route('admin.permission') }}" class="nav-link">
                    กำหนดสิทธิ์ผู้ดูแล
                </a>
            </li>
        </ul>
        <p class="text-white mt-3 mb-2 fw-semibold">จัดการแบบสำรวจ</p>
        <ul class="nav sidebar-section">
            <li class="nav-item">
                <a href="{{ route('admin.survey') }}" class="nav-link">
                    แบบสำรวจความพึงพอใจ
                </a>
            </li>
        </ul>
        <p class="text-white mt-3 mb-2 fw-semibold">รายงาน</p>
        <ul class="nav sidebar-section">
            <li class="nav-item">
                <a href="{{ route('admin.request') }}" class="nav-link">
                    รายงานผู้ขอรับเอกสาร
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.approved') }}" class="nav-link">
                    รายงานการอนุมัติเอกสาร
                </a>
            </li>
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
                @default
                    หน้าหลัก
            @endswitch 
        </h4>
    </div>
    <div class="ms-auto d-flex align-items-center">
        <button class="notify-btn me-3">
            <i class="fa-regular fa-bell" style="color: #FE5C73;"></i>
        </button>
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
</script>
