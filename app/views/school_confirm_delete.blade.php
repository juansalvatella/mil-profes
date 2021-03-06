@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')

@endsection

@section('content')

    <div class="container top-buffer-15 bottom-buffer-45">
    <div class="page-header">
        <h1>¿Seguro que desea eliminar la academia {{ $school->name }}?</h1>
    </div>
    <div class="container">
        <ul>
            <li>Se eliminarán todas las clases asociadas a la academia</li>
            <li>Se eliminarán todos los datos de la academia</li>
            <li>No se podrá deshacer esta acción</li>
        </ul>
    </div>
    <div class="container" style="margin-top: 15px;">
        <form action="{{ action('AdminController@doDeleteSchool') }}" method="post" role="form">
            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
            <input type="hidden" name="id" value="{{ $school->id }}"/>
            <input type="submit" class="btn btn-danger" value="Confirmar"/>
            <a href="{{ route('schools.dashboard') }}" class="btn btn-default">Cancelar</a>
        </form>
    </div>
</div>

@endsection

@section('page_js')

@endsection
