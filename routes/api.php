<?php

use App\Http\Controllers\Api\v1\DocumentManagementController;
use App\Http\Controllers\API\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);

    Route::get('document-management', [DocumentManagementController::class, 'index']);
    Route::post('document-management', [DocumentManagementController::class, 'store']);
    Route::get('document-management/{id}', [DocumentManagementController::class, 'show']);
    Route::put('document-management', [DocumentManagementController::class, 'update']);
    Route::delete('document-management', [DocumentManagementController::class, 'destroy']);
    Route::put('update-profile/{id}', [UserController::class, 'update']);
    Route::middleware(['auth:sanctum'])->group(function () {
    });
});
