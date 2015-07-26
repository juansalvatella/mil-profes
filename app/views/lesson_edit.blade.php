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
        <h1>@lang('course_edit.edit_course_of') {{ $school->name }}</h1>
    </div>
    <form class="form-horizontal" action="{{ action('AdminController@saveLesson') }}" method="post" role="form">
        <input type="hidden" name="_token" value="{{ Session::getToken() }}">
        <input type="hidden" name="school_id" value="{{ $school->id }}">
        <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="title">@lang('forms.new_course.title')</label>
            <div class="col-sm-10">
                <input type="text" placeholder="@lang('forms.new_course.title-ph')" class="form-control" name="title" id="title" value="{{{ $lesson->title }}}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="price">@lang('forms.new_course.price')</label>
            <div class="col-sm-10">
                <input type="text" placeholder="@lang('forms.new_course.price-ph')" class="form-control" name="price" id="price" value="{{ $lesson->price }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="address">@lang('forms.new_course.where')</label>
            <div class="col-sm-10">
                <input type="text" placeholder="@lang('forms.new_course.where-ph')" class="form-control" name="address" id="address" value="{{ $lesson->address }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="subject">@lang('subjects.subject')</label>
            <div class="col-sm-10">
                <select class="form-control" id="subject" name="subject">
                    @foreach(Subject::all() as $subj)
                        <option value="{{ $subj->name }}" @if($subject->name == $subj->name) selected="selected" @endif>@lang('subjects.'.$subj->name)</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">@lang('forms.new_course.description')</label>
            <div class="col-sm-10">
                <textarea rows="3" class="form-control" name="description" id="description">{{ $lesson->description }}</textarea>
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
                            <option value="" @if($picks[0]['day']=='') selected="selected" @endif > </option>
                            <option value="@lang('forms.common.monday-tag')" @if($picks[0]['day']==Lang::get('forms.common.monday-tag')) selected="selected" @endif >@lang('forms.common.monday')</option>
                            <option value="@lang('forms.common.tuesday-tag')" @if($picks[0]['day']==Lang::get('forms.common.tuesday-tag')) selected="selected" @endif >@lang('forms.common.tuesday')</option>
                            <option value="@lang('forms.common.wednesday-tag')" @if($picks[0]['day']==Lang::get('forms.common.wednesday-tag')) selected="selected" @endif >@lang('forms.common.wednesday')</option>
                            <option value="@lang('forms.common.thursday-tag')" @if($picks[0]['day']==Lang::get('forms.common.thursday-tag')) selected="selected" @endif >@lang('forms.common.thursday')</option>
                            <option value="@lang('forms.common.friday-tag')" @if($picks[0]['day']==Lang::get('forms.common.friday-tag')) selected="selected" @endif >@lang('forms.common.friday')</option>
                            <option value="@lang('forms.common.saturday-tag')" @if($picks[0]['day']==Lang::get('forms.common.saturday-tag')) selected="selected" @endif >@lang('forms.common.saturday')</option>
                            <option value="@lang('forms.common.sunday-tag')" @if($picks[0]['day']==Lang::get('forms.common.sunday-tag')) selected="selected" @endif >@lang('forms.common.sunday')</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-4">
                    @if($picks[0]['day']=='')
                        <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_start_time')" data-name="start1"></div>
                    @else
                        <div class="bfh-timepicker background-white" data-time="{{ substr($picks[0]['start'],0,-3) }}" data-name="start1"></div>
                    @endif
                </div>
                <div class="col-xs-4">
                    @if($picks[0]['day']=='')
                        <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_end_time')" data-name="end1"></div>
                    @else
                        <div class="bfh-timepicker background-white" data-time="{{ substr($picks[0]['end'],0,-3) }}" data-name="end1"></div>
                    @endif
                </div>

                <div class="col-xs-12 clear-left @if($n_picks_set>1) hidden @endif " id="avail-controls1">
                    <a href="#" id="avail-control-add1" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> @lang('buttons.add')</a>
                </div>

                @for($i=2,$h=1;$i<9;++$i,++$h)
                    <div @if($i>$n_picks_set) class="hidden" @endif id="avail{{$i}}">
                        <div class="col-xs-4 clear-left">
                            <div class="form-group">
                                <select class="form-control" id="day{{$i}}" name="day{{$i}}">
                                    <option value="" @if($picks[$h]['day']=='') selected="selected" @endif > </option>
                                    <option value="@lang('forms.common.monday-tag')" @if($picks[$h]['day']==Lang::get('forms.common.monday-tag')) selected="selected" @endif >@lang('forms.common.monday')</option>
                                    <option value="@lang('forms.common.tuesday-tag')" @if($picks[$h]['day']==Lang::get('forms.common.tuesday-tag')) selected="selected" @endif >@lang('forms.common.tuesday')</option>
                                    <option value="@lang('forms.common.wednesday-tag')" @if($picks[$h]['day']==Lang::get('forms.common.wednesday-tag')) selected="selected" @endif >@lang('forms.common.wednesday')</option>
                                    <option value="@lang('forms.common.thursday-tag')" @if($picks[$h]['day']==Lang::get('forms.common.thursday-tag')) selected="selected" @endif >@lang('forms.common.thursday')</option>
                                    <option value="@lang('forms.common.friday-tag')" @if($picks[$h]['day']==Lang::get('forms.common.friday-tag')) selected="selected" @endif >@lang('forms.common.friday')</option>
                                    <option value="@lang('forms.common.saturday-tag')" @if($picks[$h]['day']==Lang::get('forms.common.saturday-tag')) selected="selected" @endif >@lang('forms.common.saturday')</option>
                                    <option value="@lang('forms.common.sunday-tag')" @if($picks[$h]['day']==Lang::get('forms.common.sunday-tag')) selected="selected" @endif >@lang('forms.common.sunday')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            @if($picks[$h]['day']=='')
                                <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_start_time')" data-name="start{{$i}}"></div>
                            @else
                                <div class="bfh-timepicker background-white" data-time="{{ substr($picks[$h]['start'],0,-3) }}" data-name="start{{$i}}"></div>
                            @endif
                        </div>
                        <div class="col-xs-4">
                            @if($picks[$h]['day']=='')
                                <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_end_time')" data-name="end{{$i}}"></div>
                            @else
                                <div class="bfh-timepicker background-white" data-time="{{ substr($picks[$h]['end'],0,-3) }}" data-name="end{{$i}}"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 @if(!($i==$n_picks_set)) hidden @endif clear-left" id="avail-controls{{$i}}">
                        <a href="#" id="avail-control-add{{$i}}" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> @lang('buttons.add')</a> <a href="#" id="avail-control-del{{$i}}" class="btn btn-default"><i class="glyphicon glyphicon-minus-sign"></i> @lang('buttons.delete')</a>
                    </div>
                @endfor

                <div @if(9>$n_picks_set) class="hidden" @endif id="avail9">
                    <div class="col-xs-4 clear-left">
                        <div class="form-group">
                            <select class="form-control" id="day9" name="day9">
                                <option value="" @if($picks[8]['day']=='') selected="selected" @endif > </option>
                                <option value="@lang('forms.common.monday-tag')" @if($picks[8]['day']==Lang::get('forms.common.monday-tag')) selected="selected" @endif >@lang('forms.common.monday')</option>
                                <option value="@lang('forms.common.tuesday-tag')" @if($picks[8]['day']==Lang::get('forms.common.tuesday-tag')) selected="selected" @endif >@lang('forms.common.tuesday')</option>
                                <option value="@lang('forms.common.wednesday-tag')" @if($picks[8]['day']==Lang::get('forms.common.wednesday-tag')) selected="selected" @endif >@lang('forms.common.wednesday')</option>
                                <option value="@lang('forms.common.thursday-tag')" @if($picks[8]['day']==Lang::get('forms.common.thursday-tag')) selected="selected" @endif >@lang('forms.common.thursday')</option>
                                <option value="@lang('forms.common.friday-tag')" @if($picks[8]['day']==Lang::get('forms.common.friday-tag')) selected="selected" @endif >@lang('forms.common.friday')</option>
                                <option value="@lang('forms.common.saturday-tag')" @if($picks[8]['day']==Lang::get('forms.common.saturday-tag')) selected="selected" @endif >@lang('forms.common.saturday')</option>
                                <option value="@lang('forms.common.sunday-tag')" @if($picks[8]['day']==Lang::get('forms.common.sunday-tag')) selected="selected" @endif >@lang('forms.common.sunday')</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        @if($picks[8]['day']=='')
                            <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_start_time')" data-name="start9"></div>
                        @else
                            <div class="bfh-timepicker background-white" data-time="{{ substr($picks[8]['start'],0,-3) }}" data-name="start9"></div>
                        @endif
                    </div>
                    <div class="col-xs-4">
                        @if($picks[8]['day']=='')
                            <div class="bfh-timepicker background-white" data-time="@lang('forms.new_course.default_end_time')" data-name="end9"></div>
                        @else
                            <div class="bfh-timepicker background-white" data-time="{{ substr($picks[8]['end'],0,-3) }}" data-name="end9"></div>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 @if(!($n_picks_set==9)) hidden @endif clear-left" id="avail-controls9">
                    <a href="#" id="avail-control-del9" class="btn btn-default"><i class="glyphicon glyphicon-minus-sign"></i> @lang('buttons.delete')</a>
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 text-right">
                <input type="submit" value="@lang('buttons.save_changes')" class="btn btn-primary"/>
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
