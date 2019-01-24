<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List products
route::get('products', 'API\Product_CategoryController@getAll');
// List single product
route::get('product/{id}', 'API\Product_CategoryController@getById');
// List single category
route::get('category/{id}', 'API\Product_CategoryController@getByCategory');
// Create new product
route::post('create', 'API\Product_CategoryController@store');
// Update product
route::put('update', 'API\Product_CategoryController@store');
// Delete product
route::delete('products/{id}', 'API\Product_CategoryController@deleteProduct');
