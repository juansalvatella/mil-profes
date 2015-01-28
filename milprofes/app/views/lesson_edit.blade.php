@extends('basic_template')
@section('content')

    <div class="page-header">
        <h1>Editar clase de la academia {{ $school->name }}</h1>
    </div>

    <form class="form-horizontal" action="{{ action('AdminController@saveLesson') }}" method="post" role="form">
        <input type="hidden" name="school_id" value="{{ $school->id }}">
        <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="price">Precio</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="price" id="price" value="{{ $lesson->price }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">Descripción</label>
            <div class="col-sm-10">
                <textarea rows="3" class="form-control" name="description" id="description">{{ $lesson->description }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="subject">Materia</label>
            <div class="col-sm-10">
                <select class="form-control" id="subject" name="subject">
                    <option value="escolar" @if($subject->name=='escolar') selected="selected" @endif>Escolar</option>
                    <option value="cfp" @if($subject->name=='cfp') selected="selected" @endif>CFP</option>
                    <option value="universitario" @if($subject->name=='universitario') selected="selected" @endif>Universitario</option>
                    <option value="artes" @if($subject->name=='artes') selected="selected" @endif>Artes</option>
                    <option value="música" @if($subject->name=='música') selected="selected" @endif>Música</option>
                    <option value="idiomas" @if($subject->name=='idiomas') selected="selected" @endif>Idiomas</option>
                    <option value="deportes" @if($subject->name=='deportes') selected="selected" @endif>Deportes</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Guardar cambios" class="btn btn-primary"/>
                <a href="{{ url('admin/lessons',$school->id) }}" class="btn btn-link">Cancelar</a>
            </div>
        </div>
    </form>

@stop