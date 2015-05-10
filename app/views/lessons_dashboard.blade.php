@extends('layout')
@section('content')
<div class="container top-buffer-15 bottom-buffer-45">
    <div class="page-header">
        <h1>@lang('course_dashboard.course_editor') <small>{{ $school->name }}</small></h1>
    </div>

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @elseif(Session::has('failure'))
        <div class="alert alert-warning" role="alert">{{ Session::get('failure') }}</div>
    @endif

    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ url('admin/create/lesson',array($school->id)) }}" class="btn btn-primary">@lang('buttons.new_course')</a>
        </div>
    </div>

    @if ($lessons->isEmpty())
        <p>@lang('course_dashboard.no_courses')</p>
    @else
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>@lang('forms.new_course.title')</th>
                    <th class="hidden-xs">@lang('forms.new_course.price')</th>
                    <th class="hidden-xs">@lang('forms.new_course.description')</th>
                    <th class="hidden-xs">@lang('subjects.subject')</th>
                    <th class="min-width-300">@lang('forms.common.actions')</th>
                </tr>
            </thead>
            <tbody>
            @foreach($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->title }}</td>
                    <td class="hidden-xs">{{ $lesson->price }}</td>
                    <td class="hidden-xs">{{ $lesson->description }}</td>
                    <td class="hidden-xs">{{ $subjects[$lesson->id]->name }}</td>
                    <td>
                        <a href="{{ url('admin/edit/lesson',array($lesson->id)) }}" class="btn btn-default"><i class="fa fa-edit"></i><span class="hidden-xs"> @lang('buttons.edit_course')</span></a>
                        &nbsp;
                        <a href="{{ url('admin/delete/lesson',array($lesson->id)) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i><span class="hidden-xs">  @lang('buttons.delete_course')</span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="panel panel-default">
            <div class="panel-body">
                <p>{{ count($lessons) }} @choice('course_dashboard.courses_in_total', count($lessons))</p>
            </div>
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-body">
            <a style="float:right;" href="{{ url('admin/schools') }}" class="btn btn-info">@lang('buttons.back_to_schools')</a>
        </div>
    </div>
</div>
@stop