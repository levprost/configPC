<?php

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("brands", BrandController::class);
Route::apiResource("categories", CategoryController::class);
Route::apiResource("comments", CommentController::class);
