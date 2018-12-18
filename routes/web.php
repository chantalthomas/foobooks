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

/**
 * Books
 */
Route::group(['middleware' => 'auth'], function () {
    Route::get('/books/search', 'BookController@search');
    Route::get('/books/search-process', 'BookController@searchProcess');
    # CREATE
    Route::get('/books/create', 'BookController@create');
    Route::post('/books', 'BookController@store');
    # SHOW
    Route::get('/books/{id}', 'BookController@showBook');
    Route::get('/books', 'BookController@index');
    # EDIT
    # Show the form to edit a specific book
    Route::get('/books/{id}/edit', 'BookController@edit');
    # Process the form to edit a specific book
    Route::put('/books/{id}', 'BookController@update');
    # DELETE
    # Show the page to confirm deletion of a book
    Route::get('/books/{id}/delete', 'BookController@delete');
    # Process the deletion of a book
    Route::delete('/books/{id}', 'BookController@destroy');
});


Route::get('/abc', function (){
    return App::environment();
});

/**
 * Practice
 */
Route::any('/practice/{n?}', 'PracticeController@index');

/**
 * Pages
 * Simple, static pages w/o a lot of logic
 */
 Route::view('about', 'about');
 Route::view('/contact', 'contact');


Route::get('/debug', function () {

    $debug = [
        'Environment' => App::environment(),
    ];

    /*
    The following commented out line will print your MySQL credentials.
    Uncomment this line only if you're facing difficulties connecting to the
    database and you need to confirm your credentials. When you're done
    debugging, comment it back out so you don't accidentally leave it
    running on your production server, making your credentials public.
    */
    #$debug['MySQL connection config'] = config('database.connections.mysql');

    try {
        $databases = DB::select('SHOW DATABASES;');
        $debug['Database connection test'] = 'PASSED';
        $debug['Databases'] = array_column($databases, 'Database');
    } catch (Exception $e) {
        $debug['Database connection test'] = 'FAILED: '.$e->getMessage();
    }

    dump($debug);
});

#AUTH
Auth::routes();

Route::get('/show-login-status', function () {
    $user = Auth::user();

    if ($user) {
        dump('You are logged in.', $user->toArray());
    } else {
        dump('You are not logged in.');
    }

    return;
});
