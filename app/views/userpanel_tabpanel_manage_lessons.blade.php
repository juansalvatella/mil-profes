<div class="container-fluid top-padding-25 bottom-padding-25">
    <div class="panel panel-milprofes">
        <div class="panel-heading">
            <h3 class="panel-title">Tu disponibilidad semanal</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{ action('TeachersController@saveAvailability') }}" method="post" role="form" id="availabilityForm">

                <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                <div class="col-xs-12 col-sm-12 col-md-4">Día</div>
                <div class="col-xs-12 col-sm-12 hidden-sm hidden-xs col-md-4">De</div>
                <div class="col-xs-12 col-sm-12 hidden-xs hidden-sm col-md-4">a</div>

                <div class="col-xs-12 col-sm-12 col-md-4 clear-left">
                    <div class="">
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
                <div class="col-xs-12 col-sm-12 hidden-md hidden-lg">De</div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    @if($picks[0]['day']=='')
                        <div class="bfh-timepicker" data-time="15:00" data-name="start1"></div>
                    @else
                        <div class="bfh-timepicker" data-time="{{ substr($picks[0]['start'],0,-3) }}" data-name="start1"></div>
                    @endif
                </div>
                <div class="col-xs-12 col-sm-12 hidden-md hidden-lg">a</div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    @if($picks[0]['day']=='')
                        <div class="bfh-timepicker" data-time="21:00" data-name="end1"></div>
                    @else
                        <div class="bfh-timepicker" data-time="{{ substr($picks[0]['end'],0,-3) }}" data-name="end1"></div>
                    @endif
                </div>

                <div class="col-xs-12 clear-left @if($n_picks_set>1) hidden @endif top-buffer-10" id="avail-controls1">
                    <a href="#" id="avail-control-add1" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Añadir</a>
                </div>

                @for($i=2,$h=1;$i<9;++$i,++$h)
                    <div @if($i>$n_picks_set) class="hidden" @endif id="avail{{$i}}">
                        <div class="col-xs-12 col-sm-12 hidden-md hidden-lg top-buffer-15">Día</div>
                        <div class="hidden-xs hidden-sm col-md-12 col-lg-12 top-buffer-5"></div>
                        <div class="col-xs-12 col-sm-12 col-md-4 clear-left">
                            <div class="">
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
                        <div class="col-xs-12 col-sm-12 hidden-md hidden-lg">De</div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            @if($picks[$h]['day']=='')
                                <div class="bfh-timepicker" data-time="15:00" data-name="start{{$i}}"></div>
                            @else
                                <div class="bfh-timepicker" data-time="{{ substr($picks[$h]['start'],0,-3) }}" data-name="start{{$i}}"></div>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-12 hidden-md hidden-lg">a</div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            @if($picks[$h]['day']=='')
                                <div class="bfh-timepicker" data-time="21:00" data-name="end{{$i}}"></div>
                            @else
                                <div class="bfh-timepicker" data-time="{{ substr($picks[$h]['end'],0,-3) }}" data-name="end{{$i}}"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 @if(!($i==$n_picks_set)) hidden @endif clear-left top-buffer-10" id="avail-controls{{$i}}">
                        <a href="#" id="avail-control-add{{$i}}" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Añadir</a> <a href="#" id="avail-control-del{{$i}}" class="btn btn-default"><i class="glyphicon glyphicon-minus-sign"></i> Eliminar</a>
                    </div>
                @endfor

                    <div @if(9>$n_picks_set) class="hidden" @endif id="avail9">
                        <div class="col-xs-12 col-sm-12 hidden-md hidden-lg top-buffer-15">Día</div>
                        <div class="col-xs-12 col-sm-12 col-md-4 clear-left">
                            <div class="">
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
                        <div class="col-xs-12 col-sm-12 hidden-md hidden-lg">De</div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            @if($picks[8]['day']=='')
                                <div class="bfh-timepicker" data-time="15:00" data-name="start9"></div>
                            @else
                                <div class="bfh-timepicker" data-time="{{ substr($picks[8]['start'],0,-3) }}" data-name="start9"></div>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-12 hidden-md hidden-lg">a</div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            @if($picks[8]['day']=='')
                                <div class="bfh-timepicker" data-time="21:00" data-name="end9"></div>
                            @else
                                <div class="bfh-timepicker" data-time="{{ substr($picks[8]['end'],0,-3) }}" data-name="end9"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 top-buffer-10 @if(!($n_picks_set==9)) hidden @endif clear-left" id="avail-controls9">
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

                <div class="col-xs-12 top-buffer-10">
                    <input type="submit" value="Guardar cambios" class="btn btn-primary pull-right"/>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-milprofes">
        <div class="panel-heading">
            <h3 class="panel-title">Tus clases</h3>
        </div>
        <div class="panel-body">
            @if (!$lessons->isEmpty())
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="hidden-xs">Precio (€/hora)</th>
                        <th>Descripción</th>
                        <th class="hidden-xs">Categoría</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lessons as $lesson)
                        <tr>
                            <td class="hidden-xs">{{ $lesson->price }}</td>
                            <td>{{ $lesson->description }}</td>
                            <td class="hidden-xs">{{ $subjects[$lesson->id]->name }}</td>
                            <td>
                                <a href="{{ url('teacher/edit/lesson',array($lesson->id)) }}" class="btn btn-default bottom-buffer-5">Modificar detalles</a>
                                &nbsp;
                                <a href="{{ url('teacher/delete/lesson',array($lesson->id)) }}" class="btn btn-danger bottom-buffer-5">Eliminar clase</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
            <div class="clear-left col-xs-12">
            @if (!$lessons->isEmpty())
                <div class="pull-left">Tienes publicadas {{ count($lessons) }} clases</div>
            @else
                <div class="pull-left">Aún no tienes clases publicadas.</div>
            @endif
                <a href="{{ url('teacher/create/lesson') }}" class="btn btn-primary pull-right top-buffer-10">Nueva clase</a>
            </div>
        </div>
    </div>

</div>