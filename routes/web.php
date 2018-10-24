<?php

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

Route::get('/', 'WelcomeController');

//Route::get('/books/{category}/{title}', function($category, $title){
//    return 'You are viewing the book: ' .$title. ' in the category ' .$category;
//});

Route::get('/books/{title}', 'BookController@showBook');

Route::get('/books/', 'BookController@index');

Route::get('/abc', function (){
    return App::environment();
});

/**
 * Practice
 */
Route::any('/practice/{n?}', 'PracticeController@index');