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
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.75 12.25h10.5m-10.5-4h10.5m-10.5-4h10.5"/></svg>
                    </button>
                    <h4 class="mb-0">จัดการเมนู</h4>
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
                        <div class="section d-flex mb-3">
                            <p class="mb-0 fs-5">จัดการเมนู</p>
                            <button type="button" class="btn btn-primary ms-auto">
                                เพิ่ม Menu
                            </button>
                        </div>
                        <hr class="divided mn-3" />
                        <div class="row row-cols-3 gap-2">
                            <div class="col">
                                <div class="d-grid mb-2">
                                    <button type="button" class="btn btn-outline-primary text-start d-flex align-items-center px-3">
                                        วุฒิสภา
                                        <i class="fa-solid fa-angle-right ms-auto"></i>
                                    </button>
                                </div>
                                <div class="d-grid mb-2">
                                    <button type="button" class="btn btn-outline-primary text-start d-flex align-items-center px-3">
                                        คณะกรรมาธิการ
                                        <i class="fa-solid fa-angle-right ms-auto"></i>
                                    </button>
                                </div>
                                <div class="d-grid mb-2">
                                    <button type="button" class="btn btn-outline-primary text-start d-flex align-items-center px-3">
                                        สำนักงานเลขาธิการวุฒิสภา
                                        <i class="fa-solid fa-angle-right ms-auto"></i>
                                    </button>
                                </div>
                                <div class="d-grid mb-2">
                                    <button type="button" class="btn btn-outline-primary text-start d-flex align-items-center px-3">
                                        สมาชิกวุฒิสภาพบประชาชน
                                        <i class="fa-solid fa-angle-right ms-auto"></i>
                                    </button>
                                </div>
                                <div class="d-grid mb-2">
                                    <button type="button" class="btn btn-outline-primary text-start d-flex align-items-center px-3">
                                        คกก.กองทุนการศึกษา
                                        <i class="fa-solid fa-angle-right ms-auto"></i>
                                    </button>
                                </div>
                                <div class="d-grid mb-2">
                                    <button type="button" class="btn btn-outline-primary text-start d-flex align-items-center px-3">
                                        ร้องขอเอกสาร
                                        <i class="fa-solid fa-angle-right ms-auto"></i>
                                    </button>
                                </div>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>