<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\EntryChecklistController;
use App\Http\Controllers\KillZoneController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PairController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\PropFirmController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\TradingPlanController;
use App\Http\Controllers\WeeklyForecastController;
use App\Models\Account;
use App\Models\EntryChecklist;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {

    Route::get('pairs/all', [PairController::class, 'getPairs'])->name('pairs.all');
    Route::resource('pairs', PairController::class);

    Route::get('/trades/all', [TradeController::class, 'getTrades'])->name('trades.all');
    Route::resource('/trades', TradeController::class);

    Route::get('/phases/all', [PhaseController::class, 'getPhases'])->name('phases.all');
    Route::resource('/phases', PhaseController::class);

    Route::get('/kill-zones/all', [KillZoneController::class, 'getKillzones'])->name('killzones.all');
    Route::resource('kill-zones', KillZoneController::class);

    Route::get('/weekly-forecasts/seed-year-weeks', [WeeklyForecastController::class, 'seedYearWeeks'])->name('weeks.seed');
    Route::get('/weekly-forecasts/all', [WeeklyForecastController::class, 'getForecasts'])->name('weekly_forecasts.all');
    Route::resource('/weekly-forecasts', WeeklyForecastController::class);

    Route::get('/trading-plans/all', [TradingPlanController::class, 'getTradingPlans'])->name('trading_plans.all');
    Route::resource('/trading-plans', TradingPlanController::class);

    Route::get('/prop-firms/all', [PropFirmController::class, 'getPropFirms'])->name('prop_firms.all');
    Route::resource('/prop-firms', PropFirmController::class);

    Route::get('/lessons/all', [LessonController::class, 'getLessons'])->name('lessons.all');
    Route::resource('/lessons', LessonController::class);

    Route::get('/accounts/all', [AccountController::class, 'getAccounts'])->name('accounts.all');
    Route::resource('/accounts', AccountController::class);

    Route::get('/entry-checklists/all', [EntryChecklistController::class, 'getEntryChecklists'])->name('entry_checklists.all');
    Route::resource('/entry-checklists', EntryChecklistController::class);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
