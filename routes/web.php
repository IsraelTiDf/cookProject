<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PedidoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Produto;
use App\Models\Pedido;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'produtos' => Produto::all(),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard',['pedidos' => Pedido::all()]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
    Route::post('/creat-pedido', [PedidoController::class, 'store'])->name('creat-pedido');

    Route::get('/list-pedidos', [PedidoController::class, 'listarPedidos'])->name('list-pedidos');
    
    Route::get('/list-pedido', [PedidoController::class, 'index'])->name('list-pedido');

    Route::get('/fetch-pedidos', [PedidoController::class, 'fetchPedidos'])->name('fetch-pedidos');
    
    require __DIR__.'/auth.php';
