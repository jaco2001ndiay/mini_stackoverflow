<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CollectiveController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\QuestionController;
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
// Route::get('questions/{id}/voteup', 'QuestionController@voteUp');
// Route::get('questions/{id}/votedown', 'QuestionController@voteDown');
// Route::get('question/{id}/comments', 'QuestionController@getQuestionComments');
// Route::post('comments/add', 'CommentController@store');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'collectives', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [CollectiveController::class, 'index']);
    Route::post('store', [CollectiveController::class, 'store']);
    Route::get('edit/{id}', [CollectiveController::class, 'edit']);
    Route::get('create', [CollectiveController::class, 'create']);
    Route::post('update/{id}', [CollectiveController::class, 'update']);
    Route::delete('destroy/{id}', [CollectiveController::class, 'destroy']);
    Route::get('show/{id}', [CollectiveController::class, 'show']);
});
Route::group(['prefix' => 'questions', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [QuestionController::class, 'index']);
    Route::post('store', [QuestionController::class, 'store']);
    Route::get('edit/{id}', [QuestionController::class, 'edit']);

    Route::post('update/{id}', [QuestionController::class, 'update']);
    Route::delete('destroy/{id}', [QuestionController::class, 'destroy']);
    Route::get('show/{id}', [QuestionController::class, 'show']);
});





