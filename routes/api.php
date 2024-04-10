<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

//grupo de rutas autenticadas
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('purchases', PurchaseController::class);
    Route::resource('cards', CardController::class);
    Route::put('read_qr/{folio}', [PurchaseController::class, 'readQr']);
});
