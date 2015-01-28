@extends('basic_template')
@section('content')

    <div class="page-header">
        <h1>Nueva clase de la academia {{ $school->name }}</h1>
    </div>

    <form class="form-horizontal" action="{{ action('AdminController@createLesson') }}" method="post" role="form">
        <input type="hidden" name="school_id" value="{{ $school->id }}">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="price">Precio</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="price" id="price"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">Descripción</label>
            <div class="col-sm-10">
                <textarea rows="3" class="form-control" name="description" id="description"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="subject">Materia</label>
            <div class="col-sm-10">
                <select class="form-control" id="subject" name="subject">
                    <option value="escolar" selected="selected">Escolar</option>
                    <option value="cfp">CFP</option>
                    <option value="universitario">Universitario</option>
                    <option value="artes">Artes</option>
                    <option value="música">Música</option>
                    <option value="idiomas">Idiomas</option>
                    <option value="deportes">Deportes</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Crear" class="btn btn-primary"/>
                <a href="{{ url('admin/lessons',$school->id) }}" class="btn btn-link">Cancelar</a>
            </div>
        </div>
    </form>

@stop