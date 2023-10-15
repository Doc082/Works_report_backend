<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::resource('report', ReportController::class);
Route::resource('client', ClientController::class)->middleware(['auth:api']);
Route::post('search_cli', [ClientController::class,'search'])->middleware(['auth:api']);
Route::post('show_date', [ReportController::class,'showDate'])->middleware(['auth:api']);
Route::post('show_report', [ReportController::class,'showClientRep'])->middleware(['auth:api']);
Route::post('send_mail', [ReportController::class,'sendMail'])->middleware(['auth:api']);

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
    Route::post('register', [AuthController::class, 'register']);

});
