<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineListController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'master'], function(){
        Route::get('/user', [UserController::class, 'index'])->name('master.user.index');
        Route::post('/user', [UserController::class, 'store'])->name('master.user.create');
        Route::post('/check-user', [UserController::class, 'checkUsername'])->name('master.user.check');

        Route::get('/poliklinik', [PoliklinikController::class, 'index'])->name('master.poliklinik.index');
        Route::post('/poliklinik', [PoliklinikController::class, 'store'])->name('master.poliklinik.create');
        Route::post('/check-poliklinik', [PoliklinikController::class, 'checkCode'])->name('master.poliklinik.check');

        Route::get('/patient', [PatientController::class, 'index'])->name('master.patient.index');
    });

    Route::get('/patient/{nik}', [PatientController::class, 'show'])->name('patient.show');
    Route::post('/patient', [PatientController::class, 'store'])->name('patient.store');
    Route::get('/queue/poliklinik/{id}/count', [QueueController::class, 'countQueue'])->name('queue.poliklinik.count');
    Route::get('/medicine-list/medical/{id}', [MedicineListController::class, 'getListByMedicalRecord'])->name('medicine.list.medical');
    Route::post('/medical-list/medical/{id}', [MedicineListController::class, 'approveMedicine'])->name('medicine.list.approve');
    Route::post('/medical-record/store', [MedicalRecordController::class, 'store'])->name('medical-record.store');
    Route::get('/medical-record/{id}', [PatientController::class, 'getMedicalRecord'])->name('medical-record.show');
    
    Route::get('/stock', [StockController::class, 'index'] )->name('stock.index');
    Route::post('/stock', [StockController::class, 'store'] )->name('stock.create');
    Route::post('/stock/{id}', [StockController::class, 'update'] )->name('stock.update');

    Route::get('/queue', [QueueController::class, 'index'])->name('queue.index');
});

