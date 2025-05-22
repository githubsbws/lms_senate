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
    <title>แจ้งผลการร้องขอเอกสาร</title>
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
                        <td align="center" style="color: #333333;padding: 20px 0;">
                            <h2 style="margin: 0 0 10px;">แจ้งผลการร้องขอเอกสาร</h2>
                            <p style="margin: 0;">ของคุณ <strong style="color:blue">{{ $file->user->firstname }} {{ $file->user->lastname}}</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <p style="margin: 0; color: #666666;">ครั้งที่ขอ <strong style="color:blue">{{ $file->number }}</strong></p>
                            <p>วันที่ขอ <strong style="color:blue">{{ \Carbon\carbon::parse($file->the_date)->locale('th')->addYear(543)->translatedFormat('j F Y') }}</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px 0;">
                            <p style="margin: 0; color: #666666;">
                                ผลการอนุมัติ
                                @if ($file->status == 'success')
                                    <strong style="color:green">อนุมัติ</strong>
                                @elseif($file->status == 'deny')
                                    <strong style="color:red">ไม่อนุมัติ</strong><br>
                                    <span>เหตุผลที่ไม่อนุมัติ เนื่องจาก <strong>{{ $file->not_approve_detail }}</strong></span>
                                @endif
                            </p>
                        </td>
                    </tr>
                    <tr>
                        @if($file->status == 'success')
                        <td align="center">
                            <p style="margin: 0; color: #666666;">สามารถเข้าไปดาวน์โหลดได้ที่เว็บไซต์</p>
                            <a href="https://senate.24elearning.com"
                               style="display: inline-block; background-color: #007bff; color: #ffffff; padding: 12px 24px; border-radius: 5px; text-decoration: none; font-weight: bold;margin-top: 10px;">
                                ไปยังเว็บไซต์
                            </a>
                        </td>
                        @endif
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