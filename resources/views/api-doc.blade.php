<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>API Documentation - OCR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        h1 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            color: #007bff;
        }

        h2 {
            margin-top: 30px;
            color: #333;
        }

        code, pre,label {
            background: #eee;
            padding: 10px;
            border-radius: 5px;
            display: block;
            white-space: pre-wrap;
        }

        ul {
            padding-left: 20px;
        }

        .tag {
            background: #007bff;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.85em;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            color: #aaa;
            font-size: 0.9em;
        }
        .api-post {
            background-color: #4CAF50;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            margin-right: 8px;
            font-weight: bold;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>API Documentation</h1>

    <h2>📌 Endpoint</h2>
    {{-- <code id="api-value">1.POST /api/ocr-test <button id="copy" onclick="copyToClipboard()">คัดลอก</button></code>

    <code>2.POST /api/userpermission <button id="copy" onclick="copyToClipboard()">คัดลอก</button></code> --}}
    <label data-value="/api/userpermission"><span class="api-post">POST </span>/api/userpermission <button id="copy" onclick="copyToClipboard(this)">คัดลอก</button></label>
    <label data-value="/api/ocr-test"><span class="api-post">POST </span> /api/ocr-test <button id="copy" onclick="copyToClipboard(this)">คัดลอก</button></label>

    <h2>📩 Request Headers</h2>
    <ul>
        <li><strong>Content-Type:</strong> <code>application/json</code></li>
    </ul>

    <h2>📝 Request Body</h2>
    <p>ส่งข้อมูลแบบ JSON ดังนี้:</p>
    <pre>
{
    "text": "ข้อความที่ต้องการทดสอบ OCR"
}
    </pre>

    <h2>✅ ตัวอย่าง Response</h2>
    <pre>
{
    "status": "success",
    "message": "Data received"
}
    </pre>

    <h2>❌ Response เมื่อเกิดข้อผิดพลาด</h2>
    <pre>
{
    "status": "error",
    "message": "Invalid input"
}
    </pre>

    <footer>
        © 2025 OCR API — Internal Use Only
    </footer>
</div>
</body>
</html>
<script>
    function copyToClipboard(button) {
        const copyText = button.closest('label');  // ดึงข้อความจาก <code>
        const textToCopy = copyText.dataset.value;  // ใช้ innerText เพื่อดึงข้อความ
        navigator.clipboard.writeText(textToCopy)  // ใช้ Clipboard API เพื่อคัดลอก
            .then(() => {
                alert("คัดลอกแล้ว! ");
            })
            .catch(err => {
                alert("เกิดข้อผิดพลาดในการคัดลอก: " + err);
            });
    }
</script>