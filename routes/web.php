<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KantinController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:superAdmin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('kantin', KantinController::class);
    Route::resource('dashboard-all', DashboardController::class);
});

Route::middleware(['auth', 'verified', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('menu', MenuController::class);
    Route::resource('pesanan', PesananController::class);
    Route::put('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
});
Route::middleware(['auth', 'role:pembeli'])->group(function () {
    Route::get('menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('menu/{menu}', [MenuController::class, 'show'])->name('menu.show');
    Route::get('menu/by-kantin/{kantin_id}', [MenuController::class, 'getByKantin'])->name('menu.byKantin');
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/{menu_id}', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    Route::post('/checkout', [KeranjangController::class, 'checkout'])->name('checkout');
    Route::resource('pesanan', PesananController::class)->only(['index', 'show']);
});


require __DIR__ . '/auth.php';
