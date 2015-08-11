@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')
    {{ HTML::style('css/bootstrap-social.css') }}
@endsection

@section('content')

<div class="container">
    <div class="row" style="padding:150px 0 300px 0;">
        <div class="col-xs-12 text-center">
            <a class="btn btn-block btn-social btn-facebook" href="{{ route('fb.login') }}">
                <i class="fa fa-facebook"></i> Sign in with Facebook
            </a>
            <a class="btn btn-block btn-social btn-twitter" href="{{ route('tw.login') }}">
                <i class="fa fa-twitter" style="color:white!important;"></i> Sign in with Twitter
            </a>
            <a class="btn btn-block btn-social btn-google" href="{{ route('gp.login') }}">
                <i class="fa fa-google-plus" style="color:white!important;"></i> Sign in with Google+
            </a>
        </div>
    </div>
</div>

@endsection

@section('page_js')

@endsection