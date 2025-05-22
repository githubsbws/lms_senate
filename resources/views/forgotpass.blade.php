<!DOCTYPE html>
<html lang="en">
<script src="https://unpkg.com/feather-icons"></script>
<head>
    <style>
        .error::before {
        font-family: 'bootstrap-icons'; /* หรือ FontAwesome ถ้าคุณใช้ */
        margin-right: 5px;
        display: inline-block;
        font-size: 12px;   
        }
        .error.false::before {
            content: "\F332"; /* หรือใช้ไอคอน Bootstrap: ใส่ content เป็น Unicode */
            color: red;
        }
        /* ถ้าเป็น success */
        .error.true::before {
            content: "\F26A"; /* หรือใช้ไอคอน Bootstrap: ใส่ content เป็น Unicode */
            color: green;
        }
        #password-error, #pass-confirm-error {
            display: none;
        }
        
    </style>
</head>
@include('layout.partials.head')

<body class="d-flex flex-column min-vh-100" style=" background: rgb(61,106,215); background: radial-gradient(circle, rgba(61,106,215,1) 50%, rgba(17,51,184,1) 85%);">
    <div class="main flex-grow-1 d-flex align-items-center justify-content-center p-3">
        <div class="card w-100 py-3 px-2" style="max-width: 460px;">
            <div class="card-body">
                <center>
                    <img src="{{asset('includes/image/logo.png')}}" width="117" height="118" class="mx-auto mb-3">
                </center>
                <h2 class="text-center fw-semibold mb-3" style="color: #2552C1;">Reset รหัสผ่าน</h2>
                {{-- <p class="fw-normal text-center" style="color: #8A92A6;">กรุณากรอกอีเมลที่ใช้ในการสมัคร</p> --}}
                @if (session('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            text: '{{ session('error') }}',
                            showConfirmButton: true
                        });
                    </script>
                    @php
                        session()->forget('error'); // ล้างเองหลังแสดง
                    @endphp
                @endif
                @if (!session('otp_sent') && !session('otp_pass'))
                    
                    <form id="forgotpassword-form" method="POST" action="{{ route('forgot.password.otp') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="email" name="email" id="email" class="form-control" required placeholder="กรุณากรอกอีเมล">     
                            <span class="email-error"></span>                  
                        </div>                   
                        <div class="d-grid gap-2 mb-3 d-flex justify-content-center ">
                            <button class="btn btn-primary w-50" type="submit">
                                ส่งรหัสยืนยัน
                            </button>
                        </div>
                    </form>
                    {{-- <div class="login text-center mt-2 mb-2">
                        <span>มีบัญชีผู้ใช้งานอยู่แล้ว? </span>
                        <span><a href="{{route('login')}}" class="text-primary">กลับหน้าlogin</a></span>
                    </div> --}}
                    <script>
                        document.getElementById('forgotpassword-form').addEventListener('submit', async function (e) {
                            e.preventDefault();

                            let isEmailInside = false;
                            let hasError = false;
                            const emailVerify = document.getElementById('email').value.trim();
                            const emailErrorSpan = document.querySelector(".email-error");
                            if(emailVerify){
                                try {
                                    const res = await fetch("{{ route('forgot.chk.email') }}", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify({ email: emailVerify })
                                    });

                                    const data = await res.json();

                                    if (data.not_found) {
                                        emailErrorSpan.innerHTML = `<i class="bi bi-x-circle-fill"></i> ไม่พบอีเมลนี้ในระบบ`;
                                        emailErrorSpan.style.color = "red";
                                        isEmailInside = true;
                                    } else if (data.exists) {
                                        emailErrorSpan.innerHTML = `<i class="bi bi-x-circle-fill"></i> เป็นอีเมลของทางวุฒิสภา กรุณาติดต่อสำนักงาน`;
                                        emailErrorSpan.style.color = "red";
                                        isEmailInside = true;
                                    } else {
                                        emailErrorSpan.innerHTML = `<i class="bi bi-check-circle-fill"></i> ยืนยันสำเร็จ`;
                                        emailErrorSpan.style.color = "green";
                                    }
                                } catch (error) {
                                    console.error("Error checking email:", error);
                                    emailErrorSpan.innerText = 'ไม่สามารถตรวจสอบอีเมลได้';
                                    emailErrorSpan.style.color = 'red';
                                    hasError = true;
                                }
                            }

                            if (!hasError && !isEmailInside) {
                                e.target.submit();
                            }
                        });
                    </script>
                @endif
                @if (session('otp_sent') && !session('otp_pass'))
                <form id="otpverify-form" method="POST" action="{{ route('forgot.otp.verify') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="hidden" name="email" id="email" value="{{ session('email') }}">
                            <label for="otp" style="font-size:14px">กรุณากรอกรหัส OTP ที่ส่งไปยัง <span style="color: green">{{ session('email') }}</span></label>
                            <input type="text" name="otpverify" id="otpverify" class="form-control" required placeholder="ใส่OTPที่ได้รับ"> 
                            <span class="otp-error"></span>        
                            
                            <!-- 🔻 นับถอยหลัง -->
                            <div id="otp-timer" style="margin-top: 5px; font-size: 14px; color: #555;"></div>

                            <!-- 🔻 ปุ่มส่ง OTP อีกครั้ง (เริ่มต้นซ่อน) -->
                            <button type="button" class="btn btn-link p-0" id="resend-otp-btn" style="display: none;">
                                ส่ง OTP อีกครั้ง
                            </button>
                        </div>                   
                        <div class="d-grid gap-2 mb-3 d-flex justify-content-center ">
                            <button class="btn btn-primary w-50" type="submit">
                                ยืนยันOTP
                            </button>
                        </div>
                    </form>
                    <script>
                        let countdown = 120; // 2 minutes
                        let timerInterval = null;

                        function startOtpTimer() {
                            const timerEl = document.getElementById('otp-timer');
                            const resendBtn = document.getElementById('resend-otp-btn');
                            resendBtn.style.display = 'none';

                            timerInterval = setInterval(() => {
                                const minutes = Math.floor(countdown / 60);
                                const seconds = countdown % 60;
                                timerEl.textContent = `รหัส OTP จะหมดอายุใน ${minutes}:${seconds.toString().padStart(2, '0')} นาที`;

                                countdown--;

                                if (countdown < 0) {
                                    clearInterval(timerInterval);
                                    timerEl.textContent = 'หมดเวลา OTP แล้ว';
                                    resendBtn.style.display = 'inline';
                                }
                            }, 1000);
                        }

                        // เรียกใช้นับถอยหลังเมื่อโหลดหน้า
                        document.addEventListener("DOMContentLoaded", () => {
                            startOtpTimer();
                        });

                        document.getElementById('resend-otp-btn').addEventListener('click', async function () {
                            this.disabled = true;
                            this.textContent = 'กำลังส่ง...';

                            try {
                                const res = await fetch("{{ route('forgot.password.otp') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({ email: document.getElementById('email').value })
                                });

                                const data = await res.json();

                                if (data.success) {
                                    alert("ส่ง OTP ใหม่เรียบร้อยแล้ว");
                                    countdown = 120; // reset timer
                                    startOtpTimer();
                                } else {
                                    alert("ไม่สามารถส่ง OTP ได้ กรุณาลองใหม่");
                                }
                            } catch (error) {
                                console.error("Error resending OTP:", error);
                                alert("เกิดข้อผิดพลาดในการส่ง OTP");
                            } finally {
                                this.disabled = false;
                                this.textContent = 'ส่ง OTP อีกครั้ง';
                            }
                        });

                        document.getElementById('otpverify-form').addEventListener('submit', async function (e) {
                            e.preventDefault();

                            let isOtpVerify = false;
                            let hasError = false;
                            const emailOtpVerify = document.getElementById('email').value.trim();
                            const otpVerify = document.getElementById('otpverify').value.trim();
                            const otpErrorSpan = document.querySelector(".otp-error");
                            if(emailOtpVerify){
                                try {
                                    const res = await fetch("{{ route('forgot.chk.otp') }}", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify({ email: emailOtpVerify,otp: otpVerify })
                                    });

                                    const data = await res.json();
                                    if(data.expire){
                                        otpErrorSpan.innerHTML = `<i class="bi bi-x-circle-fill"></i> otp หมดอายุ`;
                                        otpErrorSpan.style.color = "red";
                                        isOtpVerify = true;
                                    }
                                    else if (data.exists) {
                                        otpErrorSpan.innerHTML = `<i class="bi bi-x-circle-fill"></i> otp ไม่ถูกต้อง กรุณาตรวจสอบใหม่`;
                                        otpErrorSpan.style.color = "red";
                                        isOtpVerify = true;
                                    } else {
                                        otpErrorSpan.innerHTML = `<i class="bi bi-check-circle-fill"></i> ยืนยันสำเร็จ`;
                                        otpErrorSpan.style.color = "green";
                                    }
                                } catch (error) {
                                    console.error("Error checking email:", error);
                                    otpErrorSpan.innerText = 'ไม่สามารถตรวจสอบอีเมลได้';
                                    otpErrorSpan.style.color = 'red';
                                    hasError = true;
                                }
                            }

                            if (!hasError && !isOtpVerify) {
                                e.target.submit();
                            }

                        });  
                    </script>
                @endif
                @if (session('otp_pass') && !session('otp_sent'))
                <form id="renewpassword-form" method="POST" action="{{ route('forgot.renew.password') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="hidden" name="email" id="email" value="{{ session('email') }}">
                            <label for="otp" style="font-size:14px">กรุณากรอกรหัสใหม่</label>
                            <div class="input-group passlock">
                                <input class="form-control renewpassword" placeholder="ตัวอย่าง Passsword@1234" id="renewpassword" name="renewpassword" type="password" minlength="8" required />
                                <span class="bg-white input-group-text togglePassword">
                                    <i data-feather="eye" style="cursor: pointer"></i>
                                </span>
                            </div>
                            <div class="mt-1">
                                <span class="text-danger" id="password-error"><i class="bi bi-exclamation-circle-fill"></i> กรุณากรอกรหัสผ่านให้ถูกต้อง</span>
                            </div>
                            <span class="description" style="font-size: 12px">รหัสผ่านต้องมีอย่างน้อย 8 หลักประกอบด้วย
                                <ul style="font-size: 12px">
                                    <li id="upper-rule">ตัวอักษรภาษาอังกฤษพิมพ์ใหญ่</li>
                                    <li id="lower-rule">ตัวอักษรภาษาอังกฤษพิมพ์เล็ก</li>
                                    <li id="number-rule">ตัวเลข (0-9)</li>
                                    <li id="special-rule">อักขระพิเศษ (!@#$%^*_-+=)</li>
                                </ul>
                            </span>                     
                        </div>  
                        <div class="form-group mb-3">
                            <label for="otp" style="font-size:14px">ยืนยันรหัสผ่าน</label>
                            <div class="input-group passlock">
                                <input type="password" name="confirm_renewpassword" id="confirm_renewpassword" class="form-control password" required placeholder="ตัวอย่าง Passsword@1234"> 
                            </div>
                        </div>
                        <div class="mt-0">
                            <span class="text-danger" id="pass-confirm-error"><i class="bi bi-exclamation-circle-fill"></i> กรุณาตรวจสอบรหัสผ่านอีกครั้ง</span>
                        </div>
                        <div class="d-grid gap-2 mb-3 d-flex justify-content-center mt-3">
                            <button class="btn btn-primary w-50" type="submit">
                                บันทึกข้อมูล
                            </button>
                        </div>
                    </form>
                    <script>
                        feather.replace({
                            'aria-hidden': 'true'
                        });

                        $(".togglePassword").click(function(e) {
                            e.preventDefault();
                            var type = $(this).parent().parent().find(".renewpassword").attr("type");
                            console.log(type);
                            if (type == "password") {
                                $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
                                $(this).parent().parent().find(".renewpassword").attr("type", "text");
                            } else if (type == "text") {
                                $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
                                $(this).parent().parent().find(".renewpassword").attr("type", "password");
                            }
                        });

                        const passwordInput = document.getElementById('renewpassword');
                        const confirmInput = document.getElementById('confirm_renewpassword');

                        // เพิ่ม element rule ของเงื่อนไข
                        const upperRule = document.getElementById('upper-rule');
                        const lowerRule = document.getElementById('lower-rule');
                        const numberRule = document.getElementById('number-rule');
                        const specialRule = document.getElementById('special-rule');

                         function isPasswordStrong(password) {
                            const hasUpperCase = /[A-Z]/.test(password);
                            const hasLowerCase = /[a-z]/.test(password);
                            const hasNumber = /[0-9]/.test(password);
                            const hasSpecialChar = /[!@#$%^*_+=\-]/.test(password);
                            return password.length >= 8 && hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar;
                        }

                        function validatePassword() {
                            const password = passwordInput.value;
                            const confirm = confirmInput.value;

                            // เงื่อนไขความแข็งแรงของรหัสผ่าน
                            const isLongEnough = password.length >= 8;
                            const hasUpperCase = /[A-Z]/.test(password);
                            const hasLowerCase = /[a-z]/.test(password);
                            const hasNumber = /[0-9]/.test(password);
                            const hasSpecialChar = /[!@#$%^*_+=\-]/.test(password); // ปลอดภัย

                            

                            // แสดงผลใน list เงื่อนไข
                            upperRule.style.color = hasUpperCase ? 'green' : 'red';
                            lowerRule.style.color = hasLowerCase ? 'green' : 'red';
                            numberRule.style.color = hasNumber ? 'green' : 'red';
                            specialRule.style.color = hasSpecialChar ? 'green' : 'red'

                            const isPasswordStrong = isLongEnough && hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar;

                        }

                        passwordInput.addEventListener('input', validatePassword);
                        confirmInput.addEventListener('input', validatePassword);

                        function checkPasswordMatch(password,confirm) {
                            if(confirm === password){
                                return true
                            }else{
                                return false;
                            }
                        }

                        function showError(element, condition) {
                            element.style.display = condition ? 'none' : 'block';
                            return !condition; // true = มี error
                        }
                        document.getElementById('renewpassword-form').addEventListener('submit', async function (e) {
                            e.preventDefault();

                            const emailFinal = document.getElementById('email').value.trim();
                            const password = passwordInput.value;
                            const confirm = confirmInput.value;
                            
                            const hasError = [
                                showError(document.getElementById('password-error'), isPasswordStrong(password)),
                                showError(document.getElementById('pass-confirm-error'), checkPasswordMatch(password, confirm))
                            ].some(Boolean);

                            if (!hasError) {
                                e.target.submit();
                            }

                        });  
                    </script>
                @endif
            </div>
        </div>
    </div>
</body>
