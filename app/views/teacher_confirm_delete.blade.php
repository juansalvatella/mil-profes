@extends('layout')
@section('content')
<div class="container top-buffer-15 bottom-buffer-45">
    <div class="page-header">
        <h1>¿Seguro que desea eliminar al profe. {{ $user->name }}?</h1>
    </div>
    <div class="container">
        <ul>
            <li>Se eliminarán todas las clases asociadas al profesor</li>
            <li>Se eliminarán todos los datos del profesor</li>
            <li>No se podrá deshacer esta acción</li>
        </ul>
    </div>
    <div class="container" class="top-buffer-15">
        <form action="{{ action('AdminController@deleteUser') }}" method="post" role="form">
            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
            <input type="hidden" name="id" value="{{ $user->id }}"/>
            <input type="submit" class="btn btn-danger" value="Confirmar"/>
            <a href="{{ url('admin/teachers') }}" class="btn btn-default">Cancelar</a>
        </form>
    </div>
</div>
@stop