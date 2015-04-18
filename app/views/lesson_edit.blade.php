@extends('layout')
@section('content')

<div class="container top-buffer-15 bottom-buffer-45">

    <div class="page-header">
        <h1>Editar clase de {{ $school->name }}</h1>
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

    <form class="form-horizontal" action="{{ action('AdminController@saveLesson') }}" method="post" role="form">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
        <input type="hidden" name="school_id" value="{{ $school->id }}">
        <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="title">Título</label>
            <div class="col-sm-10">
                <input type="text" placeholder="¿Cuál es el título de la clase?" class="form-control" name="title" id="title" value="{{{ $lesson->title }}}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="price">Precio (€/curso)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="price" id="price" value="{{ $lesson->price }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="address">Lugar</label>
            <div class="col-sm-10">
                <input type="text" placeholder="¿Dónde darás la clase?" class="form-control" name="address" id="address" value="{{ $lesson->address }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="subject">Categoría</label>
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
            <label class="col-sm-2 control-label" for="description">Descripción breve</label>
            <div class="col-sm-10">
                <textarea rows="3" class="form-control" name="description" id="description">{{ $lesson->description }}</textarea>
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
                            <option value="" @if($picks[0]['day']=='') selected="selected" @endif > </option>
                            <option value="LUN" @if($picks[0]['day']=='LUN') selected="selected" @endif >Lunes</option>
                            <option value="MAR" @if($picks[0]['day']=='MAR') selected="selected" @endif >Martes</option>
                            <option value="MIER" @if($picks[0]['day']=='MIER') selected="selected" @endif >Miércoles</option>
                            <option value="JUE" @if($picks[0]['day']=='JUE') selected="selected" @endif >Jueves</option>
                            <option value="VIE" @if($picks[0]['day']=='VIE') selected="selected" @endif >Viernes</option>
                            <option value="SAB" @if($picks[0]['day']=='SAB') selected="selected" @endif >Sábado</option>
                            <option value="DOM" @if($picks[0]['day']=='DOM') selected="selected" @endif >Domingo</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-4">
                    @if($picks[0]['day']=='')
                        <div class="bfh-timepicker" data-time="15:00" data-name="start1"></div>
                    @else
                        <div class="bfh-timepicker" data-time="{{ substr($picks[0]['start'],0,-3) }}" data-name="start1"></div>
                    @endif
                </div>
                <div class="col-xs-4">
                    @if($picks[0]['day']=='')
                        <div class="bfh-timepicker" data-time="21:00" data-name="end1"></div>
                    @else
                        <div class="bfh-timepicker" data-time="{{ substr($picks[0]['end'],0,-3) }}" data-name="end1"></div>
                    @endif
                </div>

                <div class="col-xs-12 clear-left @if($n_picks_set>1) hidden @endif " id="avail-controls1">
                    <a href="#" id="avail-control-add1" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Añadir</a>
                </div>

                @for($i=2,$h=1;$i<9;++$i,++$h)
                    <div @if($i>$n_picks_set) class="hidden" @endif id="avail{{$i}}">
                        <div class="col-xs-4 clear-left">
                            <div class="form-group">
                                <select class="form-control" id="day{{$i}}" name="day{{$i}}">
                                    <option value="" @if($picks[$h]['day']=='') selected="selected" @endif > </option>
                                    <option value="LUN" @if($picks[$h]['day']=='LUN') selected="selected" @endif >Lunes</option>
                                    <option value="MAR" @if($picks[$h]['day']=='MAR') selected="selected" @endif >Martes</option>
                                    <option value="MIER" @if($picks[$h]['day']=='MIER') selected="selected" @endif >Miércoles</option>
                                    <option value="JUE" @if($picks[$h]['day']=='JUE') selected="selected" @endif >Jueves</option>
                                    <option value="VIE" @if($picks[$h]['day']=='VIE') selected="selected" @endif >Viernes</option>
                                    <option value="SAB" @if($picks[$h]['day']=='SAB') selected="selected" @endif >Sábado</option>
                                    <option value="DOM" @if($picks[$h]['day']=='DOM') selected="selected" @endif >Domingo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            @if($picks[$h]['day']=='')
                                <div class="bfh-timepicker" data-time="15:00" data-name="start{{$i}}"></div>
                            @else
                                <div class="bfh-timepicker" data-time="{{ substr($picks[$h]['start'],0,-3) }}" data-name="start{{$i}}"></div>
                            @endif
                        </div>
                        <div class="col-xs-4">
                            @if($picks[$h]['day']=='')
                                <div class="bfh-timepicker" data-time="21:00" data-name="end{{$i}}"></div>
                            @else
                                <div class="bfh-timepicker" data-time="{{ substr($picks[$h]['end'],0,-3) }}" data-name="end{{$i}}"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 @if(!($i==$n_picks_set)) hidden @endif clear-left" id="avail-controls{{$i}}">
                        <a href="#" id="avail-control-add{{$i}}" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Añadir</a> <a href="#" id="avail-control-del{{$i}}" class="btn btn-default"><i class="glyphicon glyphicon-minus-sign"></i> Eliminar</a>
                    </div>
                @endfor

                <div @if(9>$n_picks_set) class="hidden" @endif id="avail9">
                    <div class="col-xs-4 clear-left">
                        <div class="form-group">
                            <select class="form-control" id="day9" name="day9">
                                <option value="" @if($picks[8]['day']=='') selected="selected" @endif > </option>
                                <option value="LUN" @if($picks[8]['day']=='LUN') selected="selected" @endif >Lunes</option>
                                <option value="MAR" @if($picks[8]['day']=='MAR') selected="selected" @endif >Martes</option>
                                <option value="MIER" @if($picks[8]['day']=='MIER') selected="selected" @endif >Miércoles</option>
                                <option value="JUE" @if($picks[8]['day']=='JUE') selected="selected" @endif >Jueves</option>
                                <option value="VIE" @if($picks[8]['day']=='VIE') selected="selected" @endif >Viernes</option>
                                <option value="SAB" @if($picks[8]['day']=='SAB') selected="selected" @endif >Sábado</option>
                                <option value="DOM" @if($picks[8]['day']=='DOM') selected="selected" @endif >Domingo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        @if($picks[8]['day']=='')
                            <div class="bfh-timepicker" data-time="15:00" data-name="start9"></div>
                        @else
                            <div class="bfh-timepicker" data-time="{{ substr($picks[8]['start'],0,-3) }}" data-name="start9"></div>
                        @endif
                    </div>
                    <div class="col-xs-4">
                        @if($picks[8]['day']=='')
                            <div class="bfh-timepicker" data-time="21:00" data-name="end9"></div>
                        @else
                            <div class="bfh-timepicker" data-time="{{ substr($picks[8]['end'],0,-3) }}" data-name="end9"></div>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 @if(!($n_picks_set==9)) hidden @endif clear-left" id="avail-controls9">
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
                <input type="submit" value="Guardar cambios" class="btn btn-primary"/>
                <a href="{{ url('admin/lessons',$school->id) }}" class="btn btn-link">Cancelar</a>
            </div>
        </div>

    </form>

</div>

@stop