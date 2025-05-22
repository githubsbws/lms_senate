@extends('admin/layouts/main2')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>
@php
$years = array_map(function ($year) {
    return $year + 543; // แปลงปี ค.ศ. เป็น พ.ศ.
}, range(date('Y'),1992));    
@endphp
<body id="body">
    <div class="warpper">
        <div class="content">
            <main>
                <div class="section">
                    <div class="section-header mb-3">
                        <h5 class="mb-0"></h5>
                    </div>
                    <form  action="{{ route('admin.document_file_edit',['file_id' => $file->id]) }}" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto">
                        @csrf
                    <div class="row g-3 mb-2">
                        <div class="col">
                            <label for="name" class="form-label">ชื่อการประชุม</label>
                            <input type="text" class="form-control" id="name" name="type_name" value="{{ $file->type_name }}">
                            <br>
                            <label for="name" class="form-label">สมัยที่ประชุม</label>
                            <select name="period" class="form-control">
                                @foreach ($period as $per)
                                    <option value="{{ $per->id }}" {{ (isset($file) && $file->period_id == $per->id) ? 'selected' : '' }}>
                                        {{ $per->name_type_period }}
                                    </option>
                                @endforeach
                            </select>
                            <br>
                            <label for="year" class="form-label">ปีที่ประชุม</label>
                            <select name="year" class="form-control">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ (isset($file) && $file->years == $year) ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <br>
                            <label for="name" class="form-label">ครั้งที่ประชุม</label>
                            <select name="meet" class="form-control">
                                @foreach ($meet as $met)
                                    <option value="{{ $met->id }}" {{ (isset($file) && $file->meet_id == $met->id) ? 'selected' : '' }}>
                                        {{ $met->name_type_meet }}
                                    </option>
                                @endforeach
                            </select>
                            <br>
                            <label for="name" class="form-label">ประเภทการประชุม</label>
                            <select name="cate" class="form-control">
                                @foreach ($cate as $ca)
                                    <option value="{{ $ca->id }}" {{ (isset($file) && $file->cate_id == $ca->id) ? 'selected' : '' }}>
                                        {{ $ca->name_type_cate }}
                                    </option>
                                @endforeach
                            </select>
                            <br>
                            <label for="name" class="form-label">รัฐธรรมนูญแห่งราชอาณาจักรไทย</label>
                            <select name="con" class="form-control">
                                @foreach ($con as $co)
                                    <option value="{{ $co->id }}" {{ (isset($file) && $file->con_id == $co->id) ? 'selected' : '' }}>
                                        {{ $co->name_type_con }}
                                    </option>
                                @endforeach
                            </select>
                            <br>
                            <label for="name" class="form-label">ข้อบังคับการประชุม</label>
                            <select name="rule" class="form-control">
                                @foreach ($rule as $ru)
                                    <option value="{{ $ru->id }}" {{ (isset($file) && $file->rule_id == $ru->id) ? 'selected' : '' }}>
                                        {{ $ru->name_type_rule }}
                                    </option>
                                @endforeach
                            </select>
                            <br>
                            <label for="" class="form-label">วันที่ประชุม</label>
                            <div class="input-group date" id="datepicker-wrapper">
                                <input type="date" class="form-control" name="date" id="datepicker" value="{{ $file->date_meet ? \Carbon\Carbon::createFromFormat('Y-m-d', $file->date_meet)->addYears(543)->format('Y-m-d') : '' }}" readonly>                                  
                            </div>
                            <br>
                            <label for="name" class="form-label">ประเภทเอกสาร</label>
                            <select name="doc" class="form-control">
                                @foreach ($doc as $do)
                                    <option value="{{ $do->id }}" {{ (isset($file) && $file->doc_id == $do->id) ? 'selected' : '' }}>
                                        {{ $do->name_type_doc }}
                                    </option>
                                @endforeach
                            </select>
                            <br>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-square-plus me-1"></i>
                                บันทึก
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script>
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
</body>
@endsection