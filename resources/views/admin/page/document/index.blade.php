@extends('admin/layouts/main')
@section('content')
    <body id="body">
        <div class="warpper">
            <div class="content">
                <main>
                    <div class="section">
                        <div class="section-header mb-3">
                            <h5 class="mb-0"></h5>
                        </div>
                        <div class="section-body">
                            <div class="card">
                                <div class="card-body">
                                    <table id="searchTable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">สมัยที่ประชุม</th>
                                                <th class="text-center">ปีที่ประชุม</th>
                                                <th class="text-center">ประเภทการประชุม</th>
                                                <th class="text-center">ครั้งที่ประชุม</th>
                                                <th class="text-center">รัฐธรรมนูญแห่งราชอาณาจักรไทย</th>
                                                <th class="text-center">ข้อบังคับการประชุม</th>
                                                <th class="text-center">ชื่อเอกสาร</th>
                                                <th class="text-center">ชื่อไฟล์</th>
                                                <th class="text-center">รายละเอียด</th>
                                                <th class="text-center">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div id="upload-toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>
    </body>
    <script>
        $(document).ready(function() {
            $('#searchTable').DataTable({
                serverSide: true, // เปิดใช้งาน Server-Side Processing
                processing: true, // แสดง Loading Animation
                ajax: "{{ route('admin.text_data') }}", // URL ของ API สำหรับดึงข้อมูล
                columns: [
                    { data: 'period_name', name: 'file.period.name_type_period' },
                    { data: 'years', name: 'file.years' },
                    { data: 'cate_name', name: 'file.cate.name_type_cate' },
                    { data: 'meet_name', name: 'file.meet.name_type_meet' },
                    { data: 'con_name', name: 'file.con.name_type_con' },
                    { data: 'rule_name', name: 'file.rule.name_type_rule' },
                    { data: 'type_name', name: 'file.type_name' },
                    { data: 'name_file', name: 'file.name_file' },
                    { 
                        data: 'text', 
                        name: 'text', 
                        render: function(data, type, row) {
                            return data.length > 150 ? data.substr(0, 150) + '...' : data;
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    url: '/includes/languageDataTable.json' // ระบุไฟล์ JSON สำหรับข้อความภาษา
                },
                pageLength: 10 // ตั้งค่าจำนวนข้อมูลต่อหน้า
            });
        });
        const fileId = new URLSearchParams(window.location.search).get('file_id');
        const fileIds = new Set(); // ใช้ Set เพื่อเก็บไม่ซ้ำ
        const uploadToasts = {};
        console.log(fileId)

        function createToast(fileId) {
            if (uploadToasts[fileId]) return; // สร้างแล้ว ไม่ต้องสร้างซ้ำ
            console.log('createToast')
            const container = document.getElementById('upload-toast-container');

            const toastHTML = `
                <div class="toast mb-2" id="upload-toast-${fileId}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">
                    <div class="toast-header">
                        <strong class="me-auto">กำลังอัปโหลดไฟล์ ${fileId}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <div class="progress">
                            <div id="progress-bar-${fileId}" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', toastHTML);

            const toastElement = document.getElementById(`upload-toast-${fileId}`);
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            uploadToasts[fileId] = toast;
        }

        function updateProgress(fileId, progress) {
            const bar = document.getElementById(`progress-bar-${fileId}`);
            if (!bar) return;

            bar.style.width = `${progress}%`;
            bar.setAttribute('aria-valuenow', progress);

            if (progress === 100) {
                setTimeout(() => {
                    uploadToasts[fileId]?.hide();
                    delete uploadToasts[fileId];
                    fileIds.delete(fileId); // ลบออกจาก Set เมื่อเสร็จ
                }, 1000);
            }
        }

        // รับ event จากทุกช่อง channel ที่มีรูปแบบนี้
        echo.channel('file-upload-all')
    .listenForWhisper('debug', (e) => {
        console.log('👂 whisper:', e);
    })
    .listen('.FileUploadProgress', (e) => {
        console.log('🔥 event received:', e);
    });
        echo.connector.pusher.connection.bind('connected', () => {
            console.log('✅ Connected to Pusher');
        });

        let progress = 0;
const fakeProgressInterval = setInterval(() => {
    progress += 10;
    updateProgress('13804', progress);
    
    if (progress >= 100) {
        clearInterval(fakeProgressInterval); // หยุดเมื่อ progress ถึง 100
    }
}, 1000);
    </script>
@endsection
