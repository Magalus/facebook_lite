<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;


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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'posts'], function () {
    Route::get("/", [PostController::class, "index"]);
    Route::get("/{post}", [PostController::class, "show"]);
    Route::post("/", [PostController::class, "store"])->middleware('auth:sanctum');
    Route::patch("/{post}", [PostController::class, "update"])->middleware('auth:sanctum');
    Route::delete("/{post}", [PostController::class, "destroy"])->middleware('auth:sanctum');
});