<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;

use App\Http\Controllers\OCRController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Admin\ApprovedController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Frontend\AdvancedSearchController;
use App\Http\Controllers\Frontend\SearchController;

// use App\Http\Controllers\AwsOCRController;
// use App\Http\Controllers\HuaweiOCRController;
// use App\Http\Controllers\InetOCRController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// ADMIN  // 
Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/admin/document', [DocumentController::class, 'document'])->name('admin.document');
Route::get('/admin/document_import', [DocumentController::class, 'document_import'])->name('admin.document_import');

Route::get('/admin/document_period', [DocumentController::class, 'document_period'])->name('admin.document_period');
Route::post('/admin/document_period', [DocumentController::class, 'document_period'])->name('admin.document_period');

Route::get('/admin/document_year/{id}', [DocumentController::class, 'document_year'])->name('admin.document_year');
Route::post('/admin/document_year/{id}', [DocumentController::class, 'document_year'])->name('admin.document_year');

Route::get('/admin/document_cate/{id}', [DocumentController::class, 'document_cate'])->name('admin.document_cate');
Route::post('/admin/document_cate/{id}', [DocumentController::class, 'document_cate'])->name('admin.document_cate');

Route::get('/admin/document_meet/{id}', [DocumentController::class, 'document_meet'])->name('admin.document_meet');
Route::post('/admin/document_meet/{id}', [DocumentController::class, 'document_meet'])->name('admin.document_meet');

Route::get('/admin/document_upload/{id}', [DocumentController::class, 'document_upload'])->name('admin.document_upload');
Route::post('/admin/document_upload/{id}', [DocumentController::class, 'document_upload'])->name('admin.document_upload');
Route::post('/admin/document_save/{file_id}/{id}', [DocumentController::class, 'document_save'])->name('admin.document_save');

Route::get('/admin/document_request', [DocumentController::class, 'document_request'])->name('admin.document_request');
Route::post('/admin/document_approve', [DocumentController::class, 'document_approve'])->name('admin.document_approve');
Route::post('/admin/document_deny', [DocumentController::class, 'document_deny'])->name('admin.document_deny');

Route::get('/admin/document_type', [DocumentController::class, 'document_type'])->name('admin.document_type');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/setting', [SettingController::class, 'index'])->name('admin.setting');

Route::get('/admin/permission', [PermissionController::class, 'index'])->name('admin.permission');

Route::get('/admin/survey', [SurveyController::class, 'index'])->name('admin.survey');

Route::get('/admin/approved', [ApprovedController::class, 'index'])->name('admin.approved');

Route::get('/admin/request', [RequestController::class, 'index'])->name('admin.request');

// FRONTEND //
Route::get('/frontend/advancesearch',[AdvancedSearchController::class,'index'])->name('frontend.a_search');

Route::get('/frontend/search',[SearchController::class,'index'])->name('frontend.n_search');

// Route::get('/upload', function () {
//     return view('upload');
// });
// Route::post('/ocr-upload', [OCRController::class, 'upload'])->name('ocr.upload');
// Route::get('/ocr', [AwsOCRController::class, 'showForm'])->name('aws.ocr.form');
// Route::post('/ocr/process', [AwsOCRController::class, 'processImage'])->name('aws.ocr.process');
// Route::get('/ocr-huawei', [HuaweiOCRController::class, 'showForm'])->name('huawei.ocr');
// Route::post('/ocr-pdf', [HuaweiOCRController::class, 'ocr']);
// Route::get('/huaweiresult', [HuaweiOCRController::class, 'huaweiresult'])->name('huaweiresult');

// Route::get('/ocr-inet', [InetOCRController::class, 'showForm'])->name('inet.ocr');
// Route::post('/inetocr-pdf', [InetOCRController::class, 'ocr']);
// Route::get('/inetresult', [InetOCRController::class, 'inetresult'])->name('inetresult');