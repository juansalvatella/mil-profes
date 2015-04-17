@extends('layout')
@section('content')
<div class="home-splash">
  <div class="container">

      <div class="row">
          <div class="col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8">
              @if (Session::get('notice'))
                  <div class="alert alert-info">{{{ Session::get('notice') }}}</div>
              @endif
              @if(Session::has('success'))
                  <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
              @endif
              @if(Session::has('failure'))
                  <div class="alert alert-error alert-danger" role="alert">{{ Session::get('failure') }}</div>
              @endif
              @if (Session::get('error'))
                  @if (is_array(Session::get('error')))
                      <div class="alert alert-error alert-danger">{{ head(Session::get('error')) }}</div>
                  @else
                      <div class="alert alert-error alert-danger">{{ Session::get('error') }}</div>
                  @endif
              @endif
          </div>
      </div>

      <div class="row">
          <div class="col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8" id="welcome-responsive">
              @lang('home.welcome')
          </div>
      </div>

      {{ Form::open(array('action' => 'SearchController@search')) }}

      <div class="row text-center top-buffer-15">
          <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
              <div class="form-group">
                  {{ Form::label('user_address', @trans('home.where_are_you'), array('class'=>'main-home-label')) }}
                  @if(Auth::check())
                      {{ Form::text('user_address', Confide::user()->address, array('class'=>'form-control input-lg','placeholder'=>@trans('home.where_placeholder'))) }}
                  @else
                      {{ Form::text('user_address', '', array('class'=>'form-control input-lg','placeholder'=>@trans('home.where_placeholder'))) }}
                  @endif
              </div>
          </div>
          <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 text-left hidden" id="mi-ubicacion">
              <a href="#" id="mi-ubicacion-link">
                  <div id="mi-ubicacion-marcador"></div>
                  @lang('home.location')
              </a>
          </div>
      </div>
      <script type="text/javascript">
          $(document).ready(function(){ // IP to Location Service Provided by Google
              var checknavgeo = navigator.geolocation;
              if(checknavgeo)
                  $("#mi-ubicacion").removeClass('hidden');
              $('#mi-ubicacion-link').click(function (e) {
                  e.preventDefault();
                  if (navigator && checknavgeo) {
                      navigator.geolocation.getCurrentPosition(geo_success, geo_error);
                  } else {
//                      printAddress(geoip_latitude(), geoip_longitude()); //MAXMIND
                      $("#user_address").attr("placeholder", "No se pudo resolver tu dirección, introdúcela manualmente");
                  }
              });
          });
          function geo_success(position) {
              printAddress(position.coords.latitude, position.coords.longitude);
          }
          function geo_error() {
//              printAddress(geoip_latitude(), geoip_longitude()); //MAXMIND
              $("#user_address").attr("placeholder", "No se pudo resolver tu dirección, introdúcela manualmente");
          }
          function printAddress(latitude, longitude) {
              var geocoder = new google.maps.Geocoder();
              var yourLocation = new google.maps.LatLng(latitude, longitude);
              geocoder.geocode({ 'latLng': yourLocation }, function (results, status) {
                  if(status == google.maps.GeocoderStatus.OK) {
                      if(results[0]) {
                          $('#user_address').val(''+results[0].formatted_address);
                      } else {
                          $("#user_address").attr("placeholder", "No se pudo resolver tu dirección, introdúcela manualmente");
                      }
                  } else {
                      $("#user_address").attr("placeholder", "No se pudo resolver tu dirección, introdúcela manualmente");
                  }
              });
          }
      </script>
      <script src="http://maps.google.com/maps/api/js?sensor=false"></script>

      <div class="row text-center top-buffer-15">
          <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
            {{ Form::label('', @trans('home.what_to_learn'), array('class'=>'main-home-label')) }}
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-default btn-lg dropdown-toggle btn-pick-subject" data-toggle="dropdown">
                    <input name="subject" id="subject" type="hidden" value="all">
                    <span id="subject-name">{{ @trans('home.subject_all') }}</span>
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="#" id="action-escolar">{{ @trans('home.subject_escolar') }}</a></li>
                    <li><a href="#" id="action-cfp">{{ @trans('home.subject_cfp') }}</a></li>
                    <li><a href="#" id="action-universitario">{{ @trans('home.subject_universitario') }}</a></li>
                    <li><a href="#" id="action-artes">{{ @trans('home.subject_artes') }}</a></li>
                    <li><a href="#" id="action-musica">{{ @trans('home.subject_musica') }}</a></li>
                    <li><a href="#" id="action-idiomas">{{ @trans('home.subject_idiomas') }}</a></li>
                    <li><a href="#" id="action-deportes">{{ @trans('home.subject_deportes') }}</a></li>
                    <li><a href="#" id="action-all">{{ @trans('home.subject_all') }}</a></li>
                  </ul>
                </div><!-- /btn-group -->
                <script type="text/javascript">
                  $("#action-escolar").click(function(e){
                    e.preventDefault();
                    $("#subject").val("escolar");
                    $("#subject-name").text("{{@trans('home.subject_escolar')}}");
                    $("#keywords").attr("placeholder", "{{@trans('home.keywords_placeholder_escolar')}}");
                  });
                  $("#action-cfp").click(function(e){
                    e.preventDefault();
                    $("#subject").val("cfp");
                    $("#subject-name").text("{{@trans('home.subject_cfp')}}");
                    $("#keywords").attr("placeholder", "{{@trans('home.keywords_placeholder_cfp')}}");
                  });
                  $("#action-universitario").click(function(e){
                    e.preventDefault();
                    $("#subject").val("universitario");
                    $("#subject-name").text("{{@trans('home.subject_universitario')}}");
                    $("#keywords").attr("placeholder", "{{@trans('home.keywords_placeholder_universitario')}}");
                  });
                  $("#action-artes").click(function(e){
                    e.preventDefault();
                    $("#subject").val("artes");
                    $("#subject-name").text("{{@trans('home.subject_artes')}}");
                    $("#keywords").attr("placeholder", "{{@trans('home.keywords_placeholder_artes')}}");
                  });
                  $("#action-musica").click(function(e){
                    e.preventDefault();
                    $("#subject").val("musica");
                    $("#subject-name").text("{{@trans('home.subject_musica')}}");
                    $("#keywords").attr("placeholder", "{{@trans('home.keywords_placeholder_musica')}}");
                  });
                  $("#action-idiomas").click(function(e){
                    e.preventDefault();
                    $("#subject").val("idiomas");
                    $("#subject-name").text("{{@trans('home.subject_idiomas')}}");
                    $("#keywords").attr("placeholder", "{{@trans('home.keywords_placeholder_idiomas')}}");
                  });
                  $("#action-deportes").click(function(e){
                    e.preventDefault();
                    $("#subject").val("deportes");
                    $("#subject-name").text("{{@trans('home.subject_deportes')}}");
                    $("#keywords").attr("placeholder", "{{@trans('home.keywords_placeholder_deportes')}}");
                  });
                  $("#action-all").click(function(e){
                    e.preventDefault();
                    $("#subject").val("all");
                    $("#subject-name").text("{{@trans('home.subject_all')}}");
                    $("#keywords").attr("placeholder", "{{@trans('home.keywords_placeholder_all')}}");
                  });
                </script>

                <input type="text" name="keywords" id="keywords" placeholder="@lang('home.keywords_placeholder_all')" class="form-control input-lg">

              </div><!-- /.input-group -->
          </div><!-- /.col -->
      </div><!-- /.row -->

      <div class="row text-center">
          <div id="find-responsive" class="col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8">
              @lang('home.find')
          </div>
      </div>

      <div class="row text-center top-buffer-15">
          <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
              <input name="prof_o_acad" id="prof_o_acad" type="hidden" value="academia">

              <button type="submit" class="btn btn-primary btn-lg btn-home-search" id="btn-search-schools" value="@lang('home.schools')">
                  @lang('home.schools')&nbsp;&nbsp;<i class="glyphicon glyphicon-search"></i>
              </button>
              <script type="text/javascript">
                  $(document).on("click", "#btn-search-schools", function() {
                      $("#prof_o_acad").val('academia');
                      return true;
                  });
              </script>
              <button type="submit" class="btn btn-primary btn-lg btn-home-search" id="btn-search-teachers" value="@lang('home.teachers')">
                  @lang('home.teachers')&nbsp;&nbsp;<i class="glyphicon glyphicon-search"></i>
              </button>
              <script type="text/javascript">
                  $(document).on("click", "#btn-search-teachers", function() {
                      $("#prof_o_acad").val('profesor');
                      return true;
                  });
              </script>
          </div>
      </div>

  {{ Form::close() }}

  </div><!-- /.container -->
</div><!-- /.home-splash -->

<div id="home-featured">
    <div class="container">
        <div class="row text-center top-buffer-35">
            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 popular-title-responsive">
                <div class="chr"><span class="central-text">&nbsp;&nbsp;&nbsp;&nbsp;@lang('home.more_popular_schools')&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
                @foreach($popular_schools as $school)
                    <div class="col-xs-6 col-sm-3 names-responsive">
                        <div class="row best-image-container"><a href="{{ url('academia/'.$school->slug) }}"><img class="img-responsive img-thumbnail best-img lazy" alt="{{ $school->name }}" src="{{ asset('img/logos/'.$school->logo) }}"/></a></div>
                        <div class="row best-name-container top-buffer-5"><a href="{{ url('academia/'.$school->slug) }}">{{ $school->name }}</a></div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row text-center top-buffer-45">
            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 popular-title-responsive">
                <div class="chr"><span class="central-text">&nbsp;&nbsp;&nbsp;&nbsp;@lang('home.more_popular_teachers')&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
                @foreach($popular_teachers as $teacher)
                    <div class="col-xs-6 col-sm-3 names-responsive">
                        <div class="row best-image-container"><a href="{{ url('profe/'.$teacher->slug) }}"><img class="img-responsive img-thumbnail best-img" alt="{{ $teacher->username }}" src="{{ asset('img/avatars/'.$teacher->avatar) }}"/></a></div>
                        <div class="row best-name-container top-buffer-5"><a href="{{ url('profe/'.$teacher->slug) }}">{{ $teacher->username }}</a></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@stop