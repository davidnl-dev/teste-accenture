<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PedidoPagoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('clientes', ClienteController::class);
Route::patch('clientes/{cliente}/toggle-status', [ClienteController::class, 'toggleStatus'])->name('clientes.toggle-status');
Route::resource('produtos', ProdutoController::class);
Route::patch('produtos/{produto}/toggle-status', [ProdutoController::class, 'toggleStatus'])->name('produtos.toggle-status');
Route::resource('pedidos', PedidoController::class);
Route::resource('pedidos-pagos', PedidoPagoController::class)->only(['index', 'show']);
Route::resource('logs', LogController::class)->only(['index', 'show']);
