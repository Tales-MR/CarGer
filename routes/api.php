<?php

use App\Http\Controllers\OwnerCarController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::post('/register/validate/ownerCar', [OwnerCarController::class, 'validateOwnerCar'])->name('validateOwnerCar')->middleware('auth');
Route::post('/register/validate/owner', [OwnerController::class, 'validateOwner'])->name('validateOwner')->middleware('auth');
Route::post('/view/owner', [OwnerController::class, 'getOwnerData'])->name('getOwnerData')->middleware('auth');
