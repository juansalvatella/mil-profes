@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div><h1 class="generic-title">Confirmar eliminación</h1></div>

            <div><h2 class="generic-subtitle">Confirma la eliminación de tu clase</h2></div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-150 magic-align">

            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">

                <h3>¿Seguro que deseas eliminar tu clase?</h3>
                <div class="top-buffer-25">
                    <ul>
                        <li>Se perderán los datos de tu clase</li>
                        <li>No se podrá deshacer esta acción</li>
                    </ul>
                </div>
                <div class="top-buffer-25">
                    <form action="{{ action('TeachersController@deleteLesson') }}" method="post" role="form">
                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                        <input type="hidden" name="lesson_id" value="{{ $lesson->id }}"/>
                        <input type="submit" class="btn btn-danger" value="Confirmar"/>
                        <a href="{{ url('userpanel/dashboard') }}" class="btn btn-default">Cancelar</a>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>





@stop