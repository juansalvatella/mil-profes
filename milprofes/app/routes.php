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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('demo', function()
{
    return View::make('home');
});

Route::post('demo','SearchController@search');

Route::get('populate', 'PopulateController@populate');

Route::get('teachers', function()
{
    $teachers = Teacher::all();

    return View::make('teachers')->with('teachers', $teachers);
});

Route::get('schools', function()
{
    $schools = School::all();

    return View::make('schools')->with('schools', $schools);
});

Route::get('students', function()
{
    $students = Student::all();

    return View::make('students')->with('students', $students);
});

Route::get('contact', function()
{
    return View::make('contact');
});

Route::get('faq', function()
{
    return View::make('faq');
});

Route::get('search', function()
{
    return View::make('search');
});