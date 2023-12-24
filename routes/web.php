<?php

use App\Http\Controllers\FabricController;
use App\Http\Controllers\OwnerCarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OwnerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    //Owner area
    Route::get('/', [OwnerController::class, 'index'])->name('Owner');
    Route::get('/view/owner/{id_owner}', [OwnerController::class, 'renderOwnerInfo'])->name('viewOwner');
    Route::get('/view/fabrics', [FabricController::class, 'index'])->name('viewFabrics');
    Route::get('/view/fabric/{id_fabric}', [FabricController::class, 'renderFabricInfo'])->name('viewFabricInfo');

    Route::post('/register/owner', [OwnerController::class, 'store'])->name('newOwner');
    Route::post('/register/owner/ownerCar', [OwnerCarController::class, 'store'])->name('newOwnerCar');
    Route::post('/register/fabric', [FabricController::class, 'store'])->name('newFabric');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
