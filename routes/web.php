<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckComments;

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

//Basic routes
Route::get('/', 'ArtController@index')->name('art');
Route::get('details/{id}', 'ArtController@show')->name('art.link');
Route::get('about', 'AboutController@index')->name('about');

//Search routes
Route::get('search', 'ArtController@search')->name('search');
Route::post('search/result', 'ArtController@searchSubmit')->name('search.submit');


//pages where login is needed
Route::middleware('auth')->group(function (){
    Route::get('profile', 'ArtController@profile')->name('profile');
    Route::post('store', 'ArtController@store')->name('store');

    //Pages where you need at least 1 comment to continue
    Route::middleware([CheckComments::class])->group(function (){
            Route::get('upload', 'ArtController@upload')->name('upload');
        });
});


//pages where admin or correct user is needed
Route::middleware([CheckAdmin::class])->group(function (){
    Route::get('edit/{id}', 'ArtController@edit')->name('art.edit');
    Route::get('delete/{id}', 'ArtController@delete')->name('art.delete');
    Route::post('hide/{id}', 'ArtController@hide')->name('art.hide');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
