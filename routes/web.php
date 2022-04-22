<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
	DashboardController, 
	BarangController,
	GudangController,
	SupplierController,
	BarangMasukController,
	BarangKeluarController,
	LaporanController,
	UserController
};

Route::redirect('/', '/login');

Route::group([
	'middleware' => 'auth',
	'prefix' => 'admin',
	'as' => 'admin.'
], function(){
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	Route::get('/logs', [DashboardController::class, 'activity_logs'])->name('logs');
	Route::post('/logs/delete', [DashboardController::class, 'delete_logs'])->name('logs.delete');
	
	// Settings menu
	Route::view('/settings', 'admin.settings')->name('settings');
	Route::post('/settings', [DashboardController::class, 'settings_store'])->name('settings');
	
	// Profile menu
	Route::view('/profile', 'admin.profile')->name('profile');
	Route::post('/profile', [DashboardController::class, 'profile_update'])->name('profile');
	Route::post('/profile/upload', [DashboardController::class, 'upload_avatar'])
		->name('profile.upload');

	// Member menu
	Route::get('/petugas', [UserController::class, 'index'])->name('member');
	Route::get('/petugas/create', [UserController::class, 'create'])->name('member.create');
	Route::post('/petugas/create', [UserController::class, 'store'])->name('member.create');
	Route::get('/petugas/{id}/edit', [UserController::class, 'edit'])->name('member.edit');
	Route::post('/petugas/{id}/update', [UserController::class, 'update'])->name('member.update');
	Route::post('/petugas/{id}/delete', [UserController::class, 'destroy'])->name('member.delete');

	// Barang
	Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
	Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
	Route::post('/barang/update', [BarangController::class, 'update'])->name('barang.update');
	Route::get('/barang/info', [BarangController::class, 'info'])->name('barang.info');
	Route::post('/barang/{id}/destroy', [BarangController::class, 'destroy'])->name('barang.destroy');

	// Gudang
	Route::get('/gudang', [GudangController::class, 'index'])->name('gudang.index');
	Route::post('/gudang/store', [GudangController::class, 'store'])->name('gudang.store');
	Route::post('/gudang/update', [GudangController::class, 'update'])->name('gudang.update');
	Route::get('/gudang/info', [GudangController::class, 'info'])->name('gudang.info');
	Route::post('/gudang/{id}/destroy', [GudangController::class, 'destroy'])->name('gudang.destroy');

	// Supplier
	Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
	Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
	Route::post('/supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
	Route::get('/supplier/info', [SupplierController::class, 'info'])->name('supplier.info');
	Route::post('/supplier/{id}/destroy', [SupplierController::class, 'destroy'])->name('supplier.destroy');

	// Barang Masuk
	Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
	Route::post('/barang-masuk/store', [BarangMasukController::class, 'store'])->name('barang-masuk.store');
	Route::post('/barang-masuk/update', [BarangMasukController::class, 'update'])->name('barang-masuk.update');
	Route::get('/barang-masuk/info', [BarangMasukController::class, 'info'])->name('barang-masuk.info');
	Route::post('/barang-masuk/{id}/destroy', [BarangMasukController::class, 'destroy'])->name('barang-masuk.destroy');

	// Barang Keluar
	Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
	Route::post('/barang-keluar/store', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');
	Route::post('/barang-keluar/update', [BarangKeluarController::class, 'update'])->name('barang-keluar.update');
	Route::get('/barang-keluar/info', [BarangKeluarController::class, 'info'])->name('barang-keluar.info');
	Route::post('/barang-keluar/{id}/destroy', [BarangKeluarController::class, 'destroy'])->name('barang-keluar.destroy');

	// laporan
	Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

});


require __DIR__.'/auth.php';
