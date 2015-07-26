@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')

@endsection

@section('content')

    <div class="container top-buffer-15 bottom-buffer-45">

    <div class="page-header">
        <h1>@lang('course_create.new_course_of') {{ $school->name }}</h1>
    </div>

    <form class="form-horizontal" action="{{ action('AdminController@createLesson') }}" method="post" role="form">
        <input type="hidden" name="_token" value="{{ Session::getToken() }}">
        <input type="hidden" name="school_id" value="{{ $school->id }}">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="title">@lang('forms.new_course.title')</label>
            <div class="col-sm-10">
                <input type="text" placeholder="@lang('forms.new_course.title-ph')" class="form-control" name="title" id="title" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="price">@lang('forms.new_course.price')</label>
            <div class="col-sm-10">
                <input type="text" placeholder="@lang('forms.new_course.price-ph')" class="form-control" name="price" id="price"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="address">@lang('forms.new_course.where')</label>
            <div class="col-sm-10">
                <input type="text" placeholder="@lang('forms.new_course.where-ph')" class="form-control" name="address" id="address" value="{{ $school->address }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="subject">@lang('subjects.subject')</label>
            <div class="col-sm-10">
                <select class="form-control" id="subject" name="subject">
                    <?php $k = 0; ?>
                    @foreach(Subject::all() as $subj)
                        <option value="{{ $subj->name }}" @if($k==0) selected="selected" @endif>@lang('subjects.'.$subj->name)</option>
                        <?php ++$k; ?>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">@lang('forms.new_course.description')</label>
            <div class="col-sm-10">
                <textarea rows="2" class="form-control" name="description" id="description"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="day1">@lang('forms.new_course.schedule')</label>
            <div class="col-sm-10">

                <div class="col-xs-4">@lang('forms.common.day')</div>
                <div class="col-xs-4">@lang('forms.common.from')</div>
                <div class="col-xs-4">@lang('forms.common.to')</div>

                <div class="col-xs-4 clear-left">
                    <div class="form-group">
                        <select class="form-control" id="day1" name="day1">
                            <option value="" selected="selected"> </option>
                            <option value="@lang('forms.common.monday-tag')">@lang('forms.common.monday')</option>
                            <option value="@lang('forms.common.tuesday-tag')">@lang('forms.common.tuesday')</option>
                            <option value="@lang('forms.common.wednesday-tag')">@lang('forms.common.wednesday')</option>
                            <option value="@lang('forms.common.thursday-tag')">@lang('forms.common.thursday')</option>
                            <option value="@lang('forms.common.friday-tag')">@lang('forms.common.friday')</option>
                            <option value="@lang('forms.common.saturday-tag')">@lang('forms.common.saturday')</option>
                            <option value="@lang('forms.common.sunday-tag')">@lang('forms.common.sunday')</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_start_time')" data-name="start1"></div>
                </div>
                <div class="col-xs-4">
                    <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_end_time')" data-name="end1"></div>
                </div>

                <div class="col-xs-12 clear-left" id="avail-controls1">
                    <a href="#" id="avail-control-add1" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> @lang('buttons.add')</a>
                </div>

                @for($i=2,$h=1;$i<9;++$i,++$h)
                    <div class="hidden" id="avail{{$i}}">
                        <div class="col-xs-4 clear-left">
                            <div class="form-group">
                                <select class="form-control" id="day{{$i}}" name="day{{$i}}">
                                    <option value="" selected="selected"> </option>
                                    <option value="@lang('forms.common.monday-tag')">@lang('forms.common.monday')</option>
                                    <option value="@lang('forms.common.tuesday-tag')">@lang('forms.common.tuesday')</option>
                                    <option value="@lang('forms.common.wednesday-tag')">@lang('forms.common.wednesday')</option>
                                    <option value="@lang('forms.common.thursday-tag')">@lang('forms.common.thursday')</option>
                                    <option value="@lang('forms.common.friday-tag')">@lang('forms.common.friday')</option>
                                    <option value="@lang('forms.common.saturday-tag')">@lang('forms.common.saturday')</option>
                                    <option value="@lang('forms.common.sunday-tag')">@lang('forms.common.sunday')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_start_time')" data-name="start{{$i}}"></div>
                        </div>
                        <div class="col-xs-4">
                            <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_end_time')" data-name="end{{$i}}"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 hidden clear-left" id="avail-controls{{$i}}">
                        <a href="#" id="avail-control-add{{$i}}" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> @lang('buttons.add')</a> <a href="#" id="avail-control-del{{$i}}" class="btn btn-default"><i class="glyphicon glyphicon-minus-sign"></i> @lang('buttons.delete')</a>
                    </div>
                @endfor

                <div class="hidden" id="avail9">
                    <div class="col-xs-4 clear-left">
                        <div class="form-group">
                            <select class="form-control" id="day9" name="day9">
                                <option value="" selected="selected"> </option>
                                <option value="@lang('forms.common.monday-tag')">@lang('forms.common.monday')</option>
                                <option value="@lang('forms.common.tuesday-tag')">@lang('forms.common.tuesday')</option>
                                <option value="@lang('forms.common.wednesday-tag')">@lang('forms.common.wednesday')</option>
                                <option value="@lang('forms.common.thursday-tag')">@lang('forms.common.thursday')</option>
                                <option value="@lang('forms.common.friday-tag')">@lang('forms.common.friday')</option>
                                <option value="@lang('forms.common.saturday-tag')">@lang('forms.common.saturday')</option>
                                <option value="@lang('forms.common.sunday-tag')">@lang('forms.common.sunday')</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_start_time')" data-name="start9"></div>
                    </div>
                    <div class="col-xs-4">
                        <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_end_time')" data-name="end9"></div>
                    </div>
                </div>
                <div class="col-xs-12 hidden clear-left" id="avail-controls9">
                    <a href="#" id="avail-control-del9" class="btn btn-default"><i class="glyphicon glyphicon-minus-sign"></i> @lang('buttons.delete')</a>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 text-right">
                <input type="submit" value="@lang('buttons.create')" class="btn btn-primary"/>
                <a href="{{ url('admin/lessons',$school->id) }}" class="btn btn-link">@lang('buttons.cancel')</a>
            </div>
        </div>

    </form>

</div>

@endsection

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function(){
            @for($i=1;$i<9;++$i)
            $(document).on("click","#avail-control-add{{$i}}",function(e){
                        e.preventDefault();
                        $("#avail"+"{{$i+1}}").removeClass("hidden");
                        $("#avail-controls"+"{{$i+1}}").removeClass("hidden");
                        $("#avail-controls"+"{{$i}}").addClass("hidden");
                    });

            $(document).on("click","#avail-control-del{{$i+1}}",function(e){
                e.preventDefault();
                $("#avail"+"{{$i+1}}").addClass("hidden");
                $("[name=day"+"{{$i+1}}]").val("");
                $("#avail-controls"+"{{$i}}").removeClass("hidden");
                $("#avail-controls"+"{{$i+1}}").addClass("hidden");
            });
            @endfor
        });
    </script>
@endsection
