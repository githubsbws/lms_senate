@extends('layout/mainlayout')
@section('content')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>

<body>

    <div class="form-meet">
        <section class="banner-toggle">
            <div class="warp">
                <div class="card">
                    <p>ระบบสืบค้นข้อมูลรายงานการประชุม บันทึกการประชุม </p>
                    <p>และบันทึกการออกเสียงลงคะแนน ของสำนักงานเลขาธิการวุฒิสภา</p>
                    <div class="warp-toggle">
                        <a class="btn btn-light" href="{{route ('frontend.a_search') }}">ค้นหารายงานการประชุม</a>
                        <a class="btn btn-light" href="{{route ('frontend.n_search') }}">ค้นหารายงานการประชุมขั้นสูง</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="body-content">
            <div class="container">
                <div class="text-center">
                    <h3 class="mb-1">แบบขอใช้บริการ</h3>
                    <h3>สำนักรายงานการประชุมและชวเลข</h3>
                </div>

                <div class="head">
                    <div>
                        <label class="mb-1" for="#">วัน/เดือน/ปี </label>
                        <input type="date" class="form-control" id="meeting_date" name="date" width="276" disabled>
                    </div>
                </div>

                <h5>เรียน ผู้อำนวยการสำนักรายงานกระประชุมและชวเลข</h5>
                <div class="card">


                    <div class="row ">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="text" class="form-label">ชื่อ - นามสกุล</label>
                                <input type="text" class="form-control" id="text" value="{{Auth::user()->firstname}} {{Auth::user()->lastname}}" aria-describedby="textHelp" placeholder="ชื่อ - นามสกุล (ผู้ขอใช้บริการ)">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="text" class="form-label">โทร</label>
                                <input type="text" class="form-control" id="text" value="{{Auth::user()->tel}}" aria-describedby="textHelp" placeholder="081-789-888">

                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="text" class="form-label">อีเมล</label>
                                <input type="text" class="form-control" id="text" value="{{Auth::user()->email}}" aria-describedby="textHelp" placeholder="Roman68@gmail.com">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="text" class="form-label">ประเภทผู้ใช้บริการ</label>
                                
                                <!-- ตรวจสอบว่า employee_type == 3 หรือไม่ -->
                                @if(Auth::user()->employee_type == 3)
                                    <!-- ถ้าใช่ ให้ใช้ external_detail แทน -->
                                    <input type="text" class="form-control" id="text" value="{{ Auth::user()->external_detail }}" aria-describedby="textHelp" placeholder="รายละเอียดหน่วยงานภายนอก" disabled>
                                @elseif(Auth::user()->employee_type == 1)
                                    <!-- ถ้าไม่ใช่ ให้ใช้ employee_type -->
                                    <input type="text" class="form-control" id="text" value="สมาชิกวุฒิสภา" aria-describedby="textHelp" placeholder="สมาชิกวุฒิสภา" disabled>
                                @elseif(Auth::user()->employee_type == 2)
                                    <!-- ถ้าไม่ใช่ ให้ใช้ employee_type -->
                                    <input type="text" class="form-control" id="text" value="บุคคลในวงงานรัฐสภา" aria-describedby="textHelp" placeholder="บุคคลในวงงานรัฐสภา" disabled>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <h5>เรื่องที่ขอใช้บริการ</h5>
                <form id="meetingForm" action="{{ route('meeting.submit') }}" method="POST">
                    @csrf
                <div class="card">
                    <select class="form-control" id="meetingType">
                        <option value="">-- กรุณาเลือก --</option>
                        <option value="report_committee">รายงานการประชุม</option>
                        <option value="meeting_report">บันทึกการประชุม</option>
                        <option value="meeting_note">บันทึกการออกเสียงลงคะแนน</option>
                    </select>
                </div>
                <div class="card form-section" id="report_committee">
                    <div class="row ">
                        <div class="col-lg-1">
                            {{-- <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                            </div> --}}
                        </div>
                        <div class="col-lg-11">
                            <div class="row ">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <input type="hidden" name="meeting_type" value="report_committee">
                                        <label for="text" class="form-label">รายงานการประชุม<span style="color: red"> *</span></label>
                                        {{-- <input type="text" class="form-control" name="title" id="title" aria-describedby="textHelp" placeholder="" > --}}
                                        <textarea class="form-control" name="title" id="title" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label for="text" class="form-label">ครั้งที่</label>
                                        <input type="text" class="form-control" id="meet" name="meet" aria-describedby="textHelp" placeholder="" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="">
                                        <label for="text" class="form-label">สมัย</label>
                                        <select class="form-control" id="periodSelect" name="period" >
                                            <option value="">-- กรุณาเลือกหรือพิมพ์ --</option>
                                            @foreach ($period as $per)
                                                <option value="{{$per->id}}">{{ $per->name_type_period }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-3">
                                    <div>
                                        <label class="mb-2" for="#">วันที่ </label>
                                        <input type="date" class="form-control" id="meeting_date" name="date" width="276" >
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">วัตถุประสงค์ในการขอใช้บริการ<span style="color: red"> *</span></label>
                                    <select id="purposeSelect" class="form-select" name="detail">
                                        <option value="government_work">ใช้ประโยชน์ในงานราชการ</option>
                                        <option value="education_research">เพื่อการศึกษา/วิจัย</option>
                                        <option value="other">อื่นๆ</option>
                                    </select>
                                    <!-- ซ่อน textarea โดยเริ่มต้น -->
                                    <br>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="exampleFormControlTextarea1" rows="3" style="display: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card form-section" id="meeting_report">
                    <div class="row ">
                        <div class="col-lg-1">
                            {{-- <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                            </div> --}}
                        </div>
                        <div class="col-lg-11">
                            <div class="row ">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <input type="hidden" name="meeting_type" value="meeting_report">
                                        <label for="text" class="form-label">บันทึกการประชุม</label>
                                        <input type="text" class="form-control" id="title" name="title" aria-describedby="textHelp" placeholder="" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label for="text" class="form-label">ครั้งที่</label>
                                        <input type="text" class="form-control" id="meet" name="meet" aria-describedby="textHelp" placeholder="" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="">
                                        <label for="text" class="form-label">สมัย</label>
                                        <select class="form-control" id="periodSelect2" name="period" >
                                            <option value="">-- กรุณาเลือกหรือพิมพ์ --</option>
                                            @foreach ($period as $per)
                                                <option value="{{$per->id}}">{{ $per->name_type_period }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-3">
                                    <div>
                                        <label class="mb-2" for="#">วันที่ </label>
                                        <input type="date" class="form-control" id="meeting_date" name="date" width="276" >
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">วัตถุประสงค์ในการขอใช้บริการ</label>
                                    <select id="purposeSelect2" class="form-select" name="detail">
                                        <option value="government_work">ใช้ประโยชน์ในงานราชการ</option>
                                        <option value="education_research">เพื่อการศึกษา/วิจัย</option>
                                        <option value="other">อื่นๆ</option>
                                    </select>
                                    <!-- ซ่อน textarea โดยเริ่มต้น -->
                                    <br>
                                    <textarea class="form-control" id="exampleFormControlTextarea2" name="exampleFormControlTextarea2" rows="3" style="display: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card form-section" id="meeting_note">
                    <div class="row ">
                        <div class="col-lg-1">
                            {{-- <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                            </div> --}}
                        </div>
                        <div class="col-lg-11">
                            <div class="row ">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <input type="hidden" name="meeting_type" value="meeting_note">
                                        <label for="text" class="form-label">บันทึกการออกเสียงลงคะแนน</label>
                                        <input type="text" class="form-control" id="title" name="title" aria-describedby="textHelp" placeholder="" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label for="text" class="form-label">ครั้งที่</label>
                                        <input type="text" class="form-control" id="meet" name="meet" aria-describedby="textHelp" placeholder="" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="">
                                        <label for="text" class="form-label">สมัย</label>
                                        <select class="form-control" id="periodSelect3" name="period" >
                                            <option value="">-- กรุณาเลือกหรือพิมพ์ --</option>
                                            @foreach ($period as $per)
                                                <option value="{{$per->id}}">{{ $per->name_type_period }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-3">
                                    <div>
                                        <label class="mb-2" for="#">วันที่ </label>
                                        <input type="date" class="form-control" id="meeting_date" name="date" width="276" >
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">วัตถุประสงค์ในการขอใช้บริการ</label>
                                    <select id="purposeSelect3" class="form-select" name="detail">
                                        <option value="government_work">ใช้ประโยชน์ในงานราชการ</option>
                                        <option value="education_research">เพื่อการศึกษา/วิจัย</option>
                                        <option value="other">อื่นๆ</option>
                                    </select>
                                    <!-- ซ่อน textarea โดยเริ่มต้น -->
                                    <br>
                                    <textarea class="form-control" id="exampleFormControlTextarea3" name="exampleFormControlTextarea3" rows="3" style="display: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="card form-section" id="other">
                    <div class="row ">
                        <div class="col-lg-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                            </div>
                        </div>
                        <div class="col-lg-11">
                            <div class="row ">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <input type="hidden" name="meeting_type" value="other">
                                        <label for="text" class="form-label">อื่น ๆ</label>
                                        <input type="text" class="form-control" id="text" name="title" aria-describedby="textHelp" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label for="text" class="form-label">ครั้งที่</label>
                                        <input type="text" class="form-control" id="text" name="meet" aria-describedby="textHelp" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="">
                                        <label for="text" class="form-label">สมัย</label>
                                        <select class="form-control" id="periodSelect" name="period">
                                            <option value="">-- กรุณาเลือกหรือพิมพ์ --</option>
                                            @foreach ($period as $per)
                                                <option value="{{$per->id}}">{{ $per->name_type_period }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div>
                                        <label for="#">วันที่ </label>
                                        <input type="date" class="form-control" id="meeting_date" name="date" width="276" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">วัตถุประสงค์</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="text" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="text-center">
                    <button type="submit" class="btn btn-success text-white">ยืนยัน</button>
                </div>
                </form>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $("#periodSelect").select2({
                tags: true,  // อนุญาตให้พิมพ์เองได้
                placeholder: "-- กรุณาเลือกหรือพิมพ์ --",
                allowClear: true
            });
        });

        $(document).ready(function() {
            $("#periodSelect2").select2({
                tags: true,  // อนุญาตให้พิมพ์เองได้
                placeholder: "-- กรุณาเลือกหรือพิมพ์ --",
                allowClear: true
            });
        });

        $(document).ready(function() {
            $("#periodSelect3").select2({
                tags: true,  // อนุญาตให้พิมพ์เองได้
                placeholder: "-- กรุณาเลือกหรือพิมพ์ --",
                allowClear: true
            });
        });

         $(document).ready(function() {
            // ซ่อนทุกฟอร์มเมื่อโหลดหน้า
            $(".form-section").hide();

            $("#meetingType").change(function() {
                var selectedValue = $(this).val();
                $(".form-section").hide().find("#title ").prop("required", false); // ซ่อนทุกฟอร์ม
                $("#" + selectedValue).show().find("#title").prop("required", true); // แสดงเฉพาะฟอร์มที่ตรงกับค่าที่เลือก
            });

            $("#meetingForm").submit(function() {
                $(".form-section").each(function() {
                    if ($(this).css("display") == "none") {
                        $(this).find("input,select, textarea").prop("disabled", true);
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            flatpickr("#meeting_date", {
                locale: "th", // ใช้ภาษาไทย
                dateFormat: "Y-m-d", // ใช้รูปแบบ YYYY-MM-DD
                defaultDate: new Date(), // กำหนดค่าเริ่มต้นเป็นวันที่ปัจจุบัน
                onReady: function(selectedDates, dateStr, instance) {
                    // คำนวณปีพ.ศ. (เพิ่ม 543) และแสดงปีใน input
                    let year = instance.currentYear + 543; // แปลงเป็น พ.ศ.
                    instance.input.value = dateStr.replace(instance.currentYear, year); // แสดงปีใน พ.ศ.
                },
                onYearChange: function(selectedDates, dateStr, instance) {
                    // แปลงปี พ.ศ. เมื่อเปลี่ยนปี
                    let year = instance.currentYear + 543; // เพิ่ม 543 เพื่อแปลงเป็น พ.ศ.
                    // เปลี่ยนแสดงปีในปฏิทินเป็น พ.ศ.
                    instance.currentYearElement.innerHTML = year;
                },
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length) {
                        let date = new Date(selectedDates[0]);
                        date.setFullYear(date.getFullYear()); // คำนวณปีเป็น ค.ศ.
                        
                        // ป้องกัน Time Zone Error
                        let offset = date.getTimezoneOffset() * 60000;
                        let correctDate = new Date(date.getTime() - offset);
                        
                        // แปลงวันที่ให้เป็นรูปแบบ YYYY-MM-DD (ค.ศ.) และแสดงใน input
                        let formattedDate = correctDate.toISOString().split("T")[0];
                        instance.input.value = formattedDate;

                        // แปลงปีใน input เป็น พ.ศ.
                        let year = correctDate.getFullYear() + 543; // เพิ่ม 543 เพื่อแปลงเป็น พ.ศ.
                        instance.input.value = formattedDate.replace(correctDate.getFullYear(), year); // แสดงเป็น พ.ศ.
                    }
                },
                onMonthChange: function(selectedDates, dateStr, instance) {
                    // เมื่อเดือนเปลี่ยนให้แปลงปีเป็น พ.ศ. ในการแสดงผล
                    let year = instance.currentYear + 543;
                    instance.currentYearElement.innerHTML = year;
                }
            });
        });

        const purposeSelect = document.getElementById('purposeSelect');
        const textarea = document.getElementById('exampleFormControlTextarea1');

        purposeSelect.addEventListener('change', function() {
            const selectedValue = purposeSelect.value;

            // ถ้าเลือก "อื่นๆ" (value = 'other') ให้แสดง textarea
            if (selectedValue === 'other') {
                textarea.style.display = 'block'; // แสดง textarea
                textarea.placeholder = 'กรุณาระบุรายละเอียด';
            } else {
                textarea.style.display = 'none'; // ซ่อน textarea
                textarea.value = ''; // เคลียร์ค่าของ textarea
            }
        });

        const purposeSelect2 = document.getElementById('purposeSelect2');
        const textarea2 = document.getElementById('exampleFormControlTextarea2');

        purposeSelect2.addEventListener('change', function() {
            const selectedValue = purposeSelect2.value;

            // ถ้าเลือก "อื่นๆ" (value = 'other') ให้แสดง textarea
            if (selectedValue === 'other') {
                textarea2.style.display = 'block'; // แสดง textarea
                textarea2.placeholder = 'กรุณาระบุรายละเอียด';
            } else {
                textarea2.style.display = 'none'; // ซ่อน textarea
                textarea2.value = ''; // เคลียร์ค่าของ textarea
            }
        });

        const purposeSelect3 = document.getElementById('purposeSelect3');
        const textarea3 = document.getElementById('exampleFormControlTextarea3');

        purposeSelect3.addEventListener('change', function() {
            const selectedValue = purposeSelect3.value;

            // ถ้าเลือก "อื่นๆ" (value = 'other') ให้แสดง textarea
            if (selectedValue === 'other') {
                textarea3.style.display = 'block'; // แสดง textarea
                textarea3.placeholder = 'กรุณาระบุรายละเอียด';
            } else {
                textarea3.style.display = 'none'; // ซ่อน textarea
                textarea3.value = ''; // เคลียร์ค่าของ textarea
            }
        });
        
    </script>
</body>
@endsection