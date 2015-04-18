@extends('layout')
@section('content')


    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div><h1 class="generic-title">Editar clase</h1></div>

            <div><h2 class="generic-subtitle">Edita los datos de tu clase</h2></div>

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

                <form class="form-horizontal" action="{{ action('TeachersController@saveLesson') }}" method="post" role="form" id="edit-l-form">
                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                    <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="title">Título (*)</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="¿Cuál es el título de tu clase?" class="form-control" name="title" id="title" required="required" data-error="Rellena este campo." maxlength="50" value="{{{ $lesson->title }}}"  />
                            <div class="help-block with-errors">En pocas palabras, por ejemplo: Clase de guitarra clásica.</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="subject">Categoría (*)</label>
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
                            <input type="hidden" class="form-control">
                            <div class="help-block with-errors">¿En qué categoría clasificarías tu clase?</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="price">Precio (€/hora)</label>
                        <div class="col-sm-10">
                            <input type="text" pattern="^([0-9\.,]){0,}$" class="form-control" name="price" id="price" placeholder="¿Cuál será el precio por hora de tu clase?"  value="{{ $lesson->price }}" data-error="Introduce una cifra, por ejemplo: 15" />
                            <div class="help-block with-errors">Introduce una cifra, por ejemplo.: 15. Si lo prefieres, puedes dejarlo en blanco</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="address">Lugar (*)</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="¿Dónde darás la clase?" class="form-control" name="address" id="address" value="{{ $lesson->address }}" required="required" data-error="Rellena este campo."/>
                            <div class="help-block with-errors">Introduce calle, número, ciudad...</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="description">Descripción breve (*)</label>
                        <div class="col-sm-10">
                            <textarea rows="2" class="form-control" name="description" id="description" placeholder="Describe los contenidos de tu clase" required="required" maxlength="200" data-error="Rellena este campo.">{{ $lesson->description }}</textarea>
                            <div class="help-block with-errors">Introduce una descripción breve y atractiva de tu clase</div>
                            <div id="chars_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Guardar cambios" class="btn btn-primary"/>
                            <a href="{{ url('userpanel/dashboard') }}" class="btn btn-link">Cancelar</a>
                        </div>
                    </div>
                </form>

                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#edit-l-form").validator();

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