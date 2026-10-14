<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CampagneController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiseaseController as AdminDiseaseController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PulseController;
use App\Http\Controllers\Admin\StationController as AdminStationController;
use App\Http\Controllers\Admin\VarietyController;
use App\Http\Controllers\CerealController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/stations', [StationController::class, 'index'])->name('stations.index');
Route::get('/cereales', [CerealController::class, 'index'])->name('cereales.index');
Route::get('/cereales/{cereal}/pdf', [CerealController::class, 'downloadPdf'])->name('cereales.pdf');
Route::get('/legumineuses', [CerealController::class, 'pulses'])->name('legumineuses.index');
Route::get('/legumineuses/{legume}/pdf', [CerealController::class, 'downloadPulsePdf'])->name('legumineuses.pdf');
Route::redirect('/varietes', '/cereales')->name('varietes.index');
Route::get('/maladies', [DiseaseController::class, 'index'])->name('maladies.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.attempt');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('cereales', [VarietyController::class, 'index'])->name('cereales.index');
        Route::get('cereales/create', [VarietyController::class, 'create'])->name('cereales.create');
        Route::post('cereales', [VarietyController::class, 'store'])->name('cereales.store');
        Route::get('cereales/{cereal}/edit', [VarietyController::class, 'edit'])->name('cereales.edit');
        Route::put('cereales/{cereal}', [VarietyController::class, 'update'])->name('cereales.update');
        Route::delete('cereales/{cereal}', [VarietyController::class, 'destroy'])->name('cereales.destroy');

        Route::resource('legumineuses', PulseController::class)->parameters(['legumineuses' => 'pulse'])->except(['show']);

        Route::resource('stations', AdminStationController::class)->except(['show']);

        Route::get('campagnes', [CampagneController::class, 'index'])->name('campagnes.index');
        Route::post('campagnes', [CampagneController::class, 'store'])->name('campagnes.store');
        Route::get('campagnes/{year}/edit', [CampagneController::class, 'edit'])->name('campagnes.edit');
        Route::put('campagnes/{year}', [CampagneController::class, 'update'])->name('campagnes.update');
        Route::patch('campagnes/{year}/toggle-active', [CampagneController::class, 'toggleActive'])->name('campagnes.toggle');
        Route::delete('campagnes/{year}', [CampagneController::class, 'destroy'])->name('campagnes.destroy');

        Route::resource('maladies', AdminDiseaseController::class)->parameters(['maladies' => 'disease'])->except(['show']);

        Route::resource('messages', MessageController::class)->only(['index', 'show', 'destroy']);
        Route::patch('messages/{message}/toggle-read', [MessageController::class, 'toggleRead'])->name('messages.toggle');
    });
});
