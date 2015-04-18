@extends('layout')
@section('content')

<div class="container top-buffer-15 bottom-buffer-45">

    <div class="page-header">
        <h1>Nueva clase de {{ $school->name }}</h1>
    </div>

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @endif
    @if(Session::has('failure'))
        <div class="alert alert-warning" role="alert">{{ Session::get('failure') }}</div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-warning" role="alert">{{ Session::get('error') }}</div>
    @endif

    <form class="form-horizontal" action="{{ action('AdminController@createLesson') }}" method="post" role="form">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
        <input type="hidden" name="school_id" value="{{ $school->id }}">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="title">Título</label>
            <div class="col-sm-10">
                <input type="text" placeholder="¿Cuál es el título de la clase?" class="form-control" name="title" id="title" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="price">Precio (€/curso)</label>
            <div class="col-sm-10">
                <input type="text" placeholder="¿Cuál es el precio por curso?" class="form-control" name="price" id="price"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="address">Lugar</label>
            <div class="col-sm-10">
                <input type="text" placeholder="¿Dónde se darán las clases?" class="form-control" name="address" id="address" value="{{ $school->address }}"/>
            </div>
        </div>
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
                    <option value="salud">Salud y bienestar</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">Descripción breve</label>
            <div class="col-sm-10">
                <textarea rows="2" class="form-control" name="description" id="description"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="">Horario de la clase</label>
            <div class="col-sm-10">

                <div class="col-xs-4">Día</div>
                <div class="col-xs-4">De</div>
                <div class="col-xs-4">a</div>

                <div class="col-xs-4 clear-left">
                    <div class="form-group">
                        <select class="form-control" id="day1" name="day1">
                            <option value="" selected="selected"> </option>
                            <option value="LUN">Lunes</option>
                            <option value="MAR">Martes</option>
                            <option value="MIER">Miércoles</option>
                            <option value="JUE">Jueves</option>
                            <option value="VIE">Viernes</option>
                            <option value="SAB">Sábado</option>
                            <option value="DOM">Domingo</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="bfh-timepicker" data-time="15:00" data-name="start1"></div>
                </div>
                <div class="col-xs-4">
                    <div class="bfh-timepicker" data-time="21:00" data-name="end1"></div>
                </div>

                <div class="col-xs-12 clear-left" id="avail-controls1">
                    <a href="#" id="avail-control-add1" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Añadir</a>
                </div>

                @for($i=2,$h=1;$i<9;++$i,++$h)
                    <div class="hidden" id="avail{{$i}}">
                        <div class="col-xs-4 clear-left">
                            <div class="form-group">
                                <select class="form-control" id="day{{$i}}" name="day{{$i}}">
                                    <option value="" selected="selected"> </option>
                                    <option value="LUN">Lunes</option>
                                    <option value="MAR">Martes</option>
                                    <option value="MIER">Miércoles</option>
                                    <option value="JUE">Jueves</option>
                                    <option value="VIE">Viernes</option>
                                    <option value="SAB">Sábado</option>
                                    <option value="DOM">Domingo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="bfh-timepicker" data-time="15:00" data-name="start{{$i}}"></div>
                        </div>
                        <div class="col-xs-4">
                            <div class="bfh-timepicker" data-time="21:00" data-name="end{{$i}}"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 hidden clear-left" id="avail-controls{{$i}}">
                        <a href="#" id="avail-control-add{{$i}}" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Añadir</a> <a href="#" id="avail-control-del{{$i}}" class="btn btn-default"><i class="glyphicon glyphicon-minus-sign"></i> Eliminar</a>
                    </div>
                @endfor

                <div class="hidden" id="avail9">
                    <div class="col-xs-4 clear-left">
                        <div class="form-group">
                            <select class="form-control" id="day9" name="day9">
                                <option value="" selected="selected"> </option>
                                <option value="LUN">Lunes</option>
                                <option value="MAR">Martes</option>
                                <option value="MIER">Miércoles</option>
                                <option value="JUE">Jueves</option>
                                <option value="VIE">Viernes</option>
                                <option value="SAB">Sábado</option>
                                <option value="DOM">Domingo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="bfh-timepicker" data-time="15:00" data-name="start9"></div>
                    </div>
                    <div class="col-xs-4">
                        <div class="bfh-timepicker" data-time="21:00" data-name="end9"></div>
                    </div>
                </div>
                <div class="col-xs-12 hidden clear-left" id="avail-controls9">
                    <a href="#" id="avail-control-del9" class="btn btn-default"><i class="glyphicon glyphicon-minus-sign"></i> Eliminar</a>
                </div>

                <script type="text/javascript">
                    $(document).ready(function(){
                        @for($i=1;$i<9;++$i)
                        $(document).on("click","#avail-control-add{{$i}}",function(e){
                            e.preventDefault();
                            $("#avail{{$i+1}}").removeClass("hidden");
                            $("#avail-controls{{$i+1}}").removeClass("hidden");
                            $("#avail-controls{{$i}}").addClass("hidden");
                        });

                        $(document).on("click","#avail-control-del{{$i+1}}",function(e){
                            e.preventDefault();
                            $("#avail{{$i+1}}").addClass("hidden");
                            $('[name=day{{$i+1}}]').val('');
                            $("#avail-controls{{$i}}").removeClass("hidden");
                            $("#avail-controls{{$i+1}}").addClass("hidden");
                        });
                        @endfor
                    });
                </script>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 text-right">
                <input type="submit" value="Crear" class="btn btn-primary"/>
                <a href="{{ url('admin/lessons',$school->id) }}" class="btn btn-link">Cancelar</a>
            </div>
        </div>

    </form>

</div>

@stop