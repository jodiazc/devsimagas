<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PaymentLinkController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\ApiPaymentLinkController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UploadFilesController;
use App\Http\Controllers\Admin\FileController;

Route::get('',[HomeController::class,'index'])->name('admin.home');
Route::resource('payments', PaymentLinkController::class)->names([
    'index' => 'admin.payments.index',
    'create' => 'admin.payments.create',
    'store' => 'admin.payments.store',
    'show' => 'admin.payments.show',
    'edit' => 'admin.payments.edit',
    'update' => 'admin.payments.update',
    'destroy' => 'admin.payments.destroy',
]);

Route::resource('users',UserController::class)->only(['index','edit','update'])->names('admin.users');

Route::resource('roles',RoleController::class)->names('admin.roles');

Route::post('payments/import', [ImportController::class, 'import'])->name('admin.payments.import');

Route::prefix('admin')->group(function () {
    Route::get('/payments/export', [ExportController::class, 'exportCsv'])->name('admin.payments.export');
});

Route::get('/api',[ApiPaymentLinkController::class,'fetchExternalData'])->name('admin.payments.apiview');
Route::get('/api',[ApiPaymentLinkController::class,'makePayment'])->name('admin.payments.apiview');

Route::prefix('/upload-files')->group(function () {
    Route::get('/', [UploadFilesController::class, 'index'])->name('admin.upload_files.index');
    Route::get('/create', [UploadFilesController::class, 'create'])->name('admin.upload_files.create');
    Route::post('/', [UploadFilesController::class, 'store'])->name('admin.upload_files.store');
    Route::get('/{id}', [UploadFilesController::class, 'show'])->name('admin.upload_files.show');
    Route::get('/{id}/edit', [UploadFilesController::class, 'edit'])->name('admin.upload_files.edit');
    Route::put('/{id}', [UploadFilesController::class, 'update'])->name('admin.upload_files.update');
    Route::delete('/{id}', [UploadFilesController::class, 'destroy'])->name('admin.upload_files.destroy');
});

Route::get('/uploads/files/{filename}', [UploadFilesController::class, 'showFile'])->name('admin.upload_files.showFile');

//Route::get('/admin/files/{filename}', [FileController::class, 'show']);
