<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\TypesDeviceController;
use App\Http\Controllers\DeviceFuncController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\QuestionTypeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerDetailsController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LessonDetailsController;
use App\Http\Controllers\EnglishBookController;
use App\Http\Controllers\EnglishBookDetailsController;
use App\Http\Controllers\UserController;
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


Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});


Route::group([
    'middleware' => 'auth:api',
], function ($router) {
    // USER
    Route::get('/users', [UserController::class, 'index']);
});


Route::get('/', function () {
    return json_encode(["message" => "hello world"]);
});

