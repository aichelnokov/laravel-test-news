<?php

use App\Http\Controllers\RubricsControler;
use App\Http\Controllers\NewsControler;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
});

Route::get('/news', [NewsControler::class, 'list']);
Route::get('/news/{id}', [NewsControler::class, 'view'])->where('id', '\d+');
Route::post('/news/add', [NewsControler::class, 'add']);
Route::get('/rubrics/{id}', [RubricsControler::class, 'list'])->where('id', '\d+');
