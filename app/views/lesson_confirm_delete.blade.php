@extends('layout')
@section('content')
<div class="container top-buffer-15 bottom-buffer-45">
    <div class="page-header">
        <h1>¿Seguro que desea eliminar la clase de {{ $school->name }}?</h1>
    </div>
    <div class="container">
        <ul>
            <li>Se perderán los datos de la clase</li>
            <li>No se podrá deshacer esta acción</li>
        </ul>
    </div>
    <div class="container" style="margin-top: 15px;">
        <form action="{{ action('AdminController@deleteLesson') }}" method="post" role="form">
            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
            <input type="hidden" name="school_id" value="{{ $school->id }}"/>
            <input type="hidden" name="lesson_id" value="{{ $lesson->id }}"/>
            <input type="submit" class="btn btn-danger" value="Confirmar"/>
            <a href="{{ url('admin/lessons',$school->id) }}" class="btn btn-default">Cancelar</a>
        </form>
    </div>
</div>
@stop