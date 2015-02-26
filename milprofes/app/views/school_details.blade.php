@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div class="profile-image"><img src="{{ asset('img/logos/'.$school->logo) }}" title="{{ $school->name }} logo" alt="{{ $school->name }}"></div>

            <div class="profile-title">
                <h3>{{ $school->name }}</h3>
                <div class="profile-subtitle">Academia</div>
            </div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-25 bottom-padding-50 magic-align">

            <div class="col-xs-12 school-rating">
                <span class="school-rating-span">Valoración <span id="school-stars"></span></span>
                <script type="text/javascript">
                    $('#school-stars').raty({
                        readOnly: true,
                        half: true,
                        score: {{ $school->getSchoolAvgRating() }}0
                    });
                </script>
            </div>

            <div class="col-xs-12 school-description">
                <div class="col-xs-12">
                    <span class="school-description-span">@lang('school-profile.description')</span>
                </div>
                <div class="col-xs-12 school-description-text text-justify">
                    {{ $school->description }}
                </div>

            </div>

            <div class="col-xs-12">
                <div class="col-xs-12 school-lessons-label">
                    <span class="school-lessons-label-span">@lang('school-profile.lessons')</span>
                </div>

                <div class="col-xs-12">

                    <div class="search-results-list">
                        <div id="results-slice-{{ $slices_showing }}">
                            @foreach($lessons as $result)
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="row lesosn-subj_img-container">
                                            <img class="lesosn-subj_img" title="Categoría" alt="Categoría" src="{{ asset('img/'.$result->subject()->pluck('name').'.png') }}"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row result-name">

                                                <span>{{{ $result->name }}}</span>

                                        </div>
                                        <div class="row result-subject">

                                                <span class="span-subject-school">&nbsp;@lang('school-profile.lesson_of') @lang('school-profile.of_subject_'.$result->subject()->pluck('name'))&nbsp;</span>

                                        </div>

                                        <div class="row result-description-title">
                                            DESCRIPCIÓN DE LA CLASE
                                        </div>
                                        <div class="row result-description bottom-srs-separator">
                                            <small>{{{ $result->description }}}</small>
                                        </div>
                                        <div class="row result-availability-title">
                                            @if($result->availability->count())
                                                DISPONIBILIDAD
                                            @endif
                                        </div>
                                        <div class="row result-availability">
                                            @foreach($result->availability as $pick)
                                                @if($pick->day != '')
                                                    <div class="col-sm-4 unpadded">
                                                        <small><span class="pick"><span class="pick-day">&nbsp;{{ $pick->day }}&nbsp;</span> <span class="pick-time">&nbsp;{{ substr($pick->start,0,-3) }} - {{ substr($pick->end,0,-3) }}&nbsp;&nbsp;</span></span></small>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="row text-center">
                                            <span id="lesson-stars-{{$result->id}}"></span>
                                            <script type="text/javascript">
                                                $('#lesson-stars-{{$result->id}}').raty({
                                                    @if(!(Auth::check()))
                                                    readOnly: true,
                                                    @endif
                                                    half: true,
                                                    score: {{ $result->lesson_avg_rating }}
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
                                                        @if($prof_o_acad=='profesor')
                                                        $.post('/reviews/handleReview', {
                                                            review_lesson_id: lesson_id,
                                                            review_rating: review_rating
                                                        }, function (data) {
                                                            $('#lesson-stars-{{$result->id}}').raty({readOnly:true,half:true,score:review_rating});
                                                        });
                                                        @else
                                                            $.post('/reviews/handleSchoolLessonReview', {
                                                                    review_lesson_id: lesson_id,
                                                                    review_rating: review_rating
                                                                }, function (data) {
                                                                    $('#lesson-stars-{{$result->id}}').raty({readOnly:true,half:true,score:review_rating});
                                                                });
                                                        @endif
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

                                                    <div class="row per-unit">por Curso</div>

                                            @endif
                                        </div>
                                        {{--<script>--}}
                                        {{--$(document).ready(function($){--}}
                                        {{--$(".price").fitText();--}}
                                        {{--});--}}
                                        {{--</script>--}}
                                        <div class="row text-center top-buffer-15">

                                                <a id="contact-me-{{ $result->id }}" class="btn btn-warning background-E79500" role="button" data-toggle="popover" data-placement="left" title="Contacto">Contáctanos</a>

                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                    $("#contact-me-{{ $result->id }}").popover({
                                                        html: true,
                                                        content:    '<div class="text-center contact-info-title1">Teléfono</div>'+
                                                        '<div class="text-center contact-info-tel">{{ $result->phone }}</div>'+
                                                        '<hr class="contact-info-hr">'+
                                                        '<div class="text-center contact-info-title2">E-mail</div><div class="arrow"></div>'+
                                                        '<div class="text-center contact-info-mail">{{ $result->email  }}</div>'
                                                    });
                                                });
                                                $(document).on("click", "#contact-me-{{ $result->id }}", function(e) {
                                                    e.preventDefault();
                                                    e.stopImmediatePropagation();
                                                    $.post('/request/info/school/{{$result->id}}',{},function(data){});
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-right"><hr align="right" class="results-separator"/></div>
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
                                    var soForm = $('form#newSearchForm');
                                    $.post('/search/asearch',
                                            {
                                                _token: soForm.find('input[name=_token]').val(),
                                                user_lat: soForm.find('input[name=user_lat]').val(),
                                                user_lon: soForm.find('input[name=user_lon]').val(),
                                                keywords: soForm.find('input[name=keywords]').val(),
                                                user_address: soForm.find('input[name=user_address]').val(),
                                                prof_o_acad: $('input[name=prof_o_acad]:checked', '#newSearchForm').val(),
                                                search_distance: $('input[name=search_distance]:checked', '#newSearchForm').val(),
                                                subject: $('input[name=subject]:checked', '#newSearchForm').val(),
                                                price: $('input[name=price]:checked', '#newSearchForm').val(),
                                                slices_showing: soForm.find('input[name=slices_showing]').val()
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

{{--{{ $school->email }}--}}
{{--{{ $school->address }}--}}
{{--{{ $school->phone }}--}}

{{--@foreach($lessons as $lesson)--}}
    {{--{{ $lesson->description }} --}}
    {{--{{ $lesson->subject->name }} --}}
    {{--{{ $lesson->getLessonAvgRating() }} --}}
    {{--{{ $lesson->price }} --}}
{{--@endforeach--}}




@endsection