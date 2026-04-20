<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;

// 🔓 PUBLIC (tanpa login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔒 PROTECTED (harus login pakai token)
Route::middleware('auth:sanctum')->group(function () {

    // 🔹 Ambil data user login
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    });

    // 🔹 CRUD Task
    Route::apiResource('tasks', TaskController::class);

    // 🔹 Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});