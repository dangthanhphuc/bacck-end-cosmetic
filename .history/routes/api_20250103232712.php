<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware( 'auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/upload-image', [ImageController::class, 'store']);
Route::get('/images/{filename}', [ImageController::class, 'show']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router): void {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    // Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');
});

// Route::group([
//     'middleware' => ['api', 'jwt:verify'],
//     'prefix' => 'user'
// ], function($router) {

// });

Route::group([
    'middleware' => ['api', 'role:admin'],
    'prefix' => 'categories'
], function($router) {
    Route::get('', [CategoryController::class,'index'])->withoutMiddleware('role:admin');
    Route::post('/create', [CategoryController::class,'store']);
    Route::put('/update/{id}', [CategoryController::class,'update']);
    Route::delete('/delete/{id}', [CategoryController::class,'destroy']);
});

Route::group([
    'middleware' => ['api', 'role:admin'],
    'prefix' => 'brands'
], function($router) {
    Route::get('', [BrandController::class,'index'])->withoutMiddleware('role:admin');
    Route::post('/create', [BrandController::class,'store']);
    Route::put('/update/{id}', [BrandController::class,'update']);
    Route::delete('/delete/{id}', [BrandController::class,'destroy']);
});

Route::group([
    'middleware' => ['api', 'role:user'],
    'prefix' => 'cart'
], function($router) {
    Route::get('{userId}', [CartController::class,'show']);
    Route::post('/create', [CartController::class,'store']);
    Route::put('/update', [CartController::class,'update']);
    Route::delete('/delete/{id}', [CartController::class,'destroy']);
});

Route::group([
    'middleware' => ['api', 'role:user'],
    'prefix' => 'orders'
], function($router) {
    Route::get('', [OrderController::class,'orders']);
    Route::post('/create', [OrderController::class,'create']);
    Route::put('/update/{id}', [OrderController::class,'update']);
    Route::delete('/delete/{id}', [OrderController::class,'delete']);
}); // Create OrderDetail model

Route::group([
    'middleware' => ['api', 'role:user'],
    'prefix' => 'user'
], function($router) {
   Route::post('/{id}', [UserController::class,'userById']);
   Route::put('/update/{id}', [UserController::class,'update']);
});


Route::group([
    'middleware' => ['api', 'role:admin'],
    'prefix' => 'products'
], function($router) {
    Route::get('/', [ProductController::class, 'products'])->withoutMiddleware('role:admin');
   // Route::get('/{id}', [AuthController::class,'productById']);
    Route::post('/create', [ProductController::class,'create']);
    Route::put('/update/{id}', [ProductController::class,'update']);
    Route::delete('/delete/{id}', [ProductController::class, 'delete']);
   // Route::get('/{id}', [AuthController::class,'productById']);
});
