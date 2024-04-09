<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\CategoryFoodController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\SetTableController;
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
    Route::get('/invoices', [InvoiceController::class, 'index']); 
    Route::group(['prefix'=>'invoice'], function(){
        // invoice/details/{invoice_id}
        Route::post('/create', [InvoiceController::class, 'create']);
        Route::put('/edit/{id}', [InvoiceController::class, 'edit']);
        Route::delete('/del/{id}', [InvoiceController::class, 'delete']);
        Route::get('/{id}', [InvoiceController::class, 'getID']);
        Route::get('/details/{invoice_id}', [InvoiceDetailsController::class, 'index']);
    });

    // foods
    Route::get('/foods', [FoodController::class, 'getPage']);
    Route::get('/category-foods', [CategoryFoodController::class, 'index']);
    
    Route::group(['prefix'=>'food'], function(){
        // food
        Route::post('/create', [FoodController::class, 'create']);
        Route::put('/edit/{id}', [FoodController::class, 'edit']);
        Route::delete('/del/{id}', [FoodController::class, 'delete']);
        Route::get('/detail/{id}', [FoodController::class, 'getID']);
    });

    Route::group(['prefix'=>'category-food'], function(){
        // category-food
        Route::post('/create', [CategoryFoodController::class, 'create']);
        Route::put('/edit/{id}', [CategoryFoodController::class, 'edit']);
        Route::delete('/del/{id}', [CategoryFoodController::class, 'delete']);
        Route::get('/{id}', [CategoryFoodController::class, 'getID']);
    });


    Route::get('/tables', [SetTableController::class, 'index']);
    Route::group(['prefix' => 'table'], function () {
        // food
        Route::post('/create', [SetTableController::class, 'create']);
        Route::put('/edit/{id}', [SetTableController::class, 'edit']);
        Route::delete('/del/{id}', [SetTableController::class, 'delete']);
        Route::get('/{id}', [SetTableController::class, 'getID']);
    });
});


Route::get('/', function () {
    return json_encode(["message" => "hello world"]);
});

