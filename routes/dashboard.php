<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ParametrosController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'user.admin',
    'user.estatus',
    'user.permisos'
])->prefix('/dashboard')->group(function (){

    Route::get('parametros/', [ParametrosController::class, 'index'])->name('parametros.index');

});


Route::get('/admin', function () {
    //Alert::alert('Title', 'Message', 'Type');
    return view('home');
})->middleware(['user.permisos'])->name("prueba");

