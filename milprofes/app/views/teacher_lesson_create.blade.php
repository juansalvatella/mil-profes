@extends('basic_template')
@section('content')

    <div class="page-header">
        <h1>Nueva clase</h1>
    </div>

    <form class="form-horizontal" action="{{ action('TeachersController@createLesson') }}" method="post" role="form">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="subject">Categoría</label>
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
            <label class="col-sm-2 control-label" for="price">Precio</label>
            <div class="col-sm-10">
                <input type="text" placeholder="¿Cuál es el precio por hora?" class="form-control" name="price" id="price"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="address">Lugar</label>
            <div class="col-sm-10">
                <input type="text" placeholder="¿Dónde darás la clase?" class="form-control" name="address" id="address" value="{{ $user->address }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">Descripción breve</label>
            <div class="col-sm-10">
                <textarea rows="2" class="form-control" name="description" id="description"></textarea>
            </div>
        </div>
        {{--<div class="form-group">--}}
            {{--<label class="col-sm-2 control-label" for="availability">Tu disponibilidad</label>--}}
            {{--<div class="col-sm-10">--}}
                {{--<input type="text" placeholder="¿Qué momentos de la semana te van bien? Ejemplo: Lunes a Viernes de 17 a 21h" class="form-control" name="availability" id="availability"/>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Publicar clase" class="btn btn-primary"/>
                <a href="{{ url('userpanel/dashboard') }}" class="btn btn-link">Cancelar</a>
            </div>
        </div>
    </form>

@stop