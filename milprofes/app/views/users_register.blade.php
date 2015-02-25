@extends('layout')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8">
            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
            <fieldset>
                <div class="form-group">
                    <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
                </div>
                <div class="form-group">
                    <label for="name">Real name</label>
                    <input class="form-control" placeholder="Your name" type="text" name="name" id="name" value="">
                </div>
                <div class="form-group">
                    <label for="lastname">Real lastname</label>
                    <input class="form-control" placeholder="Your lastname" type="text" name="lastname" id="lastname" value="">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input class="form-control" placeholder="My street name and number, city" type="text" name="address" id="address" value="">
                </div>
                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input class="form-control" placeholder="Your contact phone number" type="text" name="phone" id="phone" value="">
                </div>
                <div class="form-group">
                    <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
                    <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
                </div>
                <div class="form-group">
                    <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
                </div>

                @if (Session::get('error'))
                    <div class="alert alert-error alert-danger">
                        @if (is_array(Session::get('error')))
                            {{ head(Session::get('error')) }}
                        @endif
                    </div>
                @endif

                @if (Session::get('failure'))
                    <div class="alert alert-error alert-danger">
                        {{ Session::get('failure') }}
                    </div>
                @endif

                @if (Session::get('notice'))
                    <div class="alert">{{ Session::get('notice') }}</div>
                @endif

                <div class="form-actions form-group">
                    <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
                </div>

            </fieldset>
        </form>

    </div>
</div>
@stop