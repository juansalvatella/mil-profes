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

Route::get('/user', function()
{
    $user = new User();
    $user->email = 'philip';
    var_dump($user->save());
});
Route::get('/users', function()
{
    $users = User::all();

    return View::make('users')->with('users', $users);
});

Route::get('user/view/{id}', function($id)
{
    return View::make('user');
});
Route::get('user/edit/{id}', function($id)
{
    return View::make('user');
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