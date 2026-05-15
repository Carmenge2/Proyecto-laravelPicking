<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TrabajadorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaProductoController;

/*
|--------------------------------------------------------------------------
| Página principal
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('auth.login'));

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Dashboard general
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'role'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| CATÁLOGO DE PRODUCTOS (requiere autenticación)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/catalogo', [CategoriaProductoController::class, 'index'])
        ->name('catalogo.index');

    Route::get('/catalogo/producto/{producto}', [ProductoController::class, 'showPublico'])
        ->name('catalogo.producto');

    Route::get('/catalogo/{categoria}', [CategoriaProductoController::class, 'productos'])
        ->name('catalogo.productos');
});


/*
|--------------------------------------------------------------------------
| Panel comercial (dashboard)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:comercial'])
    ->prefix('comercial')
    ->name('comercial.')
    ->group(function () {

        Route::get('/dashboard', fn () => view('comercial.dashboard'))
            ->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Clientes y pedidos (ADMIN + COMERCIAL)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:comercial|admin'])->group(function () {
    Route::resource('clientes', ClienteController::class);
    Route::resource('pedidos', PedidoController::class);
});

/*
|--------------------------------------------------------------------------
| Panel admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('trabajadores', TrabajadorController::class)
            ->parameters(['trabajadores' => 'trabajador']);

    });

/*
|--------------------------------------------------------------------------
| Gestión de productos y categorías (SOLO ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->resource('productos', ProductoController::class)
    ->except(['show']);

Route::middleware(['auth', 'role:admin'])
    ->resource('categorias', CategoriaProductoController::class)
    ->except(['show']);