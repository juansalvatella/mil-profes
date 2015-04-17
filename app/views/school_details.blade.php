@extends('layout')
@section('content')

    {{ Form::open(array('id' => 'postForm')) }}
    {{ Form::close() }}

    {{--Profile pic and school name--}}
    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">
            <div class="profile-image"><img class="lazy" data-src="{{ asset('img/logos/'.$school->logo) }}" src="" title="{{ $school->name }} logo" alt="{{ $school->name }}"></div>
            <div class="profile-title">
                <h1 class="profile-maintitle">{{ $school->name }}</h1>
                <h2 class="profile-subtitle">@lang('school-profile.subtitle')</h2>
            </div>
        </div>
    </div>

    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box profile-box magic-align">

            <!-- Valoración -->
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10 school-rating">
                    <span class="school-rating-span"><span class="vcorrect">@lang('school-profile.rating')</span> <span id="school-stars"></span></span>
                    <script type="text/javascript">
                        $('#school-stars').raty({
                            readOnly: true,
                            half: true,
                            score: {{ $school->getSchoolAvgRating() }}
                        });
                    </script>
                </div>
            </div>

        <!-- Carousel -->
        @if(!$slpics->isEmpty())
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <?php $n = $slpics->count(); ?>
                            @for($i=1;$i<$n;++$i)
                                <li data-target="#carousel-example-generic" data-slide-to="{{ $i }}"></li>
                            @endfor
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <?php $i=0; ?>
                            @foreach($slpics as $pic)
                            <div class="item @if($i==0) active @endif">
                                <div class="carousel-table" style="background: url({{ asset('img/pics/'.$pic->pic) }}) center center no-repeat;background-size: cover;">&nbsp;</div>
                            </div>
                                <?php ++$i; ?>
                            @endforeach
                        </div>
                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>
            </div>
        @endif
        <!-- /Carousel -->


        {{--School description--}}
        @if($school->description != '')
            <div class="row school-description">
                <div class="col-xs-offset-1 col-xs-10 top-buffer-25">
                    <span>@lang('school-profile.our_school')</span>
                </div>
            </div>
            <div class="row school-description-text text-justify">
                <div class="col-xs-offset-1 col-xs-10">
                    <span>{{ $school->description }}</span>
                </div>
            </div>
        @endif

        {{--School lessons header--}}
            <div class="row school-lessons">
                <div class="col-xs-offset-1 col-xs-10 top-buffer-10">
                    <span class="school-lessons-label-span">@lang('school-profile.lessons')</span>
                </div>
            </div>

        {{--School lessons if empty lessons--}}
        @if ($lessons->isEmpty())
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10 top-buffer-5">
                    Estamos publicando nuestros cursos. Visita nuestro perfil en unos minutos.
                </div>
            </div>
        @endif
        {{--School lessons--}}
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10 top-buffer-15">
                    <div class="search-results-list">
                        <div id="results-slice-{{ $slices_showing }}">

                         @foreach($lessons as $result)

                                    <div class="hidden-xs col-sm-2 col-lg-1 text-left">
                                        <div class="row">
                                            <img alt="Categoría {{{ $result->subject()->pluck('name') }}}" src="{{ asset('img/'.$result->subject()->pluck('name').'.png') }}"/>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-10 col-lg-11">


                                        <div class="col-xs-12 col-sm-7 col-lg-7">

                                            <div class="row">
                                                <div class="col-xs-12 lesson-subject unpadded">
                                                    <span>@lang('school-profile.lesson_of') @lang('school-profile.of_subject_'.$result->subject()->pluck('name'))</span>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-xs-12">
                                                    @if($result->description != '')
                                                        <div class="row lesson-description-title">
                                                            @lang('school-profile.lesson-description')
                                                        </div>

                                                        <div class="row result-description bottom-srs-separator text-justify">
                                                            <small>{{{ $result->description }}}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row top-buffer-10">
                                                <div class="col-xs-12 lesson-availability-title unpadded">
                                                @if(!$result->availability->isEmpty())
                                                    @if($result->availability->first()->day != '')
                                                        <span>@lang('school-profile.availability')</span>
                                                    @endif
                                                @endif
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 lesson-availability unpadded">
                                                @foreach($result->availability as $pick)
                                                    @if($pick->day != '')
                                                        <small><span class="pick"><span class="pick-day">&nbsp;{{ $pick->day }}&nbsp;</span> <span class="pick-time">&nbsp;{{ substr($pick->start,0,-3) }} - {{ substr($pick->end,0,-3) }}&nbsp;&nbsp;</span></span></small>
                                                    @endif
                                                @endforeach
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 hidden-sm hidden-md hidden-lg specialsep">
                                                    &nbsp;
                                                </div>
                                            </div>

                                        </div>


                                        <div class="col-xs-offset-0 col-sm-offset-0 col-lg-offset-2 col-xs-12 col-sm-5 col-lg-3">


                                            <div class="row text-center">
                                                <span id="lesson-stars-{{$result->id}}"></span>
                                                <script type="text/javascript">
                                                    $('#lesson-stars-{{$result->id}}').raty({
                                                        @if(!(Auth::check()))
                                                        readOnly: true,
                                                        @endif
                                                        half: true,
                                                        score: {{ $result->getLessonAvgRating() }}0
                                                    });
                                                </script>
                                                @if(Auth::check())
                                                    <script type="text/javascript">
                                                        $(document).on("click", "#lesson-stars-{{$result->id}}", function(e) {
                                                            e.preventDefault();
                                                            e.stopImmediatePropagation();
                                                            //registrar valoración en base de datos
                                                            var lesson_id = {{ $result->id }};
                                                            var review_rating = $('#lesson-stars-{{$result->id}}').raty('score');
                                                            var postForm = $('form#postForm');
                                                            $.post('/reviews/handleSchoolLessonReview', {
                                                                _token: postForm.find('input[name=_token]').val(),
                                                                review_lesson_id: lesson_id,
                                                                review_rating: review_rating
                                                            }, function (data) {
                                                                $('#lesson-stars-{{$result->id}}').raty({readOnly:true,half:true,score:review_rating});
                                                            });
                                                        });
                                                    </script>
                                                @endif
                                            </div>

                                            <div class="row text-center">
                                                @if($result->price=='0')
                                                    <div class="row no-price-provided">Contáctanos<br>para saber<br>el precio</div>
                                                @else
                                                    <div class="row price">
                                                        {{{ $result->price }}} €
                                                    </div>
                                                    <div class="row per-unit">@lang('school-profile.per_unit')</div>
                                                @endif
                                            </div>

                                            <div class="row text-center top-buffer-15">

                                                <a id="contact-me-{{ $result->id }}" class="btn btn-milprofes" role="button" data-toggle="popover" data-placement="top" title="Contacto">Contáctanos</a>
                                                <script type="text/javascript">
                                                    $(document).ready(function(){
                                                        $("#contact-me-{{ $result->id }}").popover({
                                                            html: true,
                                                            content:    ''+
                                                            @if($school->phone == '' && $school->email == '')  'Nuestra información de contacto aún no está disponible.'+ @endif
                            @if ($school->phone != '')  '<div class="text-center contact-info-title1">Teléfono</div>'+
                                                            '<div class="text-center contact-info-tel">{{ $school->phone }}</div>'+ @endif
     @if($school->phone != '' && $school->email != '')  '<hr class="contact-info-hr">'+ @endif
                             @if($school->email != '')  '<div class="text-center contact-info-title2">E-mail</div><div class="arrow"></div>'+
                                                            '<div class="text-center contact-info-mail">{{ $school->email  }}</div>'+ @endif
                                                        ''
                                                        });
                                                    });
                                                    $(document).on("click", "#contact-me-{{ $result->id }}", function(e) {
                                                        e.preventDefault();
                                                        e.stopImmediatePropagation();
                                                        var postForm = $('form#postForm');
                                                        $.post('/request/info/school/{{$result->id}}',{
                                                            _token: postForm.find('input[name=_token]').val()
                                                        },function(data){});
                                                    });
                                                </script>
                                            </div>

                                        </div>


                                    </div>


                            <!-- separator -->
                            <div class="col-xs-12">
                                <div class="col-xs-offset-0 col-sm-offset-2 col-xs-12 col-sm-8 lessons-separator">&nbsp;</div>
                            </div>

                        @endforeach <!-- /lesson -->

                        </div>
                    </div>


                    {{--Show more link--}}
                    <div class="col-sm-12 clear-left text-center show-more-link bottom-buffer-35" id="show-more-results-{{ $slices_showing }}">

                        @if($display_show_more)
                            <a href="#">
                                MOSTRAR MAS RESULTADOS<br>
                                <i class="fa fa-angle-down"></i>
                            </a>

                            <script type="text/javascript">
                                $(document).on("click", "#show-more-results-{{ $slices_showing }}", function(e) {
                                    e.preventDefault();
                                    e.stopImmediatePropagation();
                                    var form = $('form#hiddenVar');
                                    $.post('/academia/{{$school->slug}}',
                                            {
                                                _token: form.find('input[name=_token]').val(),
                                                slices_showing: form.find('input[name=slices_showing]').val()
                                            },
                                            function(data) { //handle the controller response
                                                $('.search-results-list').append($(data).find('#results-slice-{{ $slices_showing+1 }}'));
                                                $('#show-more-results-{{ $slices_showing }}').replaceWith($(data).find('#show-more-results-{{ $slices_showing+1 }}'));
                                            });
                                    var ninput = $('#current-slices-showing');
                                    var n = parseInt(ninput.val());
                                    ninput.val(n+1);
                                });
                            </script>
                        @endif
                    </div><!--/#show-more-results -->


                </div>
            </div>

        {{--/School lessons--}}

        </div>
    </div>

    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

    {{ Form::open(array('id' => 'hiddenVar')) }}
        {{ Form::hidden('slices_showing', $slices_showing, array('id' => 'current-slices-showing')) }}
    {{ Form::close() }}

@endsection