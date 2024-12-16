@extends('layout/mainlayout')
@section('content')
<body>

    <div class="search_normal">
        <section class="banner-toggle">
            <div class="warp">
                <div class="card">
                    <p>ระบบสืบค้นข้อมูลรายงานการประชุม บันทึกการประชุม </p>
                    <p>และบันทึกการออกเสียงลงคะแนน ของสำนักงานเลขาธิการวุฒิสภา</p>
                    <div class="warp-toggle">
                        <a class="btn btn-light active" href="#">ค้นหารายงานการประชุม</a>
                        <a class="btn btn-light" href="#">ค้นหารายงานการประชุมขั้นสูง</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="body-content main-form">
            <div class="container">
                <div class="warp">
                    <div class="card">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="form1" class="form-label">ชื่อการประชุม</label>
                                    <input type="email" class="form-control" id="form1" aria-describedby="form1">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">ชื่อการประชุม</label>
                                <select class="form-select" aria-label="Default select example" id="form2">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">ชื่อการประชุม</label>
                                <select class="form-select" aria-label="Default select example" id="form2">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">ชื่อการประชุม</label>
                                <select class="form-select" aria-label="Default select example" id="form2">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">ชื่อการประชุม</label>
                                <select class="form-select" aria-label="Default select example" id="form2">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">ชื่อการประชุม</label>
                                <select class="form-select" aria-label="Default select example" id="form2">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">ชื่อการประชุม</label>
                                <select class="form-select" aria-label="Default select example" id="form2">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="form2" class="form-label">ชื่อการประชุม</label>
                                <div class="input-group date" id="datepicker">
                                    <input type="text" class="form-control" id="date" />
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-light d-block">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-primary" onclick="myFunction()">ค้นหา</button>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <section id="table-main1" class="table-main mt-5" style="display: none;">
            <div class="container">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">ปีที่ประชุม</th>
                            <th scope="col">สมัยประชุม</th>
                            <th scope="col">ครั้งที่ประชุม</th>
                            <th scope="col">วันที่ประชุม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><p class="my-3">2567</p></td>
                            <td><a href="normal-resault.php" class="dark" style="text-decoration: none;">
                                    <p class="my-2">
                                        วุฒิสภา ปีที่ ๑ (ปี พ.ศ. ๒๕๖๗) <br>
                                        (กรณีที่ตักอักษรมีมากกว่า 1 บรรทัด) </p>
                                </a></td>
                            <td><p class="my-3"> 37 </p></td>
                            <td><p class="my-3">9 เมษายน 2567</p></td>
                        </tr>
                        <tr>
                            <td><p class="my-3">2567</p></td>
                            <td>
                                <a href="normal-resault.php" class=" text-dark" style="text-decoration: none;">
                                    <p class="my-3"> วุฒิสภา ปีที่ ๑ (ปี พ.ศ. ๒๕๖๗) </p>
                                </a>
                            <td><p class="my-3"> 37 </p></td>
                            <td><p class="my-3">9 เมษายน 2567</p></td>
                        </tr>
                        <tr>
                            <td><p class="my-3">2567</p></td>
                            <td>
                                <a href="normal-resault.php" class=" text-dark" style="text-decoration: none;">
                                    <p class="my-3"> วุฒิสภา ปีที่ ๑ (ปี พ.ศ. ๒๕๖๗) </p>
                                </a>
                            <td><p class="my-3"> 37 </p></td>
                            <td><p class="my-3">9 เมษายน 2567</p></td>
                        </tr>
                        <tr>
                            <td><p class="my-3">2567</p></td>
                            <td>
                                <a href="normal-resault.php" class=" text-dark" style="text-decoration: none;">
                                    <p class="my-3"> วุฒิสภา ปีที่ ๑ (ปี พ.ศ. ๒๕๖๗) </p>
                                </a>
                            <td><p class="my-3"> 37 </p></td>
                            <td><p class="my-3">9 เมษายน 2567</p></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </section>

</body>
@endsection