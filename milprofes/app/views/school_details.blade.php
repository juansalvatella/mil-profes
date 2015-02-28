@extends('layout')
@section('content')

    {{ Form::open(array('id' => 'postForm')) }}
    {{ Form::close() }}

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div class="profile-image"><img class="lazy" data-src="{{ asset('img/logos/'.$school->logo) }}" src="" title="{{ $school->name }} logo" alt="{{ $school->name }}"></div>

            <div class="profile-title">
                <h3>{{ $school->name }}</h3>
                <div class="profile-subtitle">@lang('school-profile.subtitle')</div>
            </div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box profile-box magic-align">

            <div class="row">
                <div class="col-xs-12 school-rating">
                    <span class="school-rating-span">@lang('school-profile.rating') <span id="school-stars"></span></span>
                    <script type="text/javascript">
                        $('#school-stars').raty({
                            readOnly: true,
                            half: true,
                            score: {{ $school->getSchoolAvgRating() }}
                        });
                    </script>
                </div>
            </div>

            <div class="row">

                <div class="col-xs-12 school-description">
                    <span>@lang('school-profile.our_school')</span>
                </div>

                <div class="col-xs-12 school-description-text text-justify">
                    <span>{{ $school->description }}</span>
                </div>

                <div class="col-xs-12 school-lessons">
                    <span class="school-lessons-label-span">@lang('school-profile.lessons')</span>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="search-results-list">
                        <div id="results-slice-{{ $slices_showing }}">
                            @foreach($lessons as $result)
                                <div class="row top-buffer-25">

                                    <div class="col-xs-2 col-sm-2">
                                        <div class="row text-center">
                                            <img title="Categoría" alt="Categoría" src="{{ asset('img/'.$result->subject()->pluck('name').'.png') }}"/>
                                        </div>
                                    </div>

                                    <div class="col-xs-7 col-sm-5">

                                        <div class="row lesson-subject">
                                                <span>@lang('school-profile.lesson_of') @lang('school-profile.of_subject_'.$result->subject()->pluck('name'))</span>
                                        </div>

                                        <div class="row lesson-description-title">
                                            @lang('school-profile.lesson-description')
                                        </div>

                                        <div class="row result-description bottom-srs-separator text-justify">
                                            <small>{{{ $result->description }}}</small>
                                        </div>

                                        <div class="row lesson-availability-title">
                                            @if($result->availability->count())
                                                @lang('school-profile.availability')
                                            @endif
                                        </div>

                                        <div class="row lesson-availability">
                                            @foreach($result->availability as $pick)
                                                @if($pick->day != '')
                                                    <div class="col-sm-4 unpadded">
                                                        <small><span class="pick"><span class="pick-day">&nbsp;{{ $pick->day }}&nbsp;</span> <span class="pick-time">&nbsp;{{ substr($pick->start,0,-3) }} - {{ substr($pick->end,0,-3) }}&nbsp;&nbsp;</span></span></small>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                    </div>

                                    <div class="col-xs-offset-0 col-sm-offset-2 col-xs-3 col-sm-3">

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

                                            <a id="contact-me-{{ $result->id }}" class="btn btn-primary background-287AF9" role="button" data-toggle="popover" data-placement="left" title="Contacto">Contáctanos</a>
                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                    $("#contact-me-{{ $result->id }}").popover({
                                                        html: true,
                                                        content:    '<div class="text-center contact-info-title1">Teléfono</div>'+
                                                        '<div class="text-center contact-info-tel">{{ $school->phone }}</div>'+
                                                        '<hr class="contact-info-hr">'+
                                                        '<div class="text-center contact-info-title2">E-mail</div><div class="arrow"></div>'+
                                                        '<div class="text-center contact-info-mail">{{ $school->email  }}</div>'
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

                                <div class="col-sm-12 text-right"><hr align="center" class="lessons-separator"/></div>

                            @endforeach

                        </div>

                    </div>

                    <div class="col-sm-12 clear-left text-center show-more-link bottom-buffer-35" id="show-more-results-{{ $slices_showing }}">
                        {{--Show more link--}}
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
                                    $.post('/profiles/school/{{$school->id}}',
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

        </div>
    </div>

    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

    {{ Form::open(array('id' => 'hiddenVar')) }}
        {{ Form::hidden('slices_showing', $slices_showing, array('id' => 'current-slices-showing')) }}
    {{ Form::close() }}

@endsection