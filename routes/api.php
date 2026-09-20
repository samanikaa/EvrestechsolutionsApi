<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SalesOrderController;
use App\Http\Controllers\Api\SalesOrderLineController;
use App\Http\Controllers\Api\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function (){
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
        
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('salesorders', SalesOrderController::class);
        Route::apiResource('salesorderlines', SalesOrderLineController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('inventory', InventoryController::class);
        Route::apiResource('warehouses', WarehouseController::class);
    });
});






