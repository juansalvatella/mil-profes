@extends('layout')
@section('content')
<div class="home-splash">
  <div class="container">
    <div class="row">
      <div class="col-md-offset-4 col-md-4 jumbo">
        
        {{ Form::open(array('url' => 'search')) }}

        {{ Form::label('where-label', @trans('home.donde')) }}
        {{ Form::text('where', @trans('home.defaultdonde')) }}

        {{ Form::label('where', @trans('home.donde')) }}

        {{ Form::close() }}

      </div>
    </div>
  </div>
</div><!-- /.container -->

<!-- Anunciarme -->
<div id="action-anunciarme" class="home-actions">
  <div class="container">
    <div class="row">

    </div>
  </div>
</div>
<!-- END Anunciarme -->
@stop