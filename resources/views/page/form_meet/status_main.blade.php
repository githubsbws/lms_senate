@extends('layout/mainlayout')
@section('content')
<body>
    <div class="status-main">
        <section class="banner-toggle">
            <div class="warp">
                <div class="card">
                    <p>ระบบสืบค้นข้อมูลรายงานการประชุม บันทึกการประชุม </p>
                    <p>และบันทึกการออกเสียงลงคะแนน ของสำนักงานเลขาธิการวุฒิสภา</p>
                    <div class="warp-toggle">
                        <a class="btn btn-light" href="{{route ('frontend.n_search') }}">ค้นหารายงานการประชุมขั้นสูง</a>
                        <a class="btn btn-light" href="{{route ('frontend.a_search') }}">ค้นหารายงานการประชุม</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="body-content mt-5">
            <div class="container">

                <div class="card">
                    <h3 class="title">สถานะการขอรับบริการ</h3>

                    <div class="step">
                        <div class="row">
                            <div class="col-lg-2 text">
                                @if($approves)
                                <i class="fa-solid fa-check"></i>
                                @elseif(!$approves)
                                <i class="fa-solid fa-xmark"></i>
                                @endif
                                <p>ยื่นขอรับบริการ</p>
                            </div>

                            <div class="col-lg-3 bar-row">
                                <div class="bar"></div>
                            </div>

                            <div class="col-lg-2 text">
                                @if($approves)
                                <i class="fa-solid fa-check"></i>
                                @elseif(!$approves)
                                <i class="fa-solid fa-xmark"></i>
                                @endif
                                <p>อยู่ระหว่างดำเนินการ</p>
                            </div>

                            <div class="col-lg-3 bar-row">
                                <!-- ใช้ Class bar-red เพื่อนเปลี่ยนสีบาร์เป็นสีเเดง -->
                                <div class="bar"></div>
                            </div>

                            <div class="col-lg-2 text">
                                <!-- ใช้คอมเมนต์เพื่อเปลี่ยนไอค่อน -->
                                @if($canDownload && $approves && $approves->file_name)
                                <i class="fa-solid fa-check"></i>
                                @elseif($approves && $approves->status == 'waiting')
                                <i class="fa-solid fa-circle-dot"></i>
                                @elseif($approves && $approves->status == 'deny')
                                <i class="fa-solid fa-xmark"></i> 
                                @elseif(!$approves)
                                <i class="fa-solid fa-xmark"></i> 
                                @endif
                                <p>ดำเนินการเสร็จสิ้น</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="btn-group">
                    <div class="wrap">
                        <!-- ใช้ชื่อ class ปรับสีของปุ่ม -->
                        @if($canDownload && $approves && $approves->file_name)
                            <a type="button" class="btn btn-success text-white"  href="{{ asset('uploads/approved/' . $approves->file_name) }}" download>ดาวน์โหลดเอกสาร</a>
                            <a type="button" class="btn btn-secondary" href="#" disabled>ตอบแบบประเมิน</a>

                        @elseif($approves && $approves->status == 'waiting')
                            <a type="button" class="btn btn-secondary" disabled>ดาวน์โหลดเอกสาร</a>
                            <a type="button" class="btn btn-secondary" disabled>ตอบแบบประเมิน</a>
                        @elseif($approves && $approves->status == 'success')
                            <a type="button" class="btn btn-secondary" disabled>ดาวน์โหลดเอกสาร</a>
                            <a type="button" class="btn btn-success text-white" href="{{ route('survey.form',['type' => $type_req]) }}">ตอบแบบประเมิน</a>
                        @elseif($approves && $approves->status == 'deny')
                            <a type="button" class="btn btn-secondary" href="#" disabled>ดาวน์โหลดเอกสาร</a>
                            <a type="button" class="btn btn-secondary" href="#" disabled>ตอบแบบประเมิน</a>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <h3 class="title">ประวัติการขอรับเอกสาร</h3>
                    <table class="table">
                        <tbody>
                            @foreach($approve as $app)
                            <tr>
                                <td class="text-center">{{ $app->number }}</td>
                                <td class="text-center">{{ $app->period->name_type_period ?? '-'}}</td>
                                <td class="text-center">{{ $app->the_time }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($app->the_date)->locale('th')->addYear(543)->isoFormat('D MMMM YYYY') }}</td>
                                <td class="text-center">
                                    @if($app->status == 'success')
                                        <button class="btn btn-success badge" disabled>อนุมัติ</button>
                                    @elseif($app->status == 'deny')
                                        <!-- ปุ่มสำหรับสถานะ "ไม่อนุมัติ" -->
                                        <button class="btn btn-danger badge" disabled>
                                            ไม่อนุมัติ
                                        </button>
                                    @elseif($app->status == 'waiting')
                                        <button class="btn btn-warning badge" disabled>รอรายละเอียด</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </section>
    </div>
    {{-- {{ dd(session('message')) }} --}}
    @if(session('message'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'แจ้งเตือน',
            text: '{{ session("message") }}',
            confirmButtonText: 'ตกลง'
        });
    </script>
@endif
</body>
@endsection