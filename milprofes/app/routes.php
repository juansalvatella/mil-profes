<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('demo', function()
{
    return View::make('home');
});

Route::post('demo','SearchController@search');

Route::post('/demo/ajaxsearch','SearchController@search');

Route::get('populate', 'PopulateController@populate');

Route::get('/list/{table}', function($table)
{
    if($table=='students' || $table=='estudiantes')
    {
        $rows = Student::all();
        $columns = Schema::getColumnListing('students');
    }
    elseif($table=='teachers' || $table=='profesores')
    {
        $rows = Teacher::all();
        $columns = Schema::getColumnListing('teachers');
    }
    elseif($table=='schools' || $table=='academias')
    {
        $rows = School::all();
        $columns = Schema::getColumnListing('schools');
    }
    elseif($table=='lessons' || $table=='clases')
    {
        $rows = Lesson::all();
        $columns = Schema::getColumnListing('lessons');
    }
    elseif($table=='ratings')
    {
        $rows = Rating::all();
        $columns = Schema::getColumnListing('ratings');
    }
    else
        return 'Table not found';

    return View::make('show_table_contents', compact('table','rows','columns'));
});

//Route::get('contact', function()
//{
//    return View::make('contact');
//});
//
//Route::get('faq', function()
//{
//    return View::make('faq');
//});
//
//Route::get('search', function()
//{
//    return View::make('search');
//});