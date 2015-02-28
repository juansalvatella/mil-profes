@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div class="generic-title"><h3>Restablecer contraseña</h3></div>

            <div class="generic-subtitle">Introduce tu dirección de correo electrónico</div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-150 magic-align">
            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-6">

            <form method="POST" class="form-horizontal" action="{{ URL::to('/users/forgot_password') }}" accept-charset="UTF-8" id="forgot-form">
                <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="email">E-mail:</label>

                        <input class="form-control top-buffer-5" placeholder="Tu e-mail" type="email" name="email" id="email" value="{{{ Input::old('email') }}}" required="required">
                        <div class="help-block with-errors">&nbsp;</div>

                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <span class="input-group-btn">
                            <input class="btn btn-primary" type="submit" value="{{{ @trans('messages.forgot.submit') }}}">
                        </span>
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
                    $("#forgot-form").validator();
                });
            </script>

            </div>
        </div>
    </div>
    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

@endsection