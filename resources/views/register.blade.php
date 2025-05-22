<!DOCTYPE html>
<html lang="en">
<title>Register Senate</title>
<script src="https://unpkg.com/feather-icons"></script>
<style>
    .passlock .fa-lock {
        position: absolute;
        top: 9px;
        left: 12px;
        color: #fff;
        background-color: #999999 !important;
        padding: 4px;
        border-radius: 50% !important;
        font-size: 14px;
        z-index: 3 !important;
    }

    .passlock .form-control {
        text-indent: 26px;
    }

    .navbar {
        display: none !important;
    }

    .footer-main {
        display: none !important;
    }
    .description {
        font-size: 14px;
        color: gray;
    }
    .text-danger {
        font-size: 12px;
    }
    #password-error, #pass-confirm-error {
        display: none;
    }
    .error::before {
        font-family: 'bootstrap-icons'; /* หรือ FontAwesome ถ้าคุณใช้ */
        margin-right: 5px;
        display: inline-block;
        font-size: 14px;   
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
    
</style>

@include('layout.partials.head')


<body>
    <section class="register d-flex justify-content-center">
        <div class="wrap col-xl-3">
            <form id="register-form" method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="text-center">
                    <a href="index.php"><img src="{{asset('assets/images/newimg/logonav.png')}}"></a>
                    <p>สํานักรายงานการประชุมและชวเลข</p>
                    <h3>ลงทะเบียนสมาชิก</h3>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">ชื่อผู้ใช้งาน<span style="color: red"> * ใช้ภาษาอังกฤษกับตัวเลขเท่านั้น</span></label>
                    <input type="text" class="form-control" id="username" name="username"  placeholder="ชื่อผู้ใช้งาน"  required title="กรุณากรอกเฉพาะอักษรภาษาอังกฤษและตัวเลข">
                    <span class="username-error"></span>
                    
                </div>
                <div class="mb-3">
                    <label for="form1" class="form-label">คำนำหน้า<span style="color: red"> *</span></label>
                    <input type="text" class="form-control" id="name_title" name="name_title" aria-describedby="text" placeholder="คำนำหน้า" required >
                    <span class="name-title-error"></span>
                    
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="form1" class="form-label">ชื่อ<span style="color: red"> *</span></label>
                        <input type="text" class="form-control" id="firstname" name="firstname" aria-describedby="text" placeholder="ชื่อ" required>
                        <span class="firstname-error"></span>
                        
                    </div>
                    <div class="col-md-6">
                        <label for="form2" class="form-label">นามสกุล<span style="color: red"> *</span></label>
                        <input type="text" class="form-control" id="lastname" name="lastname" aria-describedby="text" placeholder="นามสกุล" required>
                        <span class="lastname-error"></span>
                        
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="form2" class="form-label">เลขบัตรประจำตัว 13หลัก<span style="color: red"> *</span></label>
                    <input type="text" class="form-control" id="id_card" name="id_card" aria-describedby="text" placeholder="0-0000-00000-00-0" required title="กรุณากรอกเลขบัตรประจำตัว 13 หลัก" maxlength="13">
                    <span class="error"></span><br>
                    <span class="ident-error"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label">วันเดือนปีเกิด<span style="color: red"> *</span></label>
                    <div class="row">
                        <!-- วัน -->
                        <div class="col-xl-3">
                            <select class="form-select" id="dob_day" name="dob_day">
                                <option selected disabled>วัน</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                
                        <!-- เดือน -->
                        <div class="col-xl-6">
                            <select class="form-select" id="dob_month" name="dob_month">
                                <option selected disabled>เดือน</option>
                                @php
                                    $months = [
                                        1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม',
                                        4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
                                        7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน',
                                        10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
                                    ];
                                @endphp
                                @foreach ($months as $num => $name)
                                    <option value="{{ $num }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <!-- ปี -->
                        <div class="col-xl-3">
                            <select class="form-select" id="dob_year" name="dob_year">
                                <option selected disabled>ปี</option>
                                @for ($y = now()->year; $y >= 1900; $y--)
                                    <option value="{{ $y }}">{{ $y + 543 }}</option> <!-- แสดงปี พ.ศ. -->
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="emploee_type" class="form-label">สถานะบุคคล<span style="color: red"> *</span></label>
                    <select class="form-select" id="emploee_type" name="employee_type" required>
                        <option selected disabled>เลือกสถานะ</option>
                        <option value=1>สมาชิกวุฒิสภา</option>
                        <option value=2>บุคคลในวงงานรัฐสภา</option>
                        <option value=3>หน่วยงาน/บุคคลภายนอก</option>
                    </select>
                </div>
                <div class="mb-3" id="externalInput" style="display: none;">
                    <label for="external_detail" class="form-label">กรุณาระบุหน่วยงาน/บุคคลภายนอก</label>
                    <input type="text" class="form-control" id="external_detail" name="external_detail" placeholder="ระบุหน่วยงานหรือชื่อบุคคล">
                </div>

                <div class="mb-3">
                    <label for="form2" class="form-label">อีเมล<span style="color: red"> *</span></label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="text" placeholder="อีเมล" required>
                    <span class="email-error"></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">รหัสผ่าน<span style="color: red"> *</span></label>
                    <div class="input-group passlock">
                        <input class="form-control password border-end-0" placeholder="รหัสผ่าน" id="password" name="password" type="password" minlength="8" required />
                        <i class="fa-solid fa-lock" id="password-icon"></i>
                        <span class="bg-white input-group-text togglePassword">
                            <i data-feather="eye" style="cursor: pointer"></i>
                        </span>
                    </div>
                    <div class="mt-1">
                        <span class="text-danger" id="password-error"><i class="bi bi-exclamation-circle-fill"></i> กรุณากรอกรหัสผ่านให้ถูกต้อง</span>
                    </div>
                    <span class="description">รหัสผ่านต้องมีอย่างน้อย 8 หลักประกอบด้วย
                        <ul>
                            <li id="upper-rule">ตัวอักษรภาษาอังกฤษพิมพ์ใหญ่</li>
                            <li id="lower-rule">ตัวอักษรภาษาอังกฤษพิมพ์เล็ก</li>
                            <li id="number-rule">ตัวเลข (0-9)</li>
                            <li id="special-rule">อักขระพิเศษ (!@#$%^*_-+=)</li>
                        </ul>
                    </span>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">ยืนยันรหัสผ่าน<span style="color: red"> *</span></label>
                    <div class="input-group passlock">
                        <input class="form-control password border-end-0" placeholder="ยืนยันรหัสผ่าน" id="confirm_password" name="confirm_password" type="password" required />
                        <i class="fa-solid fa-lock" id="confirm-icon"></i>
                    </div>
                    <div class="mt-1">
                        <span class="text-danger" id="pass-confirm-error"><i class="bi bi-exclamation-circle-fill"></i> กรุณาตรวจสอบรหัสผ่านอีกครั้ง</span>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="consentCheckbox" />
                    <label class="form-check-label" for="consentCheckbox" style="font-size:12px">ข้าพเจ้าตกลงและยินยอมให้มีการเก็บรวบรวม ใช้ และเปิดเผยข้อมูลส่วนบุคคลเพื่อวัตถุประสงค์ในการลงทะเบียน</label>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary w-100" id="submitRegister" disabled>ยืนยันลงทะเบียน</button>
                </div>
            </form>

            <div class="login text-center mt-2 mb-2">
                <span>มีบัญชีผู้ใช้งานอยู่แล้ว? </span>
                <span><a href="{{route('login')}}" class="text-primary">เข้าสู่ระบบ</a></span>
            </div>

        </div>
    </section>
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


</body>

<script>
    feather.replace({
        'aria-hidden': 'true'
    });

    $(".togglePassword").click(function(e) {
        e.preventDefault();
        var type = $(this).parent().parent().find(".password").attr("type");
        console.log(type);
        if (type == "password") {
            $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
            $(this).parent().parent().find(".password").attr("type", "text");
        } else if (type == "text") {
            $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
            $(this).parent().parent().find(".password").attr("type", "password");
        }
    });

    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('confirm_password');
    const passwordIcon = document.getElementById('password-icon');
    const confirmIcon = document.getElementById('confirm-icon');

    // เพิ่ม element rule ของเงื่อนไข
    const upperRule = document.getElementById('upper-rule');
    const lowerRule = document.getElementById('lower-rule');
    const numberRule = document.getElementById('number-rule');
    const specialRule = document.getElementById('special-rule');

    const consentCheckbox = document.getElementById('consentCheckbox');
    const submitRegister = document.getElementById('submitRegister');

    consentCheckbox.addEventListener('change', () => {
        submitRegister.disabled = !consentCheckbox.checked;
    });
    
    //ไว้เช็ค input ของ password ว่าเงื่อนไขครบไหม
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

        // รหัสผ่านหลัก
        if (isPasswordStrong) {
            passwordIcon.classList.add('text-success'); // สีเขียว
            passwordIcon.classList.remove('text-danger'); // ลบสีแดงถ้ามี
        } else {
            passwordIcon.classList.remove('text-success');
            passwordIcon.classList.add('text-danger'); // เพิ่มสีแดงถ้าไม่ผ่าน
        }

        // ยืนยันรหัสผ่าน
        if (confirm.length >= 8 && confirm === password) {
            confirmIcon.classList.add('text-success');
            confirmIcon.classList.remove('text-danger');
        } else {
            confirmIcon.classList.remove('text-success');
            confirmIcon.classList.add('text-danger');
        }
    }

    function checkPasswordMatch(password,confirm) {
        if(confirm === password){
            return true
        }else{
            return false;
        }
    }


    passwordInput.addEventListener('input', validatePassword);
    confirmInput.addEventListener('input', validatePassword);

    //////

    const select = document.getElementById('emploee_type');
    const externalInput = document.getElementById('externalInput');

    select.addEventListener('change', function () {
        if (this.value === '3') {
            externalInput.style.display = 'block';
        } else {
            externalInput.style.display = 'none';
        }
    });
    //กรอง pattern ในการใส่ค่าในช่อง username
    document.getElementById('username').addEventListener('input',function(){
        this.value = this.value.replace(/[^a-zA-Z0-9]/g,'');
    })
    //ปรับวัน ให้เข้ากับเดือน เช่น คม 31 ยน 30 กุมภา 29
    document.getElementById('dob_month').addEventListener('change',function(){
        const selectedMonth = parseInt(this.value);
        const daySelect = document.getElementById('dob_day');
        
        // ดึงค่าของวันที่ที่เลือกไว้ก่อนหน้า (ถ้ามี)
        const selectedDay = parseInt(daySelect.value) || null;
        let daysInMonth = 31;
        if ([4, 6, 9, 11].includes(selectedMonth)) {
            daysInMonth = 30; // เม.ย., มิ.ย., ก.ย., พ.ย. → 30 วัน
        } else if (selectedMonth === 2) {
            daysInMonth = 29; // ก.พ. → 29 วัน (รองรับปีอธิกสุรทินแบบง่าย)
        }

        // ล้าง options เก่า ยกเว้น option แรก (placeholder)
        daySelect.innerHTML = '<option selected disabled>วัน</option>';

        // เพิ่ม options ใหม่ตามจำนวนวัน
        for (let i = 1; i <= daysInMonth; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            if (i === selectedDay && i <= daysInMonth) { //หากเลือกมีการเลือกวันไว้แล้ว แล้วเลือกเดือนที่วันมีไม่ถึงที่เลือก จะล้างค่าวันทิ้ง
                option.selected = true;
            }
            daySelect.appendChild(option);
        }
    })

    //function เช็คเลขบัตรตามทะเบียนราษฎ์ พร้อมแสดง error
    document.getElementById('id_card').addEventListener('input', function() {
        var inputValue = this.value.replace(/\D/g, ''); //
        var formattedValue = '';
        var chunkLengths = [1, 4, 5, 2, 1]; // จำนวนตัวเลขในแต่ละช่วง

        if (inputValue.length === 13) {
            for (var i = 0, len = chunkLengths.length; i < len; i++) {
                var chunk = inputValue.substr(0, chunkLengths[i]);
                if (chunk) {
                    formattedValue += chunk + '-';
                    inputValue = inputValue.slice(chunkLengths[i]);
                }
            }
        }
        formattedValue += inputValue; // เพิ่มส่วนที่เหลือ
        this.value = formattedValue.substr(0, 17); // จำกัดความยาวเฉพาะไว้ที่ 17 ตัวอักษร

        var result = validateThaiID(this.value.replace(/-/g, '')); // ใช้ฟังก์ชัน validateThaiID เพื่อตรวจสอบเลขบัตรประชาชน
        if (result === false) {
            console.log('fasle');
            $('span.error').removeClass('true').addClass('false').text('เลขบัตรผิดตามหลักทะเบียนราษฎ์ กรุณาตรวจสอบใหม่').css({'color':'red','font-size':'14px'});
        } else {
            console.log('true');
            $('span.error').removeClass('false').addClass('true').text('เลขบัตรถูกต้องตามหลักทะเบียนราษฎ์').css({'color':'green','font-size':'14px'});
        }
    });

    function validateThaiID(id) {
        if (id.length !== 13) {
            return false; // หากความยาวของรหัสไม่ถูกต้อง
        }

        let sum = 0;
        for (let i = 0; i < 12; i++) {
            sum += parseFloat(id.charAt(i)) * (13 - i);
        }

        if ((11 - (sum % 11)) % 10 !== parseFloat(id.charAt(12))) {
            return false; // หากหมายเลขไม่ถูกต้อง
        }

        return true; // หากหมายเลขถูกต้อง
    }

    function showError(element, condition) {
        element.style.display = condition ? 'none' : 'block';
        return !condition; // true = มี error
    }

    //เช็ตว่าเงื่อนไขทุกช่อง ก่อนsubmit form ถ้าหากไม่ตรงก็จะแจ้งerror ใต้input
    document.getElementById('register-form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const password = passwordInput.value;
        const confirm = confirmInput.value;
        const thaiId = (document.getElementById('id_card')?.value || '').replace(/-/g, '');
        const usernameChk = document.getElementById('username').value.trim();
        const emailChk = document.getElementById('email').value.trim();


        const isValidThaiID = validateThaiID(thaiId);

        const hasError = [
            showError(document.getElementById('password-error'), isPasswordStrong(password)),
            showError(document.getElementById('pass-confirm-error'), checkPasswordMatch(password, confirm))
        ].some(Boolean);

        
        if (!isValidThaiID) {
            $('span.error').removeClass('true').addClass('false')
                .text('เลขบัตรผิดตามหลักทะเบียนราษฎ์ กรุณาตรวจสอบใหม่')
                .css('color', 'red');
        }
        // ตรวจสอบว่า username ถูกใช้แล้วหรือยัง
        let isUsernameTaken = false;
        let isEmailTaken = false;
        let isIdentTaken = false;
        const usernameErrorSpan = document.querySelector(".username-error");
        const EmailErrorSpan = document.querySelector(".email-error");
        const identErrorSpan = document.querySelector(".ident-error");

        if (usernameChk) {
            try {
                const res = await fetch("{{ route('register.chk.user') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ username: usernameChk })
                });

                const data = await res.json();

                if (data.exists) {
                    usernameErrorSpan.innerHTML = `<i class="bi bi-x-circle-fill"></i> ชื่อผู้ใช้งานนี้ถูกใช้แล้ว`;
                    usernameErrorSpan.style.fontSize = "14px";
                    usernameErrorSpan.style.color = "red";
                    isUsernameTaken = true;
                } else {
                    usernameErrorSpan.innerHTML = `<i class="bi bi-check-circle-fill"></i> สามารถใช้ชื่อนี้ได้`;
                    usernameErrorSpan.style.fontSize = "14px";
                    usernameErrorSpan.style.color = "green";
                }

            } catch (error) {
                console.error("Error checking username:", error);
                usernameErrorSpan.innerText = 'ไม่สามารถตรวจสอบชื่อผู้ใช้งานได้';
                usernameErrorSpan.style.color = 'red';
                hasError = true;
            }
        }

        if (emailChk) {
            try {
                const res = await fetch("{{ route('register.chk.email') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ email: emailChk })
                });

                const data = await res.json();

                if (data.exists) {
                    EmailErrorSpan.innerHTML = `<i class="bi bi-x-circle-fill"></i> Emailนี้ถูกใช้แล้ว`;
                    EmailErrorSpan.style.fontSize = "14px";
                    EmailErrorSpan.style.color = "red";
                    isEmailTaken = true;
                } else {
                    EmailErrorSpan.innerHTML = `<i class="bi bi-check-circle-fill"></i> สามารถใช้Emailนี้ได้`;
                    EmailErrorSpan.style.fontSize = "14px";
                    EmailErrorSpan.style.color = "green";
                }

            } catch (error) {
                console.error("Error checking Email:", error);
                EmailErrorSpan.innerText = 'ไม่สามารถตรวจสอบEmailได้';
                EmailErrorSpan.style.color = 'red';
                hasError = true;
            }
        }

        if (thaiId) {
            console.log(thaiId);
            try {
                const res = await fetch("{{ route('register.chk.idcard') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ idCard: thaiId })
                });

                const data = await res.json();

                if (data.exists) {
                    identErrorSpan.innerHTML = `<i class="bi bi-x-circle-fill"></i> เลขบัตรประชาชนนี้ถูกใช้แล้ว`;
                    identErrorSpan.style.fontSize = "14px";
                    identErrorSpan.style.color = "red";
                    isIdentTaken = true;
                } else {
                    identErrorSpan.innerHTML = `<i class="bi bi-check-circle-fill"></i> สามารถใช้เลขบัตรประชาชนนี้ได้`;
                    identErrorSpan.style.fontSize = "14px";
                    identErrorSpan.style.color = "green";
                }

            } catch (error) {
                console.error("Error checking idcard:", error);
                identErrorSpan.innerText = 'ไม่สามารถตรวจสอบเลขบัตรประชาชนได้';
                identErrorSpan.style.color = 'red';
                hasError = true;
            }
        }

        if (isValidThaiID && !hasError && !isUsernameTaken && !isEmailTaken && !isIdentTaken) {
            e.target.submit();
        }
    });
    
    
</script>


</html>