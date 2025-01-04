<?php

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
    'middleware' => ['api', 'role:user'],
    'prefix' => 'user'
], function($router) {
    Route::post('/get/{id}', [AuthController::class,'get']);
    Route::post('/order', [AuthController::class,'order']);
    Route::post('/ad}', [AuthController::class,'get']);


});


Route::group([
    'middleware' => ['api', 'role:admin'],
    'prefix' => 'products'
], function($router) {
    Route::get('/', [ProductController::class, 'products'])->withoutMiddleware('role:admin');
    Route::post('/create', [ProductController::class,'create']);
    Route::put('/update/{id}', [ProductController::class,'update']);
    Route::delete('/delete/{id}', [ProductController::class, 'delete']);
});
