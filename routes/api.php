<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\FunctionsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("categories", [CategoryController::class, 'index']);
Route::post("categories", [CategoryController::class, 'store']);
Route::get("categories/{id}", [CategoryController::class, 'show']);
Route::post("categories/{id}", [CategoryController::class, 'update']);

Route::get("products", [ProductController::class, 'index']);
Route::post("products", [ProductController::class, 'store']);
Route::get("products/{id}", [ProductController::class, 'show']);
Route::post("products/{id}", [ProductController::class, 'update']);
Route::delete("products/{id}", [ProductController::class, 'destroy']);

Route::get("categories/{id}/products", [CategoryController::class, 'getProducts']);

Route::get('makePassword/{length}', [FunctionsController::class, 'makePassword']);
Route::get("makePin", [FunctionsController::class, 'makePin']);
