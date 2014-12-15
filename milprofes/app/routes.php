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

Route::get('/user/{naming}', function($naming)
{
    $user = new User();
    $user->name = $naming;
    $user->email = $naming.'@email.com';
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

Route::get('/profesor/{naming}', function($naming)
{
    $profesor = new Profesor();
    $profesor->nombre = $naming;
    $profesor->preciohora = 'Negociable';
    $profesor->disponibilidad = 'Lunes y Miércoles de 17h a 18:30h';
    $profesor->direccion = 'Carrer de Roger de Llúria, 14';
    $profesor->poblacion = 'Barcelona';
    $profesor->email = $naming.'@email.com';
    $profesor->telefono = '999 88 77 66';
    $profesor->categoria = 'escolar';
    $profesor->descripcion = 'Sin descripción';
    var_dump($profesor->save());
});
Route::get('/profesores', function()
{
    $profesores = Profesor::all();

    return View::make('profesores')->with('profesores', $profesores);
});

Route::get('/academia/{naming}', function($naming)
{
    $academia = new Academia();
    $academia->nombre = $naming;
    $academia->precio = 'Desde 300€ por curso';
    $academia->horario = 'De Lunes a Viernes de 15h a 23h';
    $academia->direccion = 'Carrer de Roger de Llúria, 14';
    $academia->poblacion = 'Barcelona';
    $academia->email = $naming.'@email.com';
    $academia->telefono = '799 88 77 66';
    $academia->categoria = 'universitario';
    $academia->descripcion = 'Sin descripción';
    var_dump($academia->save());
});
Route::get('/academias', function()
{
    $academias = Academia::all();

    return View::make('academias')->with('academias', $academias);
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