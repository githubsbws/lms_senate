@extends('admin/layouts/main')
@section('content')
<body id="body">
        <div class="content">
            <main>
                <div class="card border border-light-subtle">
                    <div class="card-body">
                        <p class="mb-2">จำนวนผู้เข้าใช้งานสูงสุดต่อเดือน (ประจำเดือน)</p>
                        <iframe 
                            width="100%" 
                            height="400" 
                            src="https://lookerstudio.google.com/embed/reporting/f31445e0-2ac9-4b86-9726-5c51264a1cbd/page/kIV1C" 
                            frameborder="0" 
                            style="border:0" 
                            allowfullscreen 
                            sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox">
                        </iframe>
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
    const labels = @json($labels);
    const totals = @json($totals);

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
        type: 'doughnut',
        data: {
            labels,
            datasets: [{
                data: totals,
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: (ctx) => `${ctx.label}: ${ctx.raw} คน`
                    }
                }
            }
        }
    });
</script>
@endsection