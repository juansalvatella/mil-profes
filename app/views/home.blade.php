@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')
    {{ HTML::style('css/owl.carousel.css') }}
    {{ HTML::style('css/owl.transitions.css') }}
    {{ HTML::style('css/owl.theme.css') }}
@endsection

@section('content')
    <div class="home-splash">
      <div class="container-fluid">
          <div class="row">
              <div class="col-xs-12 col-md-6">
                  <div class="row">
                      <div class="col-xs-12 col-md-offset-1 col-md-11 text-left hidden-xs hidden-sm">
                          <h3 id="welcome-responsive">@lang('home.welcome')</h3>
                      </div>
                      <div class="col-xs-12 col-md-offset-1 col-md-11 text-center hidden-md hidden-lg">
                          <h3 id="welcome-responsive">@lang('home.welcome')</h3>
                      </div>
                  </div>
              </div>
              <div class="col-xs-12 col-md-6">
                  {{ Form::open(array('action' => 'SearchController@search')) }}
                  <input type="hidden" name="first_search" value="true">
                  <div class="row top-buffer-15">
                      <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-11 col-md-offset-0 text-left">
                          <div class="form-group">
                              {{ Form::label('user_address', trans('home.where_are_you'), array('class'=>'main-home-label')) }}
                              @if(Auth::check())
                                  {{ Form::text('user_address', Confide::user()->address, array('class'=>'form-control input-lg','placeholder'=>trans('home.where_placeholder'))) }}
                              @else
                                  {{ Form::text('user_address', '', array('class'=>'form-control input-lg','placeholder'=>trans('home.where_placeholder'))) }}
                              @endif
                          </div>
                      </div>
                      <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-11 col-md-offset-0  text-left" id="mi-ubicacion">
                          <a href="#" id="mi-ubicacion-link">
                              <div id="mi-ubicacion-marcador"></div>
                              @lang('home.location')
                          </a>
                      </div>
                  </div>

                  <div class="row top-buffer-15">
                      <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-11 col-md-offset-0 text-left">
                          <span class="main-home-label">{{ trans('home.what_to_learn') }}</span>
                          <div class="input-group">
                              <div class="input-group-btn">
                                  <button type="button" class="btn btn-default btn-lg dropdown-toggle btn-pick-subject" data-toggle="dropdown">
                                      <input name="subject" id="subject" type="hidden" value="all">
                                      <span id="subject-name">{{ trans('subjects.all') }}</span>
                                      <span class="caret"></span>
                                  </button>
                                  <div class="dropdown-menu multi-column">
                                      <div class="row">
                                          <div class="col-md-6" id="multi-column-1">
                                              <ul class="dropdown-menu">
                                              <?php $half = intval(ceil(Subject::all()->count() / 2)) + 3; ?>
                                              @foreach(Subject::where('id','<=',$half)->orderBy('name')->get() as $subj)
                                                  <li><a href="#" id="action-{{ $subj->id }}">@lang('subjects.'.$subj->name)</a></li>
                                              @endforeach
                                              </ul>
                                          </div>
                                          <div class="col-md-6" id="multi-column-2">
                                              <ul class="dropdown-menu">
                                              @foreach(Subject::where('id','>',$half)->orderBy('name')->get() as $subj)
                                                  <li><a href="#" id="action-{{ $subj->id }}">@lang('subjects.'.$subj->name)</a></li>
                                              @endforeach
                                                  <li><a href="#" id="action-all">@lang('subjects.all')</a></li>
                                              </ul>
                                          </div>
                                      </div>
                                  </div>
                              </div><!-- /.input-group-btn -->

                              <input type="text" name="keywords" id="keywords" placeholder="@lang('home.keywords_placeholder_all')" class="form-control input-lg">

                          </div><!-- /.input-group -->
                      </div><!-- /.col -->
                  </div><!-- /.row -->

                  <div class="row">
                      <div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-11 col-md-offset-0  text-center">
                          <h1 id="find-responsive">@lang('home.find')</h1>
                      </div>
                  </div>

                  <div class="row top-buffer-15">
                      <div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-11 col-md-offset-0  text-center">
                          <input name="prof_o_acad" id="prof_o_acad" type="hidden" value="academia">

                          <button type="submit" class="btn btn-primary btn-lg btn-home-search" id="btn-search-schools" value="@lang('home.schools')">
                              @lang('home.schools')&nbsp;&nbsp;<i class="glyphicon glyphicon-search"></i>
                          </button>
                          <button type="submit" class="btn btn-primary btn-lg btn-home-search" id="btn-search-teachers" value="@lang('home.teachers')">
                              @lang('home.teachers')&nbsp;&nbsp;<i class="glyphicon glyphicon-search"></i>
                          </button>
                      </div>
                  </div>
                  {{ Form::close() }}
              </div><!-- /.col -->

          </div><!-- /.row -->
      </div><!-- /.container -->
    </div><!-- /.home-splash -->
@if(count($popular_teachers) >= 15)
    <div class="container-fluid" style="overflow: hidden;background-color: #fff;">
        <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-4">
            <div class="jumbotron jumbo-teachers">
                <div class="hidden-sm" style="height:70px;"></div>
                <h2>¿Eres <strong>profe. particular</strong>?</h2>
                <p class="top-buffer-15">Registra tus <strong>clases particulares</strong> GRATIS y encuentra estudiantes interesados cerca de ti.</p>
                <div class="text-center top-buffer-25">
                    <a class="btn btn-primary btn-lg" data-target="#modal-register" data-toggle="modal" href="javascript:" role="button">
                        <i class="fa fa-pencil"></i> Reg&iacute;strate GRATIS
                    </a>
                </div>
                <div class="hidden-sm hidden-lg" style="height:70px;"></div>
            </div>
        </div>

        <div class="hidden-xs col-sm-offset-2 col-sm-10 col-md-offset-1 col-md-6" style="overflow: visible;">
            <div class="hidden-xs hidden-sm" style="height:70px;text-align:center;"></div>
            <div id="diamond-container" style="display: inline-block;">
                <?php $j = 0 ?>
                @for($i=0;$i<4;++$i)
                <div class="diamond-row">
                    <div class="diamond">
                        <a href="{{ url('profe/'.$popular_teachers[$j]->slug) }}"><span class="fulldiv-link"></span></a>
                        <div class="diamond-img"><span style="background: url('{{ asset('img/avatars/'.$popular_teachers[$j]->avatar) }}') center no-repeat; background-size: cover;"></span></div>
                        <?php ++$j; ?>
                    </div>
                    <div class="diamond">
                        @if($i==1)
                            <div class="diamond-img"><span class="profes-populares" style="background-color: #202020;"><i>Profes.</i><br>populares</span></div>
                        @else
                            <a href="{{ url('profe/'.$popular_teachers[$j]->slug) }}"><span class="fulldiv-link"></span></a>
                            <div class="diamond-img"><span style="background: url('{{ asset('img/avatars/'.$popular_teachers[$j]->avatar) }}') center no-repeat; background-size: cover;"></span></div>
                            <?php ++$j; ?>
                        @endif
                    </div>
                    <div class="diamond">
                        <a href="{{ url('profe/'.$popular_teachers[$j]->slug) }}"><span class="fulldiv-link"></span></a>
                        <div class="diamond-img"><span style="background: url('{{ asset('img/avatars/'.$popular_teachers[$j]->avatar) }}') center no-repeat; background-size: cover;"></span></div>
                        <?php ++$j; ?>
                    </div>
                    <div class="diamond">
                        <a href="{{ url('profe/'.$popular_teachers[$j]->slug) }}"><span class="fulldiv-link"></span></a>
                        <div class="diamond-img"><span style="background: url('{{ asset('img/avatars/'.$popular_teachers[$j]->avatar) }}') center no-repeat; background-size: cover;"></span></div>
                        <?php ++$j; ?>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
@endif
@if(count($popular_schools) >= 15)
    <div class="container-fluid" style="background-color: #F2F2F2;">
        <div class="hidden-xs col-sm-12 col-md-8 col-lg-7" style="padding:60px 0 0 0;">
            <div style="width:100%;text-align:center;position:relative;">
                <div id="schools-carousel" class="owl-carousel owl-theme" style="width:525px;">
                    @foreach($popular_schools as $school)
                        <div class="item" style="width:175px;">
                            <a href="{{ url('academia/'.$school->slug) }}"><span class="fulldiv-link"></span></a>
                            <div class="header">
                                <div class="logo-container">
                                    <div style="background: url('{{ asset('img/logos/'.$school->logo) }}') no-repeat center;background-size: contain;height:100%;width:100%;"></div>
                                </div>
                            </div>
                            <div class="body text-center">
                                <div class="name top-buffer-45">
                                    <strong>{{ strtoupper($school->name) }}</strong>
                                </div>
                                <div class="location top-buffer-10">
                                    @if($school->region)
                                        <i class="fa fa-map-marker"></i> {{ $school->town }}
                                    @endif
                                </div>
                                <div class="category top-buffer-10">
                                    <img style="display: inline;height:20px;width:20px;" height="20" width="20" alt="@lang('subjects.'.$school->category->name)" src="{{ asset('img/subjects/'.$school->category->id.'.png') }}"/>
                                    @lang('subjects.'.$school->category->name)
                                </div>
                                <div class="starts top-buffer-10">
                                    <span class="stars-container" data-score="{{ $school->avgRating }}"></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="hidden-sm" style="height:40px;"></div>
        </div>
        <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-0 col-md-4 col-lg-4" style="padding:0 0 30px 0;">
            <div class="hidden-sm" style="height:60px;"></div>
            <div class="jumbotron jumbo-schools">
                <h2>¿Tienes una <strong>academia</strong> o <strong>centro de formación</strong>?</h2>
                <p class="top-buffer-15">Presenta los <strong>cursos y clases</strong> de tu <strong>academia</strong> a los alumnos que los están buscando.</p>
                <div class="text-center top-buffer-25">
                    <a class="btn btn-primary btn-lg" href="{{ route('services') }}" role="button">
                        <i class="fa fa-plus"></i> M&aacute;s informaci&oacute;n
                    </a>
                </div>
                <div class="hidden-sm hidden-lg" style="height:70px;"></div>
            </div>
        </div>
    </div>
@endif
@endsection

@section('page_js')
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
    @foreach(Subject::orderBy('name')->get() as $subj)
        var selector = "#action-{{ $subj->id }}";
        $(selector).click(function(e){
            e.preventDefault();
            $("#subject").val("{{$subj->name}}");
            $("#subject-name").text("{{trans('subjects.'.$subj->name)}}");
            $("#keywords").attr("placeholder", "{{trans('home.keywords_placeholder_'.$subj->name)}}");
        });
    @endforeach
        $("#action-all").click(function(e){
            e.preventDefault();
            $("#subject").val("all");
            $("#subject-name").text("{{trans('subjects.all')}}");
            $("#keywords").attr("placeholder", "{{trans('home.keywords_placeholder_all')}}");
        });
    </script>
    <script type="text/javascript">
        $(document).on("click", "#btn-search-schools", function() {
            $("#prof_o_acad").val('academia');
            return true;
        });
    </script>
    <script type="text/javascript">
        $(document).on("click", "#btn-search-teachers", function() {
            $("#prof_o_acad").val('profesor');
            return true;
        });
    </script>
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
                    $("#user_address").attr("placeholder", "No se pudo resolver tu dirección, introdúcela manualmente");
                }
            });
        });
        function geo_success(position) {
            printAddress(position.coords.latitude, position.coords.longitude);
        }
        function geo_error() {
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
    {{ HTML::script('js/owl.carousel.js') }}
    <script type="text/javascript">
        $(document).ready(function() {
            var carousel = $("#schools-carousel");
            carousel.owlCarousel({
                items: 3,
                loop: true,
                autoWidth: false,
                nav: true,
                navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
                dots: false,
                navSpeed: 500,
                autoplaySpeed: 500,
                mouseDrag: false,
                touchDrag: false,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });
            $('.stars-container').raty({
                readOnly: true,
                half: true,
                size: 15,
                starHalf: '../img/star-half-small.png',
                starOff : '../img/star-off-small.png',
                starOn  : '../img/star-on-small.png',
                score: function(){return $(this).attr('data-score');}
            });
        });
    </script>
@endsection
