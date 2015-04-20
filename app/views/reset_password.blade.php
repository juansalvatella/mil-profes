@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div><h1 class="generic-title">Nueva contraseña</h1></div>

            <div><h2 class="generic-subtitle">Introduce tu nueva contraseña</h2></div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-150 magic-align">
            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">

                <form method="POST" class="form-horizontal" action="{{{ URL::to('/users/reset-password') }}}" accept-charset="UTF-8" id="reset-form">
                    <input type="hidden" name="token" value="{{{ $token }}}">
                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                    <div class="col-xs-12 col-sm-6">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
                                <input class="form-control reset-password" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password" required="required" pattern=".{6,}" data-error="Introduce una contraseña de al menos 6 caracteres.">
                                <span class="help-block with-errors">Mínimo 6 caracteres de longitud</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
                                <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation" required="required" data-match=".reset-password" data-error="Rellena este campo." data-match-error="No coincide.">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-12">
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.forgot.submit') }}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">

                        @if (Session::get('error'))
                            <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
                        @endif

                        @if (Session::get('notice'))
                            <div class="alert">{{{ Session::get('notice') }}}</div>
                        @endif
                    </div>

                </form>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#reset-form").validator();
                    });
                </script>

            </div>
        </div>
    </div>
    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

@endsection