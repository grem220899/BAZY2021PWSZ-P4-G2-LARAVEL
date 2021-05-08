<?php

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
    return view('welcome');
});

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\FriendsController::class, 'index'])->name('home');
Route::get('/znajomi', [App\Http\Controllers\FriendsController::class, 'index'])->name('znajomi');
Route::post('/dodaj-znajomych', [App\Http\Controllers\FriendsController::class, 'save']);
Route::post('/akceptuj-zaproszenie', [App\Http\Controllers\FriendsController::class, 'akceptuj']);
Route::post('/usun-znajomego', [App\Http\Controllers\FriendsController::class, 'usun_znajomego']);
Route::get('/API/logowanie.php',[App\Http\Controllers\ApiController::class, 'logowanie']);
Route::post('/send-message',[App\Http\Controllers\MessageController::class, 'sendMessage'])->name('message.sendMessage');
Route::post('/recive-message',[App\Http\Controllers\MessageController::class, 'reciveMessage'])->name('message.reciveMessage');
