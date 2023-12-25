<?php

use App\Http\Controllers\FabricController;
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

Route::middleware(['auth', 'verified'])->group(function () {

    Route::name('newCar')->group(function () {
        Route::post('/register/validate/ownerCar/one', [OwnerCarController::class, 'validateStageOne'])->name('validateOne');
        Route::post('/register/validate/ownerCar/two', [OwnerCarController::class, 'validateStageTwo'])->name('validateTwo');
        Route::post('/register/validate/ownerCar/three', [OwnerCarController::class, 'validateStageThree'])->name('validateThree');
        Route::post('/register/validate/ownerCar/four', [OwnerCarController::class, 'validateStageFour'])->name('validateFour');
        Route::post('/register/validate/ownerCar/store', [OwnerCarController::class, 'validateStageStore'])->name('validateStore');
    });


Route::post('/register/validate/owner', [OwnerController::class, 'validateOwner'])->name('validateOwner')->middleware('auth');
Route::post('/view/owner', [OwnerController::class, 'getOwnerData'])->name('getOwnerData')->middleware('auth');

Route::post('/register/validate/fabric', [FabricController::class, 'validateFabric'])->name('validateFabric')->middleware('auth');

});
