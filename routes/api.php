<?php

use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\InvoiceController;
use Illuminate\Support\Facades\Route;


// api version 1
Route::group(['prefix' => 'v1', 'namespace' => "App\Http\Controllers\Api\V1", 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('invoices', InvoiceController::class);

    Route::post('invoices/bulk', [InvoiceController::class, 'bulkStore'])->name('invoices.bulk.store');
});

require __DIR__.'/auth.php';