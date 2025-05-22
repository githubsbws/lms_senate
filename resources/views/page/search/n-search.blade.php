@extends('layout/mainlayout')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
    .pagination {
        display: flex;
        justify-content: flex-end;
    }
</style>

<body>
    <div class="search_normal">
        <section class="banner-toggle">
            <div class="warp">
                <div class="card">
                    <p>ระบบสืบค้นข้อมูลรายงานการประชุม บันทึกการประชุม </p>
                    <p>และบันทึกการออกเสียงลงคะแนน ของสำนักงานเลขาธิการวุฒิสภา</p>
                    <div class="warp-toggle">
                        <a class="btn btn-light" href="{{route ('frontend.a_search') }}">ค้นหารายงานการประชุม</a>
                        <a class="btn btn-light active" href="#">ค้นหารายงานการประชุมขั้นสูง</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="body-content main-form">
            <div class="container">
                <div class="warp">
                    <div class="card">
                        <form action="{{route('frontend.t_search')}}" method="get" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="form1" class="form-label">ชื่อการประชุม</label>
                                    <input type="text" class="form-control" name="meetName" id="meetName" aria-describedby="form1" value="{{ request()->meetName }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">ปีที่ประชุม</label>
                                    <select class="form-select" name="years" id="years" value="{{ request()->years }}"></select>
                            </div>
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">สมัยประชุม</label>
                                <select class="form-select" name="period" id="period">
                                    <option value="">--เลือกสมัยประชุม--</option>
                                    @foreach ($search['type_period'] as $item)
                                        <option value="{{ $item->id }}" 
                                            {{ request()->period == $item->id ? 'selected' : '' }}>
                                            {{ $item->name_type_period }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">ครั้งที่ประชุม</label>
                                <select class="form-select" name="meet" id="meet">
                                    <option value="">--เลือกครั้งที่ประชุม--</option>
                                    @foreach ($search['type_meet'] as $item)
                                        <option value="{{ $item->id }}" 
                                            {{ request()->meet == $item->id ? 'selected' : '' }}>
                                            {{ $item->name_type_meet }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">รัฐธรรมนูญแห่งราชอาณาจักรไทย</label>
                                <select class="form-select" name="con" id="con">
                                    <option value="">--เลือกรัฐธรรมนูญ--</option>
                                    @foreach ($search['type_con'] as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request()->con == $item->id ? 'selected' : '' }}>
                                            {{ $item->name_type_con }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">ข้อบังคับการประชุม</label>
                                <select class="form-select" name="rule" id="rule">
                                    <option value="">--เลือกข้อบังคับ--</option>
                                    @foreach ($search['type_rule'] as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request()->rule == $item->id ? 'selected' : '' }}>
                                        {{ $item->name_type_rule }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">ประเภทการประชุม</label>
                                <select class="form-select" name="cate" id="cate">
                                    <option value="">--เลือกประเภทการประชุม--</option>
                                    @foreach ($search['type_cate'] as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request()->rule == $item->id ? 'selected' : '' }}>
                                            {{ $item->name_type_cate }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="date" class="form-label">ค้นหาวันที่ประชุม</label>
                                <div class="input-group date" id="datepicker-wrapper">
                                    <input type="date" class="form-control" name="date" id="datepicker" value="{{ request()->date }}" readonly>                                  
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="" class="form-label">ค้นหารายงานการประชุม</label>
                                <input type="text" class="form-control" id="form1" name="search" aria-describedby="form1" placeholder="ค้นหารายงานการประชุม" value="{{request()->search}}">
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary" onclick="">ค้นหา</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>

        <section id="table-main1" class="table-main mt-5">
            <div class="container">
            @if (request()->query()) {{-- เช็คว่ามีการค้นหาหรือไม่ --}}
                @if ($getQuery->count() > 0)
                    {{-- @php
                        dd($getQuery);
                    @endphp --}}
                    <table class="table table-bordered table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">ชื่อการประชุม</th>
                                <th scope="col">ครั้งที่ประชุม</th>
                                <th scope="col">สมัยประชุม</th>
                                <th scope="col">วันที่ประชุม</th>
                                <th scope="col">ดูเอกสาร</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getQuery as $index => $item)                         
                                <tr>
                                    
                                    <td><p class="my-2">{{ @$item->type_name ? $item->type_name : '-'}}</p></td>
                                    <td><p class="my-3">{{ @$item->meet->name_type_meet ? $item->meet->name_type_meet : '-'}}</p></td>
                                    <td><p class="my-3">{{ @$item->period->name_type_period ? $item->period->name_type_period : '-'}}</p></td>
                                    <td><p class="my-3">{{ \Carbon\Carbon::parse($item->date_meet)->addYears(543)->locale('th')->translatedFormat('j F Y') }}</p></td>
                                    <td><a class="btn btn-primary" target="_blank" href="{{ asset ('uploads/pdf/'.$item->name_file) }}"><i class="bi bi-eye" style="color: white"></i></a></td>
                                </tr>           
                            @endforeach
                        </tbody>
                    </table>
                    <div class="paginate">
                        {{ $getQuery->links('pagination::bootstrap-5') }}
                    </div>              
                @else
                    <p>ไม่พบข้อมูลที่ตรงกับเงื่อนไขการค้นหา</p>
                @endif
            @endif
            </div>
        </section>

</body>
    <script>

        let yearSelect = document.getElementById("years");
        let currentYear = new Date().getFullYear() + 543;
        // console.log(currentYear);
        let startYear = 2535; // ปีเริ่มต้นที่สามารถเลือกได้
        let selectedYear = "{{ request('years') }}";
    
        // สร้าง option สำหรับแต่ละปี
        let defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = "--เลือกปี--";
        defaultOption.selected = true;
        yearSelect.appendChild(defaultOption);

        for (let year = currentYear; year >= startYear; year--) {
            let option = document.createElement("option");
            option.value = year;
            option.textContent = year;

            if (selectedYear && year == selectedYear) {
                option.selected = true;
            }

            yearSelect.appendChild(option);
        }
        document.addEventListener("DOMContentLoaded", function () {
            // ตรวจสอบว่ามี element นี้ในหน้าก่อนทำงาน
            if (!document.getElementById("datepicker")) return;

            // ตัวแปรควบคุมสถานะ
            let isManualYearInput = false; // ใช้ตรวจสอบว่ากำลังพิมพ์ปีเองหรือไม่

            // กำหนดภาษาไทย
            flatpickr.localize({
                ...flatpickr.l10ns.th,
                months: {
                    longhand: [
                        "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                        "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                    ]
                }
            });

            // ค่าเริ่มต้น - อ่านค่าจากฟิลด์ถ้ามี
            let defaultValue = document.getElementById("datepicker").value || null;
            let defaultDate = null;
            
            // แปลงค่าเริ่มต้นถ้ามี
            if (defaultValue) {
                const parts = defaultValue.split('-');
                if (parts.length === 3) {
                    const year = parseInt(parts[0]);
                    if (year > 2500) { // เป็น พ.ศ.
                        defaultDate = `${year-543}-${parts[1]}-${parts[2]}`;
                    } else { // เป็น ค.ศ.
                        defaultDate = defaultValue;
                    }
                }
            }

            const datepicker = flatpickr("#datepicker", {
                locale: "th",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "Y-m-d",
                defaultDate: defaultDate,
                onReady: function(selectedDates, dateStr, instance) {
                    // เพิ่ม event listener สำหรับช่องพิมพ์ปี
                    setTimeout(() => {
                        if (instance.currentYearElement) {
                            // ตรวจจับเมื่อพิมพ์ค่าปี
                            instance.currentYearElement.addEventListener("input", function(e) {
                                isManualYearInput = true;
                            });
                            
                            // ตรวจจับเมื่อพิมพ์เสร็จ (blur)
                            instance.currentYearElement.addEventListener("blur", function(e) {
                                if (isManualYearInput) {
                                    const yearValue = parseInt(e.target.value);
                                    if (yearValue > 0) {
                                        // ถ้าปีที่พิมพ์เป็น ค.ศ. (น้อยกว่า 2500) ให้แปลงเป็น พ.ศ.
                                        if (yearValue < 2500) {
                                            e.target.value = yearValue + 543;
                                        }
                                        // อัพเดตปฏิทิน
                                        const currentMonth = instance.currentMonth;
                                        const currentDay = instance.selectedDates.length ? instance.selectedDates[0].getDate() : 1;
                                        // ใช้ปี ค.ศ. ในการตั้งค่าภายใน (yearValue < 2500 ? yearValue : yearValue - 543)
                                        const newDate = new Date(yearValue < 2500 ? yearValue : yearValue - 543, currentMonth, currentDay);
                                        instance.setDate(newDate, true);
                                    }
                                    isManualYearInput = false;
                                }
                            });
                        }
                        
                        thaiYearFix(selectedDates, dateStr, instance);
                    }, 100);
                },
                onYearChange: function(selectedDates, dateStr, instance) {
                    // ไม่ทำอะไรถ้าเป็นการพิมพ์ปีเอง
                    if (!isManualYearInput) {
                        thaiYearFix(selectedDates, dateStr, instance);
                    }
                },
                onMonthChange: function(selectedDates, dateStr, instance) {
                    setTimeout(() => thaiYearFix(selectedDates, dateStr, instance), 10);
                },
                onOpen: function(selectedDates, dateStr, instance) {
                    setTimeout(() => thaiYearFix(selectedDates, dateStr, instance), 10);
                },
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length) {
                        const date = new Date(selectedDates[0]);
                        // แปลงเป็นปี พ.ศ.
                        const buddhistYear = date.getFullYear() + 543;
                        
                        const month = String(date.getMonth() + 1).padStart(2, "0");
                        const day = String(date.getDate()).padStart(2, "0");
                        
                        // กำหนดค่าที่จะส่งไปเป็น พ.ศ.
                        instance.input.value = `${buddhistYear}-${month}-${day}`;
                        
                        // ปรับการแสดงผลให้เป็น พ.ศ. ด้วย
                        instance.altInput.value = `${buddhistYear}-${month}-${day}`;
                    }
                }
            });

            function thaiYearFix(selectedDates, dateStr, instance) {
                try {
                    // แก้ไขปีในกล่องเลือกปีให้เป็น พ.ศ. เมื่อไม่ได้มีการพิมพ์เอง
                    if (instance.currentYearElement && !isManualYearInput) {
                        const currentYear = parseInt(instance.currentYearElement.value);
                        if (currentYear < 2500) {
                            instance.currentYearElement.value = currentYear + 543;
                        }
                    }
                    
                    // แก้ไขปีในรายการดรอปดาวน์ให้เป็น พ.ศ.
                    if (instance.yearElements && instance.yearElements.length) {
                        instance.yearElements.forEach(function(el) {
                            const year = parseInt(el.value);
                            if (year < 2500) {
                                el.textContent = (year + 543).toString();
                            }
                        });
                    }
                    
                    // อัพเดตการแสดงผลให้เป็น พ.ศ.
                    if (selectedDates.length && instance.altInput) {
                        const date = new Date(selectedDates[0]);
                        const buddhistYear = date.getFullYear() + 543;
                        const month = String(date.getMonth() + 1).padStart(2, "0");
                        const day = String(date.getDate()).padStart(2, "0");
                        instance.altInput.value = `${buddhistYear}-${month}-${day}`;
                    }
                } catch (error) {
                    console.error("เกิดข้อผิดพลาดในฟังก์ชัน thaiYearFix:", error);
                }
            }
        });


    </script>
@endsection


