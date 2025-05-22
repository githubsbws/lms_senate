import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// ฟัง Event
Echo.channel('file-upload-progress.' + fileId) // ใช้ fileId เพื่อฟังใน channel เฉพาะ
    .listen('FileUploadProgress', (event) => {
        console.log(event.progress);  // แสดงความคืบหน้าการอัปโหลด
        updateProgressBar(event.progress);  // ฟังก์ชันอัปเดต progress bar
    });

function updateProgressBar(progress) {
    // อัปเดต progress bar ที่ frontend
    const progressBar = document.getElementById('progress-bar');
    progressBar.style.width = progress + '%';
}
