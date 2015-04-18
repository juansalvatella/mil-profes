@extends('layout')
@section('content')

    {{ Form::open(array('id' => 'postForm')) }}
    {{ Form::close() }}

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div class="profile-image"><img class="lazy" data-src="{{ asset('img/avatars/'.$teacher->avatar) }}" src="" title="{{ $teacher->username }} logo" alt="{{ $teacher->username }}"></div>

            <div class="profile-title">
                <h1 class="profile-maintitle">{{ $teacher->username }}</h1>
                <h2 class="profile-subtitle">@lang('teacher-profile.subtitle')</h2>
            </div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box profile-box magic-align">

            <div class="row">
                <div class="col-xs-offset-1 col-xs-10 teacher-rating">
                    <span class="teacher-rating-span"><span class="vcorrect">@lang('teacher-profile.rating')</span> <span id="teacher-stars"></span></span>
                    <script type="text/javascript">
                        $('#teacher-stars').raty({
                            readOnly: true,
                            half: true,
                            score: {{ $teacher->getTeacherAvgRating() }}
                        });
                    </script>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-5 col-lg-offset-1 col-lg-4">

                    @if($teacher->description != '')
                        <div class="teacher-description">
                            <span>@lang('teacher-profile.about_me')</span>
                        </div>

                        <div class="teacher-description-text text-justify">
                            <span>{{ $teacher->description }}</span>
                        </div>
                    @endif

                    <div class="teacher-lessons">
                        @if(!$teacher->availability->isEmpty())
                            @if($teacher->availability->first()->day != '')
                                <span>@lang('teacher-profile.availability')</span>
                            @endif
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-xs-12 lesson-availability">
                            @foreach($teacher->availability as $pick)
                                @if($pick->day != '')
                                    <small><span class="pick"><span class="pick-day">&nbsp;{{ $pick->day }}&nbsp;</span> <span class="pick-time">&nbsp;{{ substr($pick->start,0,-3) }} - {{ substr($pick->end,0,-3) }}&nbsp;&nbsp;</span></span></small>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10 col-md-offset-0 col-md-5 col-lg-offset-1 col-lg-5">

                    <div class="teacher-lessons">
                        <span class="teacher-lessons-label-span">@lang('teacher-profile.lessons')</span>
                    </div>
                @if ($lessons->isEmpty())
                        <div class="row top-buffer-5">
                            <div class="col-xs-12 col-sm-12">
                                Aún no tengo clases publicadas
                            </div>
                        </div>
                @else
                    @foreach($lessons as $result)
                        <div class="row top-buffer-5">

                            <div class="col-xs-2 col-sm-2">
                                <div class="row text-center subject-icon">
                                    <img alt="Categoría {{{ $result->subject()->pluck('name') }}}" src="{{ asset('img/'.$result->subject()->pluck('name').'.png') }}"/>
                                </div>
                            </div>

                            <div class="col-xs-9 col-sm-6">

                                <div class="row t-lesson-subject">
                                    @if($result->title == '')
                                        <span>@lang('teacher-profile.lesson_of') @lang('teacher-profile.of_subject_'.$result->subject()->pluck('name'))</span>
                                    @else
                                        <span>{{{ $result->title }}}</span>
                                    @endif
                                </div>

                                <div class="row result-description text-justify">
                                    <small>{{{ $result->description }}}</small>
                                </div>

                            </div>

                            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-3 col-md-offset-1 col-md-3 col-lg-offset-1 col-lg-3">

                                <div class="row text-center">
                                    <span id="lesson-stars-{{$result->id}}" class="stars-container"></span>
                                    <script type="text/javascript">
                                        $('#lesson-stars-{{$result->id}}').raty({
                                            @if(!(Auth::check()))
                                            readOnly: true,
                                            @endif
                                            half: true,
                                            size: 15,
                                            starHalf: '{{ url('/img') }}/star-half-small.png',
                                            starOff : '{{ url('/img') }}/star-off-small.png',
                                            starOn  : '{{ url('/img') }}/star-on-small.png',
                                            score: {{ $result->getLessonAvgRating() }}
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
                                                $.post('/reviews/handleReview', {
                                                    _token: postForm.find('input[name=_token]').val(),
                                                    review_lesson_id: lesson_id,
                                                    review_rating: review_rating
                                                }, function (data) {
                                                    $('#lesson-stars-{{$result->id}}').raty({
                                                        readOnly:true,
                                                        half:true,
                                                        size: 15,
                                                        starHalf: '{{ url('/img') }}/star-half-small.png',
                                                        starOff : '{{ url('/img') }}/star-off-small.png',
                                                        starOn  : '{{ url('/img') }}/star-on-small.png',
                                                        score:review_rating
                                                    });
                                                });
                                            });
                                        </script>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 hidden-sm hidden-md hidden-lg specialsep">
                                    &nbsp;
                                </div>
                            </div>

                        </div>

                    @endforeach
                @endif

                </div>

            </div>

            <div class="row text-center top-buffer-15">
                <hr class="hr-teacher-profile">
            </div>

            <div class="row text-center">

                <a id="contact-me" class="btn btn-milprofes" role="button" data-toggle="popover" data-placement="top" title="Contacto">Contáctame</a>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#contact-me").popover({
                            html: true,
                            content:    ''+
@if($teacher->phone != '')  '<div class="text-center contact-info-title1">Teléfono</div>'+
                            '<div class="text-center contact-info-tel">{{ $teacher->phone }}</div>'+
                            '<hr class="contact-info-hr">'+ @endif
                            '<div class="text-center contact-info-title2">E-mail</div><div class="arrow"></div>'+
                            '<div class="text-center contact-info-mail">{{ $teacher->email  }}</div>'
                        });
                    });
                    $(document).on("click", "#contact-me", function(e) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        var postForm = $('form#postForm');
                        $.post('/request/info/teacher/{{$teacher->id}}',{
                            _token: postForm.find('input[name=_token]').val()
                        },function(data){});
                    });
                </script>

            </div>

        </div>
    </div>

    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

@endsection