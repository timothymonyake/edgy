<?php

use App\Http\Controllers\KillZoneController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PairController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('pairs/all', [PairController::class, 'getPairs'])->name('pairs.all');
Route::resource('pairs', PairController::class);


Route::get('/kill-zones/all', [KillZoneController::class, 'getKillzones'])->name('killzones.all');
Route::resource('kill-zones', KillZoneController::class);




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
