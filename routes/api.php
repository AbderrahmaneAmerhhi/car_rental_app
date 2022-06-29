<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\MfCompanyController;
use App\Http\Controllers\UserController;
use App\Models\Marque;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// mf_cmp route
Route::apiResource('companies',MfCompanyController::class);
// cars route
Route::apiResource('cars',CarController::class);
// command controller
Route::apiResource('command',CommandController::class);
// home controller index
Route::get('/home',[homeController::class,'index']);

// auth routes->middleware('auth:sanctum')
Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::get('profile',[UserController::class,'profile'])->middleware('auth:sanctum');
Route::put('profile/{id}/edit',[UserController::class,'editProfile'])->middleware('auth:sanctum');
Route::post('logout',[UserController::class,'logout'])->middleware('auth:sanctum');
