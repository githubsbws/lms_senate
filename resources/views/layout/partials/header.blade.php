<nav class="navbar navbar-main navbar-expand-lg ">
    <div class="container-fluid">
        <a href="index.php"> <img src="{{asset('assets/images/newimg/logonav.png')}}" class="d-block"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('index')}}">หน้าแรก</a>
                </li>
              
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    เกี่ยวกับสำนักรายงานการประชุมและชวเลข
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('org.senate') }}">โครงสร้าง</a></li>
                        <li><a class="dropdown-item" href="#">อำนาจและหน้าที่</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    กฎหมาย
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="https://www.senate.go.th/assets/portals/13/fileups/169/files/รัฐธรรมนูญ%202560%20ฉบับแก้ไข(1).pdf" target="_blank">รัฐธรรมนูญแห่งราชอาณาจักรไทย พุทธศักราช 2560</a></li>
                        <li><a class="dropdown-item" href="https://www.senate.go.th/assets/portals/13/fileups/565/files/kbk%20update%2064.pdf" target="_blank">ข้อบังคับการประชุมวุฒิสภา พ.ศ. 2562</a></li>
                        <li><a class="dropdown-item" href="https://www.ipthailand.go.th/images/633/law_info2540.pdf" target="_blank">พระราชบัญญัติข้อมูลข่าวสารของราชการ พ.ศ. 2540</a></li>
                        <li><a class="dropdown-item" href="https://www.ratchakitcha.soc.go.th/DATA/PDF/2562/A/069/T_0052.PDF" target="_blank">พระราชบัญญัติคุ้มครองข้อมูลส่วนบุคคล พ.ศ. 2562</a></li>
                        <li><a class="dropdown-item" href="https://www.senate.go.th/assets/portals/13/fileups/169/files/ประกาศสำนักงานเลขาธิการวุฒิสภา%20เรื่อง%20ข้อมูลข่าวสารที่ไม่ต้องเปิดเผยตามมาตรา%2015.PDF" target="_blank">ประกาศสำนักงานเลขาธิการวุฒิสภา เรื่อง ข้อมูลข่าวสารที่ไม่ต้องเปิดเผย</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">ข่าวประชาสัมพันธ์</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    การขอรับบริการ
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{route('form.meet')}}">แบบฟอร์มขอเอกสาร</a></li>
                        <li><a class="dropdown-item" href="{{route('form.status')}}">สถานะการขอรับบริการ</a></li>
                    </ul>
                </li>
                @php
                use App\Models\Submenu;
                $submenu = Submenu::where('active','y')->get();
                @endphp
                @if($submenu->count())
                    @foreach($submenu as $item)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $item->link }}">{{ $item->name_submenu }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
                @if(Auth::user())
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->username }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
                        <li>
                            <a class="dropdown-item" href="#">คู่มือการใช้ระบบ</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">วิธีการใช้งาน</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="logout()">ออกจากระบบ</a>
                        </li>
                    </ul>
                </div>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary">เข้าสู่ระบบ</a>
                @endif
        </div>
    </div>
</nav>
<script type="text/javascript">

    function logout() {
        fetch("{{ route('users.logout') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}", // ใช้ CSRF Token สำหรับความปลอดภัย
                "Content-Type": "application/json"
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.href = "/"; // เปลี่ยนเส้นทางไปที่หน้าล็อกอิน
            } else {
                console.error("Logout failed");
            }
        })
        .catch(error => console.error("Error:", error));
    }
</script>