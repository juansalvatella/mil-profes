@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')

@endsection

@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div><h1 class="generic-title">@lang('lesson_edit.title')</h1></div>

            <div><h2 class="generic-subtitle">@lang('lesson_edit.subtitle')</h2></div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-150 magic-align">

            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">

                <form class="form-horizontal" action="{{ action('TeachersController@saveLesson') }}" method="post" role="form" id="edit-l-form">
                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                    <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="title">@lang('forms.new_lesson.title') (*)</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="@lang('forms.new_lesson.title-ph')" class="form-control" name="title" id="title" required="required" data-error="@lang('forms.new_lesson.title-error')" maxlength="50" value="{{{ $lesson->title }}}"  />
                            <div class="help-block with-errors">@lang('forms.new_lesson.title-helper')</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="subject">@lang('forms.new_lesson.subject') (*)</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="subject" name="subject">
                            @foreach(Subject::all() as $subj)
                                <option value="{{ $subj->name }}" @if($subject->name == $subj->name) selected="selected" @endif>@lang('subjects.'.$subj->name)</option>
                            @endforeach
                            </select>
                            <input type="hidden" class="form-control">
                            <div class="help-block with-errors">@lang('forms.new_lesson.subject-helper')</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="price">@lang('forms.new_lesson.price')</label>
                        <div class="col-sm-10">
                            <input type="text" pattern="^([0-9\.,]){0,}$" class="form-control" name="price" id="price" placeholder="@lang('forms.new_lesson.price-ph')"  value="{{ $lesson->price }}" data-error="@lang('forms.new_lesson.price-error')" />
                            <div class="help-block with-errors">@lang('forms.new_lesson.price-helper')</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="address">@lang('forms.new_lesson.where') (*)</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="@lang('forms.new_lesson.where-ph')" class="form-control" name="address" id="address" value="{{ $lesson->address }}" required="required" data-error="@lang('forms.new_lesson.where-error')"/>
                            <div class="help-block with-errors">@lang('forms.new_lesson.where-helper')</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="description">@lang('forms.new_lesson.description') (*)</label>
                        <div class="col-sm-10">
                            <textarea rows="2" class="form-control" name="description" id="description" placeholder="@lang('forms.new_lesson.description-ph')" required="required" maxlength="200" data-error="@lang('forms.new_lesson.description-error')">{{ $lesson->description }}</textarea>
                            <div class="help-block with-errors">@lang('forms.new_lesson.description-helper')</div>
                            <div id="chars_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="@lang('buttons.save_changes')" class="btn btn-primary"/>
                            <a href="{{ route('userpanel.dashboard') }}" class="btn btn-link">@lang('buttons.cancel')</a>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>

    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

@endsection

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function(){
            TeacherLessonEdit.init();
        });
    </script>
@endsection
