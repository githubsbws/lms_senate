<?php

use App\Http\Controllers\AboutSenateController;
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
use App\Http\Controllers\Admin\SurveyReportController;
use App\Http\Controllers\Admin\SynonymController;
use App\Http\Controllers\Frontend\AdvancedSearchController;
use App\Http\Controllers\Frontend\RelateFileController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\FormController;
use App\Http\Controllers\Frontend\SurveyFormController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Api\UserPermissionController;
use App\Http\Controllers\Api\ApiocrController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\SenateNewsController;
use App\Mail\RegisterSuccess;
use Illuminate\Support\Facades\Mail;

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
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/admin/document', [DocumentController::class, 'document'])->name('admin.document');
Route::get('/admin/text-data', [DocumentController::class, 'getTextData'])->name('admin.text_data');
Route::get('/admin/text/delete/{id}', [DocumentController::class, 'deleteText'])->name('admin.text_del');
Route::get('/admin/document_import', [DocumentController::class, 'document_import'])->name('admin.document_import');
Route::post('/admin/document_import', [DocumentController::class, 'document_import'])->name('admin.document_import');

Route::get('/admin/document_file', [DocumentController::class, 'document_file'])->name('admin.document_file');
Route::get('/admin/file-data', [DocumentController::class, 'getFileData'])->name('admin.file_data');
Route::get('/admin/file/delete/{id}', [DocumentController::class, 'deleteFile'])->name('admin.file_del');
Route::get('/admin/document/{file_id}/edit', [DocumentController::class, 'document_file_edit'])->name('admin.document_file_edit');
Route::post('/admin/document/{file_id}/edit', [DocumentController::class, 'document_file_edit'])->name('admin.document_file_edit');

Route::get('/admin/document_period', [DocumentController::class, 'document_period'])->name('admin.document_period');
Route::post('/admin/document_period', [DocumentController::class, 'document_period'])->name('admin.document_period');
Route::get('/admin/period/delete/{id}', [DocumentController::class, 'deletePeriod'])->name('admin.period_del');
Route::get('/admin/meet/delete/{id}', [DocumentController::class, 'deleteMeet'])->name('admin.meet_del');
Route::get('/admin/cate/delete/{id}', [DocumentController::class, 'deleteCate'])->name('admin.cate_del');
Route::get('/admin/con/delete/{id}', [DocumentController::class, 'deleteCon'])->name('admin.con_del');
Route::get('/admin/rule/delete/{id}', [DocumentController::class, 'deleteRule'])->name('admin.rule_del');
Route::get('/admin/doc/delete/{id}', [DocumentController::class, 'deleteDoc'])->name('admin.doc_del');

Route::get('/admin/document_upload/{id}', [DocumentController::class, 'document_upload'])->name('admin.document_upload');
Route::post('/admin/document_upload/{id}', [DocumentController::class, 'document_upload'])->name('admin.document_upload');
Route::post('/admin/document_save/{file_id}/{id}', [DocumentController::class, 'document_save'])->name('admin.document_save');

Route::post('/admin/document_uploadLargeDocument/{id}', [DocumentController::class, 'document_uploadLargeDocument'])->name('admin.document_uploadLargeDocument');

Route::get('/admin/document/{file_id}/page/{page_number}/edit', [DocumentController::class, 'document_edit'])->name('admin.document_edit');
Route::post('/admin/document/{file_id}/page/{page_number}/edit', [DocumentController::class, 'document_edit'])->name('admin.document_update');
// Route::get('/admin/document_edit/{id}', [DocumentController::class, 'document_edit'])->name('admin.document_edit');
// Route::post('/admin/document_edit/{id}', [DocumentController::class, 'document_edit'])->name('admin.document_edit');

Route::get('/admin/document_request', [DocumentController::class, 'document_request'])->name('admin.document_request');
Route::post('/admin/document_approve/{id}', [DocumentController::class, 'document_approve'])->name('admin.document_approve');
Route::post('/admin/document_deny/{id}', [DocumentController::class, 'document_deny'])->name('admin.document_deny');

Route::get('/admin/document_type', [DocumentController::class, 'document_type'])->name('admin.document_type');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/setting', [SettingController::class, 'index'])->name('admin.setting');
Route::post('/admin/setting_create', [SettingController::class, 'createMenu'])->name('admin.menu.create');
Route::get('/admin/submenu_del/{id}', [SettingController::class, 'submenu_del'])->name('admin.submenu_del');

Route::get('/admin/permission', [PermissionController::class, 'index'])->name('admin.permission');
Route::get('/admin/permission_edit/{id}', [PermissionController::class, 'edit'])->name('admin.permission_edit');
Route::post('/admin/permission_edit/{id}', [PermissionController::class, 'update'])->name('admin.permission_update');
Route::get('/admin/permission_delete/{id}', [PermissionController::class, 'delete'])->name('admin.permission_delete');

Route::get('/admin/permission_type', [PermissionController::class, 'Permissions'])->name('admin.permission_type');
Route::post('/admin/permission_type_create', [PermissionController::class, 'Permissions_create'])->name('admin.permission_type_create');
Route::get('/admin/permission_type_edit/{id}', [PermissionController::class, 'Permissions_edit'])->name('admin.permission_type_edit');
Route::post('/admin/permission_type_update/{id}', [PermissionController::class, 'updatePermissions'])->name('admin.permission_type_update');

Route::get('/admin/survey', [SurveyController::class, 'index'])->name('admin.survey');
Route::get('/admin/survey_create', [SurveyController::class, 'survey_create'])->name('admin.survey_create');
Route::post('admin/save-survey', [SurveyController::class, 'saveSurvey']);
Route::get('/admin/survey_edit/{id}', [SurveyController::class, 'survey_edit'])->name('admin.survey_edit');
Route::post('/admin/survey_edit/{id}', [SurveyController::class, 'survey_edit'])->name('admin.survey_edit_save');
Route::get('/admin/survey_del/{id}', [SurveyController::class, 'survey_del'])->name('admin.survey_del');
Route::post('/admin/survey_status', [SurveyController::class, 'updateStatus']);
Route::get('/admin/survey_report', [SurveyReportController::class, 'index'])->name('admin.survey_report');

Route::get('/admin/approved', [ApprovedController::class, 'index'])->name('admin.approved');
Route::get('/admin/count_doc_request',[AdminController::class,'getCountDocRequest']);

Route::get('/admin/request', [RequestController::class, 'index'])->name('admin.request');

Route::get('/admin/analytics', [AnalyticsController::class, 'index']);

Route::get('/admin/synonym', [SynonymController::class, 'index'])->name('admin.synonym');
Route::post('/admin/synonym/update', [SynonymController::class, 'update'])->name('admin.synonym.update');


// FRONTEND //
Route::get('/', [AdvancedSearchController::class,'index'])->name('index');
Route::get('/board', [AboutSenateController::class,'orgChartSenate'])->name('org.senate');
Route::get('/news', [SenateNewsController::class,'news'])->name('news');
Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login_route', [LoginController::class, 'index'])->name('account.login');
Route::post('/users/logout', [IndexController::class, 'logout'])->name('users.logout');
Route::get('/register',[RegisterController::class,'index'])->name('register');
Route::post('/register/store',[RegisterController::class,'store'])->name('register.store');
Route::post('/register/chk_username',[RegisterController::class,'checkUsername'])->name('register.chk.user');
Route::post('/register/chk_email',[RegisterController::class,'checkEmail'])->name('register.chk.email');
Route::post('/register/chk_ident',[RegisterController::class,'checkIdent'])->name('register.chk.idcard');

Route::get('/forgotpasswrod', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot.password');
Route::post('/forgotpasswrod/otp_gen', [ForgotPasswordController::class, 'otpSendToMail'])->name('forgot.password.otp');
Route::post('/forgotpasswrod/chk_email', [ForgotPasswordController::class, 'chkEmailVerify'])->name('forgot.chk.email');
Route::post('/forgotpasswrod/chk_otp', [ForgotPasswordController::class, 'chkOtp'])->name('forgot.chk.otp');
Route::post('/forgotpasswrod/otp_verify', [ForgotPasswordController::class, 'otpVerify'])->name('forgot.otp.verify');
Route::post('/forgotpasswrod/renew_password', [ForgotPasswordController::class, 'renewPassword'])->name('forgot.renew.password');


Route::get('/frontend/advancedsearch',[SearchController::class,'index'])->name('frontend.n_search');
Route::get('/frontend/search',[AdvancedSearchController::class,'index'])->name('frontend.a_search');
Route::get('/frontend/search_result',[AdvancedSearchController::class,'search'])->name('frontend.search');
Route::get('/frontend/search_by_file',[AdvancedSearchController::class,'search'])->name('frontend.f_search');

Route::get('/frontend/relate_file/{id}',[RelateFileController::class,'index'])->name('frontend.relatefile');

Route::post('/frontend/querySearch',[SearchController::class,'querySearch'])->name('frontend.q_search');

Route::get('/frontend/resultSearchBy/',[SearchController::class,'index'])->name('frontend.t_search');

Route::middleware('auth')->get('/form_meet', [FormController::class, 'form_meet'])->name('form.meet');
Route::middleware('auth')->post('/form_submit', [FormController::class, 'form_submit'])->name('meeting.submit');
Route::middleware(['auth','web'])->get('/form_status', [FormController::class, 'form_status'])->name('form.status');
Route::middleware(['auth','web'])->get('/survey_form/{type}', [SurveyFormController::class, 'survey_form'])->name('survey.form');
Route::middleware(['auth','web'])->post('/survey/{id}/submit', [SurveyFormController::class, 'submitSurvey'])->name('survey.submit');

Route::get('/api/menu-file/{doc}/{year}', [IndexController::class, 'apiMenuFile'])->name('menu-file');

Route::get('/analytics', [AnalyticsController::class, 'index']);

Route::post('ocr/upload', [ApiocrController::class, 'uploadAndProcessOCR']);
// Route::get('/frontend/viewfile/{id}',[AdvancedSearchController::class,'search'])->name('frontend.search');
// update fillter meili //

//meilisearch//
// Route::get('/frontend/update-meilisearch', [AdvancedSearchController::class, 'updateMeilisearchAttributes'])->name('frontend.update.meili');
// Route::get('/frontend/view-meilisearch', [AdvancedSearchController::class, 'viewSettingMeilisearch'])->name('frontend.view.meili');
////////////////////////


// Route::get('/test-env', function () {
//     dd(env('MAIL_FROM_ADDRESS'));
// });

// Api Doc
Route::get('/api-doc', function () {
    return view('api-doc');
});

// Route::get('/test-mail', function () {
//     $user = "admin"; // หรือ mock user

//     Mail::to('chockker555@hotmail.com')->send(new RegisterSuccess($user));

//     return 'ส่งเมลแล้ว!';
// });
