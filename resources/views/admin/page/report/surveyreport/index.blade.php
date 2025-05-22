@extends('admin/layouts/main')
@section('content')
<style>
    .table-assegment .title-table {
        margin: 16px 0 !important;
    }

    .table-assegment .table {
        margin: 0 !important;
    }

    .table-assegment {
        background-color: #fff !important;
        margin-top: 16px;
        padding: 0 16px 16px;


    }

    .table-assegment .title-sec {
        margin: 16px 0 !important;
    }
</style>


<body id="body">
    <div class="warpper">
        <div class="content">
            <main>
                <div class="section">

                    <div class="section-header mb-3">
                        <h5 class="mb-0"></h5>
                    </div>
                    <div class="section-body">

                        {{-- <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                รายงานแบบประเมินความพึงพอใจ
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="/council/Admin/report/assegment-report">รายงานการประชุม</a></li>
                                <li><a class="dropdown-item" href="/council/Admin/report/assegment-report/meet.php">บันทึกการประชุม</a></li>
                                <li><a class="dropdown-item" href="/council/Admin/report/assegment-report/voting.php">บันทึกการออกเสียงลงคะแนน</a></li>
                            </ul>
                        </div> --}}

                        <!-- Table -->
                    <div class="card">
                        <div class="card-body">
                            <label for="form-control">
                                <h3 class="title-table">แบบสำรวจความพึงพอใจรายงานการประชุม</h3>
                            </label>
                            <form action="https://senate.24elearning.com/survey/8/submit" method="POST">
                                <input type="hidden" name="_token" value="FrR8YSK62gRTKVnnRVJyrQlkoN7ldH5aI939khZu" autocomplete="off">
                                <div class="main">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">ระดับความพึงพอใจ</th>
                                                <th scope="col">ผลรวมระดับ</th>
                                                <th scope="col">หมายเหตุ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>ความพึงพอใจมากที่สุด</td>
                                                <td>20</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ความพึงพอใจมาก</td>
                                                <td>20</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ความพึงพอใจปานกลาง</td>
                                                <td>20</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ความพึงพอใจน้อย</td>
                                                <td>30</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ความพึงพอใจควรปรับปรุง</td>
                                                <td>5</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>รวม</ะ>
                                                <td>95</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h5 class="title-sec">ข้อเสนอแนะ</h5>
                                    <textarea name="answer[38]" rows="4" class="form-control mt-2"></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 20px">
                        <div class="card-body">
                            <label for="form-control">
                                <h3 class="title-table">แบบสำรวจความพึงพอใจบันทึกการประชุม</h3>
                            </label>
                            <form action="https://senate.24elearning.com/survey/8/submit" method="POST">
                                <input type="hidden" name="_token" value="FrR8YSK62gRTKVnnRVJyrQlkoN7ldH5aI939khZu" autocomplete="off">
                                <div class="main">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">ระดับความพึงพอใจ</th>
                                                <th scope="col">ผลรวมระดับ</th>
                                                <th scope="col">หมายเหตุ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>ความพึงพอใจมากที่สุด</td>
                                                <td>25</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ความพึงพอใจมาก</td>
                                                <td>27</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ความพึงพอใจปานกลาง</td>
                                                <td>20</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ความพึงพอใจน้อย</td>
                                                <td>12</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ความพึงพอใจควรปรับปรุง</td>
                                                <td>8</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>รวม</ะ>
                                                <td>89</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <h5 class="title-sec">ข้อเสนอแนะ</h5>

                                    <textarea name="answer[38]" rows="4" class="form-control mt-2"></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 20px">
                        <div class="card-body">
                            <label for="form-control">
                                <h3 class="title-table">แบบสำรวจความพึงพอใจบันทึกการออกเสียงลงคะแนน</h3>
                            </label>
                            <form action="https://senate.24elearning.com/survey/8/submit" method="POST">
                                <input type="hidden" name="_token" value="FrR8YSK62gRTKVnnRVJyrQlkoN7ldH5aI939khZu" autocomplete="off">
                                <div class="main">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">ระดับความพึงพอใจ</th>
                                                <th scope="col">ผลรวมระดับ</th>
                                                <th scope="col">หมายเหตุ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>ความพึงพอใจมากที่สุด</td>
                                                <td>15</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ความพึงพอใจมาก</td>
                                                <td>18</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ความพึงพอใจปานกลาง</td>
                                                <td>22</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ความพึงพอใจน้อย</td>
                                                <td>14</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ความพึงพอใจควรปรับปรุง</td>
                                                <td>7</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>รวม</th>
                                                <td>76</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <h5 class="title-sec">ข้อเสนอแนะ</h5>

                                    <textarea name="answer[38]" rows="4" class="form-control mt-2"></textarea>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>
</body>
@endsection
<script>
    $(document).ready(function() {
        $('#docsList').DataTable({
            scrollX: true,
            language: {
                url: '/council/Admin/includes/languageDataTable.json',
            }
        });
    });
</script>

</html>