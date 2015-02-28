@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div class="generic-title"><h3>Nueva clase</h3></div>

            <div class="generic-subtitle">Introduce los detalles de tu nueva clase</div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-50 magic-align">

            <div class="col-xs-12 col-sm-offset-2 col-sm-8">
                <form class="form-horizontal" action="{{ action('TeachersController@createLesson') }}" method="post" role="form">
                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
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
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Publicar clase" class="btn btn-primary"/>
                            <a href="{{ url('userpanel/dashboard') }}" class="btn btn-link">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

@stop