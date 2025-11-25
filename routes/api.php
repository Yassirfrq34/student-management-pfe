<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SubjectController; // 👈 THIS WAS MISSING!

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// --- Protected Routes (Require Token) ---
Route::middleware('auth:sanctum')->group(function () {

    // Auth Actions
    Route::post('/logout', [AuthController::class, 'logout']);

    // Get currently logged in user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Student Management (Admin Only)
    Route::apiResource('/students', StudentController::class);

    // Subject Management (Admin Only) -> NEW!
    Route::apiResource('/subjects', SubjectController::class);

    // Student Profile (Self Service)
    Route::get('/profile', [ProfileController::class, 'me']);
    Route::put('/profile', [ProfileController::class, 'update']);
});
