<?php

use App\Http\Controllers\Api\ZipperController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::get('/hello', function (){
    return "hello";
});


Route::post("/upload" , [ZipperController::class , 'upload']);

Route::get('/download/{file_path}', [ZipperController::class , 'download'])->name('file.download');

