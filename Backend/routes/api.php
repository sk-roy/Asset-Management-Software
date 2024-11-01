<?php

use App\Http\Controllers\API\V1\AssetController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\DocumentController;
use App\Http\Controllers\API\V1\EventController;
use App\Http\Controllers\API\V1\NoteController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'getUserInfo']);
    Route::post('/user/update', [UserController::class, 'editUserInfo']);
    Route::post('/user/change-password', [UserController::class, 'changePassword']);

    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/assets', [AssetController::class, 'index']);
    Route::get('/assets/{id}', [AssetController::class, 'get']);
    Route::get('/assets/{id}/notes', [AssetController::class, 'getNotes']);
    Route::post('/assets', [AssetController::class, 'store']);
    Route::patch('/assets/{id}', [AssetController::class, 'update']);
    Route::delete('/assets/{id}', [AssetController::class, 'delete']);
    Route::delete('/assets', [AssetController::class, 'deleteAssets']);
    Route::get('/assets/{id}/events', [EventController::class, 'loadSortedEventsOfAsset']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    Route::get('/categories/{id}/fields', [CategoryController::class, 'getFields']);

    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'get']);
    Route::post('/events', [EventController::class, 'store']);
    Route::patch('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'delete']);
    Route::delete('/events', [EventController::class, 'deleteList']);

    Route::get('/notes/{id}', [NoteController::class, 'get']);
    Route::get('/notes', [NoteController::class, 'getAll']);
    Route::post('/notes', [NoteController::class, 'store']);
    Route::patch('/notes/{id}', [NoteController::class, 'update']);
    Route::delete('/notes/{id}', [NoteController::class, 'delete']);    

    Route::get('/documents', [DocumentController::class, 'show']);
    Route::post('/documents', [DocumentController::class, 'store']);
    Route::get('/documents/{id}', [DocumentController::class, 'download']);
    Route::delete('/documents/{id}', [DocumentController::class, 'delete']);
    Route::post('/documents/{id}/restore', [DocumentController::class, 'restore']);
});