@extends('layout/mainlayout')
@section('content')
<body>

    <div class="search_normal">
        <section class="banner-toggle">
            <div class="warp">
                <div class="card">
                    <p>ระบบสืบค้นข้อมูลรายงานการประชุม บันทึกการประชุม </p>
                    <p>และบันทึกการออกเสียงลงคะแนน ของสำนักงานเลขาธิการวุฒิสภา</p>
                    <div class="warp-toggle">
                        <a class="btn btn-light" href="#">ค้นหารายงานการประชุม</a>
                        <a class="btn btn-light active" href="#">ค้นหารายงานการประชุมขั้นสูง</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="search_advance main-form ">
            <div class="container">
                <div class="warp">
                    <div class="card text-center">
                        <h3>ค้นหารายงานการประชุมขั้นสูง</h3>
                        <input type="email" class="form-control mt-4 mb-4" id="form1" aria-describedby="form1" placeholder="ค้นหารายงานการประชุมขั้นสูง">
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-primary" onclick="myFunction()">ค้นหา</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- <section id="advance-content" class="advance-content mt-5">
            <div class="container">
                <div class="head">
                    <div class="title">
                        <span>ผลการค้นหา :</span><span class="text-danger">คอรัปชั่น</span>
                    </div>
                </div>

                <div class="detail">
                    <div class="result">
                        <p>การค้นหารายการที่ ๑ - ๑๐ จากผลการค้นหาทั้งหมด ๒๗ รายการของคำค้น คอรัปชั่น</p>
                        <p class="word"><span>ผลการค้นหา :</span><span class="text-danger">คอรัปชั่น</span></p>
                        <p class="note">หมายเหตุ : เอกสารที่มีสัญลักษณ์    เป็นเอกสารที่ถูกแสกนเข้ามาในลักษณะของรูปภาพ ทำให้ไม่สามารถสืบค้นทั้งเอกสารได้ </p>
                        <p class="note">หากต้องการดูเนื้อหาของเอกสารทั้งหมดจะต้องคลิกเพื่อดาวน์โหลดเอกสารนั้นๆ</p>
                    </div>
                </div>

                <div class="card-resault card">
                    <p class="title">
                        การประชุมวุฒิสภา > ชุดที่ ๒๕ > ปีที่ ๔ > สมัยสามัญประจำปีครั้งที่สอง > ครั้งที่ ๒๗ ครั้งที่ ๒๗ เป็นพิเศษ วันพฤหัสบดีที่ ๙ กุมภาพันธ์ ๒๕๖๖ เวลา ๑๐.๔๒ - ๑๘.๒๓ นาฬิกา
                    </p>
                    <div class="find">
                        <span class="text-success">รายงานการประชุม </span> <span>ค้นพบ ๑ แห่ง</span>
                    </div>
                    <div class="detail">
                        <span>...ถามผู้บริหารท้องถิ่นว่าดาเนินภารกิจหน้าที่มีผลประโยชน์ทับซ้อน หรือไม่ มีการขัดผลประโยชน์ มีการทุจริต<span class="text-danger">คอรัปชั่น</span>หรือไม่ ถ้าตอบคาถามไม่ ได้ ชี้แจงไม่ได้ มันก็อยูเป็นอานาจของประชาชนในการถอดถอนผู้บริหารท้องถิ่นโดยประชาชนโดยตรง...</span>
                    </div>

                    <div class="group">
                        <div class="wrap-date">
                            <i class="fa-regular fa-calendar"></i>
                            <p>๙ กุมภาพันธ์ ๒๕๖๖</p>
                        </div>
                        <div class="wrap-btn">
                            <button type="button" class="btn btn-primary">ดูเอกสารที่เกี่ยวข้องทั้งหมด</button>
                            <button type="button" class="btn btn-primary">ดูคำที่ค้นพบทั้งหมด</button>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

</body>
@endsection