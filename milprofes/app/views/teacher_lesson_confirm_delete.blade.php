@extends('layout')
@section('content')

    <div class="page-header">
        <h1>¿Seguro que deseas eliminar tu clase?</h1>
    </div>
    <div class="container">
        <ul>
            <li>Se perderán los datos de tu clase</li>
            <li>No se podrá deshacer esta acción</li>
        </ul>
    </div>
    <div class="container" style="margin-top: 15px;">
        <form action="{{ action('TeachersController@deleteLesson') }}" method="post" role="form">
            <input type="hidden" name="lesson_id" value="{{ $lesson->id }}"/>
            <input type="submit" class="btn btn-danger" value="Confirmar"/>
            <a href="{{ url('userpanel/dashboard') }}" class="btn btn-default">Cancelar</a>
        </form>
    </div>

@stop