<!DOCTYPE html>
<html lang="en">

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/council/Admin/component/header.php'  ?>

<body id="body">
    <div class="warpper">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/council/Admin/component/sidebar.php'  ?>
        <div class="content">
            <div class="nav-sidebar shadow-sm">
                <div class="d-flex align-items-center">
                    <button class="nav-btn d-md-none me-3" onclick="slice()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.75 12.25h10.5m-10.5-4h10.5m-10.5-4h10.5" />
                        </svg>
                    </button>
                    <h4 class="mb-0">แบบสำรวจความพึงพอใจ</h4>
                </div>
                <div class="ms-auto d-flex align-items-center">
                    <button class="notify-btn me-3">
                        <i class="fa-regular fa-bell" style="color: #FE5C73;"></i>
                    </button>
                    <div class="dropdown position-relative">
                        <button class="dropdown-btn d-flex align-items-center dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Danielle Campbell
                        </button>
                        <ul class="dropdown-menu end-0">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <main>
                <div class="section">
                    <div class="section-header mb-3">
                        <h5 class="mb-0"></h5>
                    </div>
                    <div class="section-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">ชื่อหัวข้อแบบสำรวจ</label>
                                    <input type="text" class="form-control" id="name">
                                </div>
                                <div class="section mb-3">
                                    <div class="quetion-section mb-3">
                                        <div class="mb-3">
                                            <label for="question" class="form-label fw-semibold">คำถามที่ 1</label>
                                            <input type="text" class="form-control" id="question">
                                        </div>
                                        <div class="">
                                            <div class="d-flex align-items-center mb-2">
                                                <p class="fw-semibold mb-0">คำตอบ</p>
                                                <button class="btn btn-warning btn-sm ms-3">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <button class="btn btn-success btn-sm ms-1">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm ms-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="form-check" style="min-width: 120px;">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        มากที่สุด
                                                    </label>
                                                </div>
                                                <button class="btn btn-danger btn-sm ms-3">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="form-check" style="min-width: 120px;">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        มาก
                                                    </label>
                                                </div>
                                                <button class="btn btn-danger btn-sm ms-3">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="form-check" style="min-width: 120px;">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        ปานกลาง
                                                    </label>
                                                </div>
                                                <button class="btn btn-danger btn-sm ms-3">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="form-check" style="min-width: 120px;">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        น้อย
                                                    </label>
                                                </div>
                                                <button class="btn btn-danger btn-sm ms-3">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="divided mb-3" />
                                    <div class="quetion-section mb-3">
                                        <div class="mb-3">
                                            <label for="question" class="form-label fw-semibold">คำถามที่ 2</label>
                                            <input type="text" class="form-control" id="question">
                                        </div>
                                        <div class="">
                                            <div class="d-flex align-items-center mb-2">
                                                <p class="fw-semibold mb-0">คำตอบ</p>
                                                <button class="btn btn-warning btn-sm ms-3">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <button class="btn btn-success btn-sm ms-1">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm ms-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="">
                                                <textarea class="form-control" id="answer" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="divided mb-3" />
                                <button class="btn btn-primary">
                                    <i class="fa-solid fa-plus me-1"></i>
                                    เพิ่มคำถาม
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
    </div>
</body>

</html>