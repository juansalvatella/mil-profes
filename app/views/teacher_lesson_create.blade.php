@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div><h1 class="generic-title">Nueva clase</h1></div>

            <div><h2 class="generic-subtitle">Introduce los detalles de tu nueva clase</h2></div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-150 magic-align">

            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">

                <form class="form-horizontal" action="{{ action('TeachersController@createLesson') }}" method="post" role="form" id="create-l-form">
                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="title">Título (*)</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="¿Cuál es el título de tu clase?" class="form-control" name="title" id="title" required="required" data-error="Rellena este campo." maxlength="50" />
                            <div class="help-block with-errors">En pocas palabras, por ejemplo: Clase de guitarra clásica.</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="subject">Categoría (*)</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="subject" name="subject">
                                <?php $k = 0; ?>
                                @foreach(Subject::all() as $subj)
                                    <option value="{{ $subj->name }}" @if($k==0) selected="selected" @endif>@lang('subjects.'.$subj->name)</option>
                                <?php ++$k; ?>
                                @endforeach
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
                            <div class="help-block with-errors">Introduce una descripción breve y atractiva de tu clase</div>
                            <div id="chars_feedback"></div>
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

                        var text_max = 200;
                        var tbox = $('#description');
                        var text_length = tbox.val().length;
                        var text_remaining = text_max - text_length;
                        $('#chars_feedback').html('(' + text_remaining + ' caracteres disponibles)');
                        tbox.keyup(function() {
                            var text_length = $('#description').val().length;
                            var text_remaining = text_max - text_length;
                            $('#chars_feedback').html('(' + text_remaining + ' caracteres disponibles)');
                        });
                    });
                </script>

            </div>

        </div>
    </div>

    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

@endsection
