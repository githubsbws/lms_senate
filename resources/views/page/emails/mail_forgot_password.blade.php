<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>OTP สำหรับการResetรหัสผ่าน</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; margin: 0; padding: 0;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 40px 0;" align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 10px; padding: 20px;">
                    {{-- <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Green_check.svg/1024px-Green_check.svg.png"
                                alt="Success" width="80" height="80">
                        </td>
                    </tr> --}}
                    <tr>
                        <td align="center" style="color: #333333;">
                            <h2 style="margin: 0 0 10px;">รหัส OTP</h2>
                            <h1 style="margin: 0;"><strong style="color:blue">{{ $otp }}</strong></h1>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="color: #333333;">
                            <p style="margin: 0;">รหัสOTPมีระยะเวลาใช้งาน2นาที</h1>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="center" style="padding-top: 30px; color: #999999; font-size: 12px;">
                           ลิขสิทธิ์ © {{ date('Y') }} สำนักงานเลขาธิการวุฒิสภา | The Secretariat of the Senate.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

</html>