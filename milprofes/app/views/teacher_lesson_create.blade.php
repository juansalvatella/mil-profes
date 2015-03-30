@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div class="generic-title"><h3>Nueva clase</h3></div>

            <div class="generic-subtitle">Introduce los detalles de tu nueva clase</div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-150 magic-align">

            @if (Session::get('success'))
                <div class="row">
                    <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
                        <div class="alert alert-success">{{{ Session::get('success') }}}</div>
                    </div>
                </div>
            @endif
            @if (Session::get('error'))
                <div class="row">
                    <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
                        <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
                    </div>
                </div>
            @endif


            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">

                <form class="form-horizontal" action="{{ action('TeachersController@createLesson') }}" method="post" role="form" id="create-l-form">
                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="subject">Categoría (*)</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="subject" name="subject">
                                <option value="escolar" selected="selected">Escolar</option>
                                <option value="cfp">CFP</option>
                                <option value="universitario">Universitario</option>
                                <option value="artes">Artes</option>
                                <option value="musica">Música</option>
                                <option value="idiomas">Idiomas</option>
                                <option value="deportes">Deportes</option>
                            </select>
                            <input type="hidden" class="form-control">
                            <div class="help-block with-errors">¿En qué categoría clasificarías tu clase?</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="price">Precio (€/hora)</label>
                        <div class="col-sm-10">
                            <input type="text" pattern="^([0-9\.,]){0,}$" placeholder="¿Cuál será el precio por hora de tu clase?" class="form-control" name="price" id="price" data-error="Introduce una cifra, por ejemplo: 15"/>
                            <div class="help-block with-errors">Introduce una cifra, por ejemplo: 15. Si lo prefieres, puedes dejarlo en blanco</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="address">Lugar (*)</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="¿Dónde darás la clase?" class="form-control" name="address" id="address" value="{{ $user->address }}" required="required" data-error="Rellena este campo."/>
                            <div class="help-block with-errors">Introduce calle, número, ciudad...</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="description">Descripción breve (*)</label>
                        <div class="col-sm-10">
                            <textarea rows="2" class="form-control" name="description" id="description" placeholder="Describe los contenidos de tu clase" required="required" maxlength="200" data-error="Rellena este campo."></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Publicar clase" class="btn btn-primary"/>
                            <a href="{{ url('userpanel/dashboard') }}" class="btn btn-link">Cancelar</a>
                        </div>
                    </div>
                </form>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#create-l-form").validator();
                    });
                </script>

            </div>

        </div>
    </div>

    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

@stop