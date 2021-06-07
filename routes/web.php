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
Route::post('/banowanie-znajomych', [App\Http\Controllers\FriendsController::class, 'banowanie']);
Route::post('/odbanuj-znajomego', [App\Http\Controllers\FriendsController::class, 'odbanowanie']);
Route::get('/API/logowanie.php',[App\Http\Controllers\ApiController::class, 'logowanie']);
Route::post('/send-message',[App\Http\Controllers\MessageController::class, 'sendMessage'])->name('message.sendMessage');
Route::post('/recive-message',[App\Http\Controllers\MessageController::class, 'reciveMessage'])->name('message.reciveMessage');
Route::post('/dodaj-plik',[App\Http\Controllers\MessageController::class, 'dodajPlik'])->name('dodajPlik');
Route::post('/zmien-avatar',[App\Http\Controllers\ApiController::class, 'changeAvatar'])->name('changeAvatar');
Route::get('/API/friends.php',[App\Http\Controllers\ApiController::class, 'friend_list']);
Route::get('/API/wysylanie-zaproszenia.php',[App\Http\Controllers\ApiController::class, 'wysylanie_zaproszenia']);
Route::get('/API/akceptowanie-zaproszenia.php',[App\Http\Controllers\ApiController::class, 'akceptowanie_zaproszenia']);
Route::get('/API/usuwanie-znajomych.php',[App\Http\Controllers\ApiController::class, 'usuwanie_znajomych']);
Route::get('/API/banowanie-znajomych.php',[App\Http\Controllers\ApiController::class, 'banowanie_znajomych']);
Route::get('/API/wyslane-zaproszenia.php',[App\Http\Controllers\ApiController::class, 'wyslane_zaproszenia']);
Route::get('/API/odebrane-zaproszenia.php',[App\Http\Controllers\ApiController::class, 'odebrane_zaproszenia']);
Route::get('/API/lista-zbanowanych.php',[App\Http\Controllers\ApiController::class, 'lista_zbanowanych']);
Route::get('/API/odbanowanie-znajomego.php',[App\Http\Controllers\ApiController::class, 'odbanowanie_znajomego']);
Route::get('/API/odbieranie-wiadomosci.php',[App\Http\Controllers\ApiController::class, 'odbieranie_wiadomosci']);
Route::get('/API/wysylanie-wiadomosci.php',[App\Http\Controllers\ApiController::class, 'wysylanie_wiadomosci']);
Route::get('/API/lista-wulgaryzmow.php',[App\Http\Controllers\ApiController::class, 'wulgaryzmy']);
Route::get('/API/lista-zamiennikow.php',[App\Http\Controllers\ApiController::class, 'zamienniki']);
Route::get('/API/utworz-grupe.php',[App\Http\Controllers\ApiController::class, 'utworz_grupe']);

Route::get('/dodaj-wulgaryzmy', [App\Http\Controllers\WulgaryzmyController::class, 'index'])->name('dodaj-wulgaryzmy');
Route::get('/dodaj-zamienniki', [App\Http\Controllers\ZamiennikiController::class, 'index'])->name('dodaj-zamienniki');
Route::post('/utworz-grupe',[App\Http\Controllers\GrupyController::class, 'utworz_grupe'])->name('utworz-grupe');
Route::post('/usun_grupe',[App\Http\Controllers\GrupyController::class, 'utworz_grupe'])->name('usun-grupe');

//admin
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
Route::get('/tabela-zamienniki', [App\Http\Controllers\ZamiennikiController::class, 'tabela_zamienniki'])->name('tabela-zamienniki');
Route::post('/dodaj-zamiennik', [App\Http\Controllers\ZamiennikiController::class, 'dodaj_zamiennik'])->name('dodaj-zamiennik');
Route::get('/tabela-wulgaryzmy', [App\Http\Controllers\WulgaryzmyController::class, 'tabela_wulgaryzmy'])->name('tabela-wulgaryzmy');
Route::post('/dodaj-wulgaryzm', [App\Http\Controllers\WulgaryzmyController::class, 'dodaj_wulgaryzm'])->name('dodaj-wulgaryzm');
