<?php

use App\Http\Controllers\Api\Admin\RegisterController;
use App\Http\Controllers\Api\BukuController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(RegisterController::class)->group(function(){
    Route::post('admin/register','register');
    Route::post('admin/login','login');
    Route::get('admin/','index');
});


Route::controller(BukuController::class)->group(function(){
    Route::get('buku','index');
    Route::get('buku/{id}','show');
    Route::post('buku/','store');
    Route::post('buku/{id}','update');
    Route::delete('buku/{id}','destroy');
});