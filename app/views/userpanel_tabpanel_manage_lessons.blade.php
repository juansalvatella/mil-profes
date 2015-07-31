<div class="container-fluid top-padding-25 bottom-padding-25">
    <div class="panel panel-milprofes">
        <div class="panel-heading">
            <h3 class="panel-title">Tu disponibilidad semanal</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{ action("TeachersController@saveAvailability") }}" method="post" role="form" id="availabilityForm">
                <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                <div class="col-xs-4">@lang('forms.common.day')</div>
                <div class="col-xs-4">@lang('forms.common.from')</div>
                <div class="col-xs-4">@lang('forms.common.to')</div>
                <div class="container-fluid" id="avails-container">
                    @for($i=1;$i<10;++$i)
                    <div class="row availability @if($picks[$i-1]["day"]=="") hidden @endif" data-pos="{{$i}}">
                        <div class="col-xs-4 clear-left">
                            <div class="form-group">
                                <select class="form-control" name="day{{$i}}">
                                    <option value="" @if($picks[$i-1]["day"]=="") selected="selected" @endif>&nbsp; </option>
                                    <option value="@lang('forms.common.monday-tag')" @if($picks[$i-1]["day"]==trans('forms.common.monday-tag')) selected="selected" @endif>@lang('forms.common.monday')</option>
                                    <option value="@lang('forms.common.tuesday-tag')" @if($picks[$i-1]["day"]==trans('forms.common.tuesday-tag')) selected="selected" @endif>@lang('forms.common.tuesday')</option>
                                    <option value="@lang('forms.common.wednesday-tag')" @if($picks[$i-1]["day"]==trans('forms.common.wednesday-tag')) selected="selected" @endif>@lang('forms.common.wednesday')</option>
                                    <option value="@lang('forms.common.thursday-tag')" @if($picks[$i-1]["day"]==trans('forms.common.thursday-tag')) selected="selected" @endif>@lang('forms.common.thursday')</option>
                                    <option value="@lang('forms.common.friday-tag')" @if($picks[$i-1]["day"]==trans('forms.common.friday-tag')) selected="selected" @endif>@lang('forms.common.friday')</option>
                                    <option value="@lang('forms.common.saturday-tag')" @if($picks[$i-1]["day"]==trans('forms.common.saturday-tag')) selected="selected" @endif>@lang('forms.common.saturday')</option>
                                    <option value="@lang('forms.common.sunday-tag')" @if($picks[$i-1]["day"]==trans('forms.common.sunday-tag')) selected="selected" @endif>@lang('forms.common.sunday')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                        @if($picks[$i-1]["day"]=="")
                            <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_start_time')" data-name="start{{$i}}"></div>
                        @else
                            <div class="bfh-timepicker background-white" data-time="{{ substr($picks[$i-1]["start"],0,-3) }}" data-name="start{{$i}}"></div>
                        @endif
                        </div>
                        <div class="col-xs-4">
                        @if($picks[$i-1]["day"]=="")
                            <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_end_time')" data-name="end{{$i}}"></div>
                        @else
                            <div class="bfh-timepicker background-white" data-time="{{ substr($picks[$i-1]["end"],0,-3) }}" data-name="end{{$i}}"></div>
                        @endif
                        </div>
                    </div>
                    @endfor
                </div>
                <div class="col-xs-12 clear-left" id="avail-controls">
                    <a href="#" id="avail-control-add" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> @lang('buttons.add')</a>
                    <a href="#" id="avail-control-del" class="btn btn-default hidden"><i class="glyphicon glyphicon-minus-sign"></i> @lang('buttons.delete')</a>
                </div>
                <div class="col-xs-12 top-buffer-10">
                    <button type="submit" class="btn btn-primary pull-right">
                        <i class="fa fa-save"></i> Guardar cambios
                    </button>
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
                            <th class="hidden-xs">Categoría</th>
                            <th class="min-width-150">Título</th>
                            <th class="hidden-xs">Descripción</th>
                            <th class="hidden-xs">Precio<br>(€/hora)</th>
                            <th class="min-width-115-300">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($lessons as $lesson)
                        <tr>
                            <td class="hidden-xs"><img width="42" title="@lang("subjects.".$subjects[$lesson->id]->name)" alt="@lang("subjects.".$subjects[$lesson->id]->name)" src="{{ asset("img/subjects/".$subjects[$lesson->id]->id.".png") }}"/></td>
                            <td>{{{ $lesson->title }}}</td>
                            <td class="hidden-xs">{{{ $lesson->description }}}</td>
                            {{-- + 0 removes zeros to the right of the decimal separator --}}
                            <td class="hidden-xs">@if($lesson->price!=0.0) {{{ str_replace(".", ",", $lesson->price + 0) }}} @else Sin precio @endif</td>
                            <td>
                                <a href="{{ url("teacher/edit/lesson",array($lesson->id)) }}" class="btn btn-default bottom-buffer-5"><i class="fa fa-edit"></i><span class="hidden-xs hidden-sm"> @lang("buttons.edit")</span></a>
                                &nbsp;
                                <a href="{{ url("teacher/delete/lesson",array($lesson->id)) }}" class="btn btn-danger bottom-buffer-5"><i class="fa fa-trash-o"></i><span class="hidden-xs hidden-sm">  @lang("buttons.delete")</span></a>
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
                <a href="{{ url("teacher/create/lesson") }}" class="btn btn-primary pull-right top-buffer-10">
                    <i class="fa fa-plus"></i> Nueva clase
                </a>
            </div>
        </div>
    </div>
</div>
