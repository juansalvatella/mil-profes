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

//Home page
Route::get('/', function()
{
    return View::make('home');
});
Route::get('demo', function()
{
    return View::make('home');
});

//Search controller calls
Route::post('demo','SearchController@search');
Route::post('/demo/ajaxsearch','SearchController@search');

//Populate and view tables. Database test tools. FOR TEST PURPOSES ONLY!!!
Route::get('populate', 'PopulateController@populate');
Route::get('unpopulate', 'PopulateController@unpopulate');
Route::get('/list/{table}', function($table)
{
    if($table=='students' || $table=='estudiantes')
    {
        $rows = Student::all();
        $columns = Schema::getColumnListing('students');
    }
    elseif($table=='users' || $table=='usuarios')
    {
        $rows = User::all();
        $columns = Schema::getColumnListing('users');
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
    elseif($table=='teacher_lessons' || $table=='clases_de_profesores')
    {
        $rows = TeacherLesson::all();
        $columns = Schema::getColumnListing('teacher_lessons');
    }
    elseif($table=='school_lessons' || $table=='clases_de_academias')
    {
        $rows = SchoolLesson::all();
        $columns = Schema::getColumnListing('school_lessons');
    }
    elseif($table=='subjects' || $table=='materias')
    {
        $rows = Subject::all();
        $columns = Schema::getColumnListing('subjects');
    }
    elseif($table=='ratings')
    {
        $rows = Rating::all();
        $columns = Schema::getColumnListing('ratings');
    }
    else
        return $table.' table not found';

    return View::make('show_table_contents', compact('table','rows','columns'));
});

// Confide routes
    //Route::get('users/create', 'UsersController@create');
Route::get('users/create', function(){ return View::make('users_register'); });
Route::post('users', 'UsersController@store');
    //Route::get('users/login', 'UsersController@login');
Route::get('users/login', function(){ return View::make('users_login'); });
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');

//Control Panels
Route::get('userpanel/dashboard', function(){ return View::make('userpanel_dashboard'); });

//Auth filters
Route::when('userpanel/*', 'auth');

//Not ready. To be implemented.
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