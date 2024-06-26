<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\CategoryFoodController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\DeskController;
use App\Http\Controllers\PrintController;
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
    'middleware' => 'auth:api'
], function ($router) {
    // users/
    Route::get('/users', [UserController::class, 'index']);

    // invoices
    Route::get('/invoices', [InvoiceController::class, 'getPage']);
    Route::group(['prefix' => 'invoice'], function () {
        Route::post('/create', [InvoiceController::class, 'create']);
        Route::put('/edit/{id}', [InvoiceController::class, 'edit']);
        Route::delete('/del/{id}', [InvoiceController::class, 'delete']);
        Route::get('/detail/{id}', [InvoiceController::class, 'getID']);
        Route::get('/param/detail', [InvoiceController::class, 'getParam']);
    });
    Route::get('/invoice_details/{invoice_id}', [InvoiceDetailsController::class, 'getDetails']);
    Route::group(['prefix' => 'invoice_detail/detail'], function () {
        Route::get('/{invoice_detail_id}', [InvoiceDetailsController::class, 'getID']);
        Route::put('/update_status/{invoice_detail_id}', [InvoiceDetailsController::class, 'updateStatus']);
        Route::put('/edit/{invoice_detail_id}', [InvoiceDetailsController::class, 'edit']);

    });

    // foods
    Route::get('/foods', [FoodController::class, 'getPage']);
    Route::get('/category-foods', [CategoryFoodController::class, 'index']);

    Route::group(['prefix' => 'food'], function () {
        // food
        Route::post('/create', [FoodController::class, 'create']);
        Route::put('/edit/{id}', [FoodController::class, 'edit']);
        Route::delete('/del/{id}', [FoodController::class, 'delete']);
        Route::get('/detail/{id}', [FoodController::class, 'getID']);
    });

    Route::group(['prefix' => 'category-food'], function () {
        // category-food
        Route::post('/create', [CategoryFoodController::class, 'create']);
        Route::put('/edit/{id}', [CategoryFoodController::class, 'edit']);
        Route::delete('/del/{id}', [CategoryFoodController::class, 'delete']);
        Route::get('/{id}', [CategoryFoodController::class, 'getID']);
    });


    Route::get('/desks', [DeskController::class, 'getPage']);
    Route::group(['prefix' => 'desk'], function () {
        // food
        Route::post('/create', [DeskController::class, 'create']);
        Route::put('/edit/{id}', [DeskController::class, 'edit']);
        Route::delete('/del/{id}', [DeskController::class, 'delete']);
        Route::get('/{id}', [DeskController::class, 'getID']);
    });

});

Route::get('/print-invoice', [PrintController::class, 'index']);

Route::get('/', function () {
    return json_encode(["message" => "hello world"]);
});
