<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('app/create_tag', [AdminController::class, 'addTag']);
Route::get('app/get_tags', [AdminController::class, 'getTag']);
Route::post('app/edit_tag', [AdminController::class, 'editTag']);
Route::post('app/delete_tag', [AdminController::class, 'deleteTag']);
Route::post('app/upload', [AdminController::class, 'upload']);
Route::post('app/delete_image', [AdminController::class, 'deleteImage']);
Route::post('app/create_category', [AdminController::class, 'addCategory']);
Route::get('app/get_category', [AdminController::class, 'getCategory']);
Route::post('app/edit_category', [AdminController::class, 'editCategory']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/new', [TestController::class, 'index']);

// Route::get('/{any}',function(){
//     return view('welcome');
// })->where("any",".*");

// Route::any('{slug}',function(){
//     return view('welcome');
// });

Route::get('/{any}',[TestController::class, 'index'])->where('any','.*');

// Route::any('{all}',function(){
//     return view('welcome'); // it should be main blade file 
// })->where('all', '^(?!api).*$')->where('all', '^(?!storage).*$');