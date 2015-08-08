{{--LOGIN MODAL--}}
<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body login-modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="row text-center bottom-srs-separator">
                    <span class="login-modal-logo">@lang('layout.logo')</span>
                </div>
                <div class="row">
                    <div class="col-xs-12 top-buffer-15">
                        <form role="form" method="POST" action="{{{ URL::to('/users/login') }}}" accept-charset="UTF-8" id="login-form">
                            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                            <fieldset>

                                @if(Session::has('log-success'))
                                    <div class="alert alert-success">{{{ Session::get('log-success') }}}</div>
                                @endif
                                @if(Session::has('log-error'))
                                    <div class="alert alert-error alert-danger">{{{ Session::get('log-error') }}}</div>
                                @endif
                                @if(Session::has('log-notice'))
                                    <div class="alert">{{{ Session::get('log-notice') }}}</div>
                                @endif
                                <div id="dynalert" class="alert alert-warning hidden"></div>

                                <div class="form-group">
                                    <label for="email">@lang('layout.login-username')</label>
                                    <input class="form-control" tabindex="1" placeholder="@lang('layout.login-username')" type="text" name="email" id="email" value="{{{ Input::old('email') }}}" required="required" data-error="Rellena este campo.">
                                    <small><span class="help-block with-errors"></span></small>
                                </div>
                                <div class="form-group">
                                    <label for="password">
                                        @lang('layout.login-password')
                                    </label>
                                    <input class="form-control" tabindex="2" placeholder="@lang('layout.login-password')" type="password" name="password" id="password" required="required" data-error="Rellena este campo.">
                                    <small><span class="help-block with-errors"></span></small>
                                    <p class="help-block">
                                        <a href="{{{ URL::to('/users/forgot-password') }}}">@lang('layout.login-forgot-passwd')</a>
                                    </p>
                                </div>
                                <div class="checkbox">
                                    <label for="remember">
                                        <input tabindex="3" type="checkbox" name="remember" id="remember" value="1"><small>@lang('layout.login-remind-me')</small>
                                    </label>
                                </div>

                                <div class="row text-center top-buffer-15">
                                    <div class="form-group">
                                        <button tabindex="4" type="submit" class="btn btn-login-send">@lang('layout.login-send')</button>
                                        <button tabindex="5" type="button" class="btn btn-login-send" data-dismiss="modal">@lang('layout.login-cancel')</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--REGISTER MODAL--}}
<div class="modal fade" id="modal-register" tabindex="-1" role="dialog" aria-labelledby="modal-register" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body login-modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="row text-center bottom-srs-separator">
                    <span class="login-modal-logo">@lang('layout.logo')</span>
                </div>
                <div class="row">
                    <div class="col-xs-12 top-buffer-15">

                        <form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8" id="register-form">
                            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                            <fieldset>

                                @if(Session::has('reg-error'))
                                    @if(is_array(Session::get('reg-error')))
                                        <div class="alert alert-error alert-danger">
                                            {{ head(Session::get('reg-error')) }}
                                        </div>
                                    @else
                                        <div class="alert alert-error alert-danger">
                                            {{ Session::get('reg-error') }}
                                        </div>
                                    @endif
                                @endif
                                @if(Session::has('reg-failure'))
                                    <div class="alert alert-error alert-danger">
                                        {{ Session::get('reg-failure') }}
                                    </div>
                                @endif
                                @if(Session::has('reg-notice'))
                                    <div class="alert">{{ Session::get('reg-notice') }}</div>
                                @endif

                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="name">@lang('layout.register-realname')</label>
                                            <input class="form-control" placeholder="@lang('layout.register-realname-ph')" maxlength="50" type="text" name="name" id="name" value="{{{ Input::old('name') }}}" required="required" data-error="Rellena este campo.">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="lastname">@lang('layout.register-reallastname')</label>
                                            <input class="form-control" placeholder="@lang('layout.register-reallastname-ph')" maxlength="100" type="text" name="lastname" id="lastname" value="{{{ Input::old('lastname') }}}">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="address">@lang('layout.register-address')</label>
                                            <input class="form-control" placeholder="@lang('layout.register-address-ph')" maxlength="200" type="text" name="address" id="address" value="{{{ Input::old('address') }}}" required="required" data-error="Rellena este campo.">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="phone">@lang('layout.register-phone')</label>
                                            <input class="form-control" placeholder="@lang('layout.register-phone-ph')" type="text" pattern="^([0-9]){5,}$" maxlength="20" name="phone" id="phone" value="{{{ Input::old('phone') }}}" data-error="Sólo números, sin espacios.">
                                            <small><span class="help-block with-errors">Sólo números, sin espacios</span></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="username">@lang('layout.register-username')</label>
                                            <input class="form-control" placeholder="@lang('layout.register-username-ph') " pattern="^([_A-z0-9]){5,}$" maxlength="20" type="text" name="username" id="username" value="{{{ Input::old('username') }}}" required="required" data-error="Al menos 5 caracteres con letras o números.">
                                            <small><span class="help-block with-errors">Mínimo 5 caracters (letras, números, guion bajo)</span></small>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="email">@lang('layout.register-email') <small>@lang('layout.register-required-confirmation')</small></label>
                                            <input class="form-control" placeholder="@lang('layout.register-email-ph') " type="email" name="email" id="email2" value="{{{ Input::old('email') }}}" required="required" data-error="Introduce una dirección de correo válida.">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="password">@lang('layout.register-password')</label>
                                            <input class="form-control register-password" placeholder="@lang('layout.register-password-ph')" type="password" pattern=".{6,}" name="password" id="password2" required="required" data-error="Al menos 6 caracteres de longitud.">
                                            <small><span class="help-block with-errors">Mínimo 6 de longitud</span></small>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">@lang('layout.register-confirm-password')</label>
                                            <input class="form-control" placeholder="@lang('layout.register-confirm-password-ph')" type="password" data-match=".register-password" name="password_confirmation" id="password_confirmation" required="required" data-error="Rellena este campo." data-match-error="No coincide.">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input value="1" type="checkbox" name="terms" id="terms" data-error="Debes aceptar las condiciones de uso para registrarte" required="required">
                                                He leído y acepto las <a target="_blank" href="{{url('condiciones')}}">@lang('layout.register_user-terms')</a>
                                            </label>
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row text-center top-buffer-15">
                                    <div class="form-group">
                                        <button id="register-submit-button" tabindex="3" type="submit" class="btn btn-login-send">@lang('layout.register-register')</button>
                                        <button id="register-cancel-button" type="button" class="btn btn-login-send" data-dismiss="modal">@lang('layout.register-cancel')</button>
                                    </div>
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
