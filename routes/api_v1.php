<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\UserProjectsController;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('projects', ProjectController::class)->except('update');
    Route::put('projects/{project_id}', [ProjectController::class, 'replace']);
    Route::patch('projects/{project}', [ProjectController::class, 'update']);
    Route::apiResource('users', UserController::class);

    Route::apiResource('users.projects', UserProjectsController::class)
        ->parameters([
            'projects' => 'project_id',
        ])->except('update');

    Route::put('users/{user}/projects/{project_id}', [UserProjectsController::class, 'replace']);
    Route::patch('users/{user}/projects/{project}', [UserProjectsController::class, 'update']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// Route::middleware('auth:sanctum')->apiResource('projects', ProjectController::class)->except('replace');
// Route::middleware('auth:sanctum')->apiResource('users', UserController::class);
//
// Route::middleware('auth:sanctum')->apiResource('users.projects', UserProjectsController::class)
//    ->parameters([
//        'projects' => 'project_id'
//    ]);

// Route::middleware('auth:sanctum')->apiResource('users.projects', UserProjectsController::class);

// Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout'])->name('logout');
//
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
// });

Route::post('/login', [AuthController::class, 'login'])->name('login');
