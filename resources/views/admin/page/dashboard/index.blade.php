@extends('admin/layouts/main')
@section('content')
<body id="body">
    <div class="warpper">
        <div class="content">
            <main>
                <div class="section mb-5">
                    <div class="section-header mb-3">
                        <h5 class="mb-0">กราฟแสดงจำนวนผู้เข้าใช้งานทั้งหมด</h5>
                    </div>
                    <div class="section-body">
                        <div class="row row-cols-3 mb-3">
                            <div class="col">
                                <div class="statusCard statusCard-1 p-3">
                                    <div class="statusCard-section">
                                        <p class="mb-0 fw-semibold text-white">ผู้ใช้วันนี้</p>
                                        <p class="mb-1 fw-semibold text-white"><span class="fs-4 text-white">89</span> คน</p>
                                        <p class="mb-0 fs-6 text-white"><span class="text-status-up">+3%</span> ตั้งแต่สัปดาห์ที่แล้ว</p>
                                    </div> 
                                    <i class="statusIcons fa-solid fa-chart-line"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="statusCard statusCard-2 p-3">
                                    <div class="statusCard-section">
                                        <p class="mb-0 fw-semibold text-white">ผู้ใช้ภายในเดือนนี้</p>
                                        <p class="mb-1 fw-semibold text-white"><span class="fs-4 text-white">341</span> คน</p>
                                        <p class="mb-0 fs-6 text-white"><span class="text-status-down">-1%</span> ตั้งแต่เดือนห์ที่แล้ว</p>
                                    </div> 
                                    <i class="statusIcons fa-solid fa-chart-simple"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="statusCard statusCard-3 p-3">
                                    <div class="statusCard-section">
                                        <p class="mb-0 fw-semibold text-white">ผู้ใช้งานใหม่</p>
                                        <p class="mb-1 fw-semibold text-white"><span class="fs-4 text-white">341</span> คน</p>
                                        <p class="mb-0 fs-6 text-white"><span class="text-status-up">+1%</span> ตั้งแต่เดือนห์ที่แล้ว</p>
                                    </div> 
                                    <i class="statusIcons fa-solid fa-user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card border border-light-subtle">
                            <div class="card-body">
                                <p class="mb-2">จำนวนผู้เข้าใช้งานสูงสุดต่อเดือน (ประจำเดือน)</p>
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section">
                    <div class="section-header mb-3">
                        <h5 class="mb-0">กราฟแสดงแบบสำรวจความพึงพอใจ</h5>
                    </div>
                    <div class="section-body">
                        <div class="row row-cols-2 mb-3">
                            <div class="col">
                                <div class="card border border-light-subtle">
                                    <div class="card-body">
                                        <canvas id="chart2"></canvas>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
<script>
    const ctx1 = document.getElementById('chart1');
    const ctx2 = document.getElementById('chart2');

    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],
            datasets: [{
                label: 'จำนวนผู้ใช้งาน',
                data: [90,80,100,120,163,124,119,190,86,76,104,192],
                fill: false,
                borderColor: 'rgb(60, 105, 215)',
                tension: 0.1
            }]
        }
    });
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['น้อย', 'ปานกลาง', 'มาก', 'มากที่สุด'],
            datasets: [{
                label: 'คะแนนความพึงพอใจ',
                data: [59, 75, 42, 66],
                borderWidth: 1
            }]
        },
    });
</script>
@endsection