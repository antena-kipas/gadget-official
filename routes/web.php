<?php

use App\Livewire\Cart;
use App\Livewire\Admin\Sale;
use App\Livewire\Admin\Order;
use App\Livewire\Admin\Retur;
use App\Livewire\Installment;
use App\Livewire\LandingPage;
use App\Livewire\Transaction;
use App\Livewire\Admin\Credit;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Admin\Product\Index;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Product\Create;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SaleReportController;
use App\Livewire\Admin\Recap;
use App\Livewire\Auth\Login;

Route::get('/', Login::class)->name('login');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    // Product Route
    Route::get('/produk', Index::class)->name('product.index');
    Route::get('/produk/tambah-produk', Create::class)->name('product.create');

    Route::get('/penjualan', Sale::class)->name('sale');
    Route::get('/pesanan', Order::class)->name('order');
    Route::get('/tagihan', Credit::class)->name('credit');
    Route::get('/retur', Retur::class)->name('retur');
    Route::get('/rekapitulasi', Recap::class)->name('recap');

    Route::get('penjualan/stream', [SaleReportController::class, 'streamSalesReport'])
        ->name('reports.sales.stream');
    Route::get('tagihan/stream', [CreditController::class, 'streamCreditReport'])
        ->name('credit.stream');
    Route::get('retur/stream', [ReturController::class, 'streamRetur'])
        ->name('retur.stream');
    Route::get('rekapitulasi/stream', [RecapController::class, 'streamRecap'])
        ->name('recap.stream');
});


// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Route::get('settings/profile', Profile::class)->name('settings.profile');
//     Route::get('settings/password', Password::class)->name('settings.password');
//     Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
// });

require __DIR__ . '/auth.php';
