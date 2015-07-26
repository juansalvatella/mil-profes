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
            <div><h1 class="generic-title">@lang('forgot_password.title')</h1></div>
            <div><h2 class="generic-subtitle">@lang('forgot_password.subtitle')</h2></div>
        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-150 magic-align">
            <div class="row">
                <div class="col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-6">
                    <form method="POST" class="form-horizontal" action="{{ URL::to('/users/forgot-password') }}" accept-charset="UTF-8" id="forgot-form">
                        <input type="hidden" name="_token" value="{{ Session::getToken() }}">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="email">@lang('forms.forgot.email')</label>
                                <input class="form-control top-buffer-5" placeholder="@lang('forms.forgot.email-ph')" type="email" name="email" id="email" value="{{{ Input::old('email') }}}" required="required" data-error="@lang('forms.forgot.email-err')">
                                <div class="help-block with-errors">&nbsp;</div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <span class="input-group-btn">
                                    <input class="btn btn-primary" type="submit" value="@lang('buttons.continue')">
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
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
            $("#forgot-form").validator();
        });
    </script>
@endsection
