<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Web\WebController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('web.index');
})->name('web.index');*/

Route::get('/', [WebController::class, 'index'])->name('web.index');
Route::get('producto/{id}/detalles', [WebController::class, 'detail'])->name('web.detail');

Route::get('/shop', [WebController::class, 'shop'])->name('web.shop');
Route::get('/cart', [WebController::class, 'cart'])->name('web.cart');
Route::get('/checkout', [WebController::class, 'checkout'])->name('web.checkout');
Route::get('/contact', [WebController::class, 'contact'])->name('web.contact');
Route::get('/recuperar/{token}/{email}', [WebController::class, 'recuperar'])->name('web.recuperar');
Route::post('/reset', [WebController::class, 'reset'])->name('web.reset');

Route::get('/perfil', [WebController::class, 'perfil'])->name('web.perfil')->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'user.admin',
    'user.estatus'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
});

Route::get('/cerrar', function () {
    Auth::logout();
    return redirect()->route('web.index');
})->name('cerrar');


