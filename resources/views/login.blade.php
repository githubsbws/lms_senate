<!DOCTYPE html>
<html lang="th">
    <title>Login Senate</title>
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
        }
        .input-error {
            border: 1px solid red;
        }
    </style>
@include('admin.layouts.partials.header')
<body class="d-flex flex-column min-vh-100" style=" background: rgb(61,106,215); background: radial-gradient(circle, rgba(61,106,215,1) 50%, rgba(17,51,184,1) 85%);">
    <div class="main flex-grow-1 d-flex align-items-center justify-content-center p-3">
        <div class="card w-100 py-3 px-2" style="max-width: 460px;">
            <div class="card-body">
                <center>
                    <img src="{{asset('includes/image/logo.png')}}" width="117" height="118" class="mx-auto mb-3">
                </center>
                <h2 class="text-center fw-semibold mb-3" style="color: #2552C1;">เข้าสู่ระบบ</h2>
                <p class="fw-normal text-center" style="color: #8A92A6;">ลงชื่อเข้าใช้เพื่อเชื่อมต่อ </p>
                @if (session('loginError'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: '{{ session('loginError') }}',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    </script>
                    @php
                        session()->forget('loginError'); // ล้างเองหลังแสดง
                    @endphp
                @endif
               @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: '{{ session('success') }}',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    </script>
                    @php
                        session()->forget('success'); // ล้างเองหลังแสดง
                    @endphp
                @endif
                <form action="{{ route('account.login') }}" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto">
                    @csrf

                <div class="mt-3">
                    <div class="form-group mb-3">
                        <label class="fw-normal" style="color: #999999;"> ชื่อผู้ใช้ </label>
                        <input type="text" name="username" class="form-control" value="{{ $remembered_username ?? old('username') }}" autocomplete="username" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-normal" style="color: #999999;"> รหัสผ่าน </label>
                        <input type="password" name="password" class="form-control" autocomplete="current-password" required>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="remember" {{ $remembered_username ? 'checked' : '' }} >
                        <label class="form-check-label fw-normal" for="flexCheckDefault" style="color: #999999;">
                            จำฉันไว้?
                        </label>
                    </div>

                    <div class="d-grid gap-2 mb-3 d-flex justify-content-center ">
                        <button class="btn btn-primary w-50" type="submit">
                            เข้าสู่ระบบ
                        </button>
                    </div>

                    <div class="login text-center mt-2 mb-2">
                        <span>ยังไม่มีบัญชีผู้ใช้งาน?</span>
                        <span><a href="{{route('register')}}" class="text-primary">ลงทะเบียน</a></span>
                    </div>
                    <div class="login text-center mt-2 mb-2">
                        <span>ลืมรหัสผ่านใช่ไหม?</span>
                        <span><a href="{{route('forgot.password')}}" class="text-primary">คลิกที่นี่</a></span>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>