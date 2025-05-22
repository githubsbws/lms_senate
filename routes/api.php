<?php

use App\Http\Controllers\Admin\DocumentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiocrController;
use App\Http\Controllers\Api\UserLoginController;
use App\Http\Controllers\Api\UserPermissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/ocr-test', [ApiocrController::class, 'testOcrInput']);
Route::post('/userpermission',[UserPermissionController::class,'assignRole']);
Route::post('/userlogin',[UserLoginController::class,'testApiLogin']);
Route::post('/document_import_api', [DocumentController::class, 'document_import']);
