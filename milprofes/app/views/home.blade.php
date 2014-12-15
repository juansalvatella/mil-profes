@extends('layout')
@section('content')
<div class="home-splash">
  <div class="container">
    <!-- div class="row">
      <div class="col-md-offset-4 col-md-4 jumbo" -->
        
        {{ Form::open(array('url' => 'search')) }}

        <div class="row">
          <div class="col-xs-12">
            <div class="form-group">
              {{ Form::label('direccion', @trans('home.donde')) }}
              {{ Form::text('direccion', '', array('class'=>'form-control input-lg','placeholder'=>@trans('home.defaultdonde'))) }}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              {{ Form::label('prof_o_acad', @trans('home.quebuscas')) }}
              <div class="radio"><label>{{ Form::radio('prof_o_acad', 'profesor', true) }} {{ @trans('home.profesor') }}</label></div>
              <div class="radio"><label>{{ Form::radio('prof_o_acad', 'academia') }} {{ @trans('home.academia') }}</label></div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              {{ Form::label('categoria', @trans('home.aprender')) }}
              {{ Form::select('categoria', array(
                'escolar' => @trans('home.escolar'),
                'cfp' => @trans('home.cfp'),
                'universitario' => @trans('home.universitario'),
                'artes' => @trans('home.artes'),
                'música' => @trans('home.música'),
                'idiomas' => @trans('home.idiomas'),
                'deportes' => @trans('home.deportes'),
              ), 'escolar', array('class'=>'form-control input-lg')) }}
            </div>
          </div>
        </div>
        <div class="row">
          {{ Form::submit(@trans('home.encontrar'), array('class'=>'btn btn-default')) }}
        </div>

        {{ Form::close() }}

      <!--/div>
    </div-->
  </div><!-- /.container -->
</div><!-- /.home-splash -->

<!-- Anunciarme -->
<div id="action-anunciarme" class="home-actions">
  <div class="container">
    <div class="row">

    </div>
  </div>
</div>
<!-- END Anunciarme -->
@stop