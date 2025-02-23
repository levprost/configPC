<?php

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\UserConfiguration;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\MediaController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ComponentController;
use App\Http\Controllers\API\ConfigurationController;
use App\Http\Controllers\API\UserConfigurationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("brands", BrandController::class);
Route::apiResource("categories", CategoryController::class);
Route::apiResource("comments", CommentController::class);
Route::apiResource("media", MediaController::class);
Route::apiResource("configurations", ConfigurationController::class);
Route::apiResource("posts", PostController::class);
Route::apiResource("contacts", ContactController::class);
Route::apiResource("components", ComponentController::class);
Route::apiResource("UserConfigurations", UserConfigurationController::class);
