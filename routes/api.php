<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('category', App\Http\Controllers\CategoryController::class);
Route::resource('questions', App\Http\Controllers\QuestionController::class);
Route::get('faq', [App\Http\Controllers\QuestionController::class,'faq']);
Route::get('categories', [App\Http\Controllers\CategoryController::class,'getCategories']);
