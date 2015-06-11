@extends('layout')
@section('content')

{{--Rich snippet--}}

{{-- This vars are needed for teacher.js --}}
<input type="hidden" id="_token" value="{{ Session::getToken() }}">
<input type="hidden" id="teacherId" value="{{ $teacher->id }}">
<input type="hidden" id="teacher-rating" value="{{ $teacher->avgRating }}" />

<div class="container-fluid background-gblack">
    <div class="row">
        <div class="col-md-offset-1 col-md-10 hdr-img" itemscope itemtype="http://schema.org/LocalBusiness" id="profe" itemref="address" style="
        @if(false)
                background: url('{{asset('img/school-bims/default.jpg')}}') no-repeat center center;
        @else
                background: url('{{asset('img/school-bims/default.jpg')}}') no-repeat center center;
        @endif
                background-size: cover;">
            <meta itemprop="name" content="{{ $teacher->displayName }}">
            {{--<meta itemprop="jobTitle" content="Profe.">--}}
            <meta itemprop="telephone" content="{{{ $teacher->phone }}}">
            <meta itemprop="email" content="{{{ $teacher->email }}}">
            <img itemprop="image" height="160" width="160" class="tprofile-avatar thumbnail" src="{{ asset('img/avatars/'.$teacher->avatar) }}" alt="{{ $teacher->displayName }}">
            <div class="tprofile-stars" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                <meta itemprop="reviewCount" content="{{ $teacher->nReviews }}">
                <meta itemprop="ratingValue" content="{{ $teacher->avgRating }}">
                <meta itemprop="bestRating" content="5">
            </div>

            <div class="tprofile-name">
                <b>{{ $teacher->displayName }}</b>
                <br/>
                <small>@lang('teacher-profile.teacher')</small>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-10 hdr-share text-right">
            <div class="tprofile-stars">
                <div id="teacher-stars"></div><span id="teacher-n-reviews" title="@choice('teacher-profile.reviews',2)">({{ $teacher->nReviews }})</span>
            </div>
            @if($teacher->itsme)
                <span class="hidden-xs hidden-sm hidden-md share-me">@lang('teacher-profile.share-myself') <i class="fa fa-chevron-right"></i></span>
            @else
                <span class="hidden-xs hidden-sm hidden-md share-me">@lang('teacher-profile.share-me') <i class="fa fa-chevron-right"></i></span>
            @endif
            <div class="share-container">
                <ul class="rrssb-buttons clearfix">
                    <li class="rrssb-facebook">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" class="popup">
                            <span class="rrssb-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="29" height="29" viewBox="0 0 29 29">
                                  <path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z" class="cls-2" fill-rule="evenodd"></path>
                              </svg>
                            </span>
                            <span class="rrssb-text"><span class="hidden-lg">@lang('buttons.share')</span><span class="hidden-xs hidden-sm hidden-md">@lang('teacher-profile.in-f')</span></span>
                        </a>
                    </li>
                    <li class="rrssb-twitter">
                        <?php
                            $twitter_status = urlencode('Visita mi perfil de profe. en @milprofes ¿Qué vas a aprender hoy?: '.Request::url());
                        ?>
                        <a href="http://twitter.com/home?status={{$twitter_status}}" class="popup">
                            <span class="rrssb-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28">
                                  <path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62c-3.122.162-6.22-.646-8.86-2.32 2.702.18 5.375-.648 7.507-2.32-2.072-.248-3.818-1.662-4.49-3.64.802.13 1.62.077 2.4-.154-2.482-.466-4.312-2.586-4.412-5.11.688.276 1.426.408 2.168.387-2.135-1.65-2.73-4.62-1.394-6.965C5.574 7.816 9.54 9.84 13.802 10.07c-.842-2.738.694-5.64 3.434-6.48 2.018-.624 4.212.043 5.546 1.682 1.186-.213 2.318-.662 3.33-1.317-.386 1.256-1.248 2.312-2.4 2.942 1.048-.106 2.07-.394 3.02-.85-.458 1.182-1.343 2.15-2.48 2.71z"></path>
                              </svg>
                            </span>
                            <span class="rrssb-text"><span class="hidden-lg">@lang('buttons.share')</span><span class="hidden-xs hidden-sm hidden-md">@lang('teacher-profile.in-t')</span></span>
                        </a>
                    </li>
                    <li class="rrssb-googleplus">
                        <?php
                            $googleplus_status = urlencode('Visita mi perfil de profe. en milPROFES. ¿Qué vas a aprender hoy?: '.Request::url());
                        ?>
                        <a href="https://plus.google.com/share?url={{$googleplus_status}}" class="popup">
                            <span class="rrssb-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28">
                                  <path d="M14.703 15.854l-1.22-.948c-.37-.308-.88-.715-.88-1.46 0-.747.51-1.222.95-1.662 1.42-1.12 2.84-2.31 2.84-4.817 0-2.58-1.62-3.937-2.4-4.58h2.098l2.203-1.384h-6.67c-1.83 0-4.467.433-6.398 2.027C3.768 4.287 3.06 6.018 3.06 7.576c0 2.634 2.02 5.328 5.603 5.328.34 0 .71-.033 1.083-.068-.167.408-.336.748-.336 1.324 0 1.04.55 1.685 1.01 2.297-1.523.104-4.37.273-6.466 1.562-1.998 1.187-2.605 2.915-2.605 4.136 0 2.512 2.357 4.84 7.288 4.84 5.822 0 8.904-3.223 8.904-6.41.008-2.327-1.36-3.49-2.83-4.73h-.01zM10.27 11.95c-2.913 0-4.232-3.764-4.232-6.036 0-.884.168-1.797.744-2.51.543-.68 1.49-1.12 2.372-1.12 2.807 0 4.256 3.797 4.256 6.24 0 .613-.067 1.695-.845 2.48-.537.55-1.438.947-2.295.95v-.003zm.032 13.66c-3.62 0-5.957-1.733-5.957-4.143 0-2.408 2.165-3.223 2.91-3.492 1.422-.48 3.25-.545 3.556-.545.34 0 .52 0 .767.034 2.574 1.838 3.706 2.757 3.706 4.48-.002 2.072-1.736 3.664-4.982 3.648l.002.017zM23.254 11.89V8.52H21.57v3.37H18.2v1.714h3.367v3.4h1.684v-3.4h3.4V11.89"></path>
                              </svg>
                            </span>
                            <span class="rrssb-text"><span class="hidden-lg">@lang('buttons.share')</span><span class="hidden-xs hidden-sm hidden-md">@lang('teacher-profile.in-g')</span></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row top-buffer-25">
        <div class="col-md-offset-1 col-md-10">
            <div class="row">
                <div class="col-md-4 side-cntr">
                    <div class="row">
                        <div class="col-md-12 activity-cntr">

                            <div class="panel panel-milprofes panel-contact-info">
                                <div class="panel-heading contact-info-title">
                                    <a id="contact-me" data-toggle="collapse" data-target="#collapse" class="collapsed" href="javascript:">
                                        @lang('teacher-profile.info-title')
                                    </a>
                                </div>
                                <div id="collapse" class="panel-collapse collapse">
                                    <div class="panel-body contact-info-body">
                                        <div class="contact-info-content">
                                            @if($teacher->phone)
                                                <div><i class="fa fa-phone"></i> <span class="tlf-number" itemprop="telephone">{{{ substr($teacher->phone,0,3).' '.substr($teacher->phone,3,2).' '.substr($teacher->phone,5,2).' '.substr($teacher->phone,7,strlen($teacher->phone)-7) }}}</span></div>
                                            @endif
                                            <div><i class="fa fa-envelope-o"></i> <a href="mailto:{{{ $teacher->email }}}">{{{ $teacher->email }}}</a></div>
                                        </div>
                                        <div class="contact-info-social">
                                            @if($teacher->link_f)
                                                <a href="{{ $teacher->link_f }}" target="_blank"><i class="fa fa-facebook-square"></i></a>
                                            @else
                                                <i class="fa fa-facebook-square disabled"></i>
                                            @endif
                                            @if($teacher->link_t)
                                                <a href="{{ $teacher->link_t }}" target="_blank"><i class="fa fa-twitter-square"></i></a>
                                            @else
                                                <i class="fa fa-twitter-square disabled"></i>
                                            @endif
                                            @if($teacher->link_g)
                                                <a href="{{ $teacher->link_g }}" target="_blank"><i class="fa fa-google-plus-square"></i></a>
                                            @else
                                                <i class="fa fa-google-plus-square disabled"></i>
                                            @endif
                                            @if($teacher->link_i)
                                                <a href="{{ $teacher->link_i }}" target="_blank"><i class="fa fa-instagram"></i></a>
                                            @else
                                                <i class="fa fa-instagram disabled"></i>
                                            @endif
                                            @if($teacher->link_l)
                                                <a href="{{ $teacher->link_l }}" target="_blank"><i class="fa fa-linkedin-square"></i></a>
                                            @else
                                                <i class="fa fa-linkedin-square disabled"></i>
                                            @endif
                                            @if($teacher->link_w)
                                                <a href="{{ $teacher->link_w }}" target="_blank">
                                                    <span class="fa-stack fa-lg">
                                                        <i class="fa fa-square-o fa-stack-2x"></i>
                                                        <i class="fa fa-globe fa-stack-1x"></i>
                                                    </span>
                                                </a>
                                            @else
                                            <span class="fa-stack fa-lg">
                                                <i class="fa fa-square-o fa-stack-2x disabled"></i>
                                                <i class="fa fa-globe fa-stack-1x disabled"></i>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-milprofes panel-activity">
                                <div class="panel-heading">@lang('teacher-profile.title_activity')</div>
                                <div class="panel-body">
                                    <div><i class="fa fa-eye"></i> {{ $teacher->profile_visits }} @lang('teacher-profile.views')</div>
                                    @if($teacher->rank)
                                    <div><i class="fa fa-arrow-up"></i> @lang('teacher-profile.popularity') #{{ $teacher->rank }}</div>
                                    @endif
                                    <div>
                                        <i class="fa fa-calendar"></i> @lang('teacher-profile.antiguedad')
                                        @if($teacher->antiguedad['years'] == '0' && $teacher->antiguedad['months'] == '0')
                                        <span>{{ $teacher->antiguedad['days'] }} @choice('teacher-profile.days',$teacher->antiguedad['days'])</span>
                                        @elseif($teacher->antiguedad['years'] == '0')
                                        <span>{{ $teacher->antiguedad['months'] }} @choice('teacher-profile.months',$teacher->antiguedad['months']) @lang('teacher-profile.and')</span>
                                        <span>{{ $teacher->antiguedad['days'] }} @choice('teacher-profile.days',$teacher->antiguedad['days'])</span>
                                        @else
                                        <span>{{ $teacher->antiguedad['years'] }} @choice('teacher-profile.years',$teacher->antiguedad['years']),</span>
                                        <span>{{ $teacher->antiguedad['months'] }} @choice('teacher-profile.months',$teacher->antiguedad['months']) @lang('teacher-profile.and')</span>
                                        <span>{{ $teacher->antiguedad['days'] }} @choice('teacher-profile.days',$teacher->antiguedad['days'])</span>
                                        @endif
                                    </div>
                                @if($teacher->last_update)
                                    <div>
                                        <i class="fa fa-refresh"></i> @lang('teacher-profile.last_update')
                                        <br/><i class="fa fa-clock-o transparent"></i> {{ $teacher->last_update }}
                                    </div>
                                @endif
                                </div>
                            </div>

                        </div>

                        @if(!$teacher->availability->isEmpty() && $teacher->availability->first()->day != '')
                        <div class="col-md-12 my-info-availability">

                            <div class="panel panel-milprofes panel-info">
                                <div class="panel-heading">@lang('teacher-profile.title_availability')</div>
                                <div class="panel-body">
                                @foreach($teacher->availability as $pick)
                                    @if($pick->day != '')
                                        <small><span class="pick pick-lg"><span class="pick-day pick-day-lg">&nbsp;{{ $pick->day }}&nbsp;</span> <span class="pick-time pick-time-lg">&nbsp;{{ substr($pick->start,0,-3) }} - {{ substr($pick->end,0,-3) }}&nbsp;&nbsp;</span></span></small>
                                    @endif
                                @endforeach
                                </div>
                            </div>

                        </div>
                        @endif


                        @if($teacher->gender || $teacher->age || $teacher->town || $teacher->description!='')
                        <div class="col-md-12 my-info-cntr">

                            <div class="panel panel-milprofes panel-info">
                                <div class="panel-heading">@lang('teacher-profile.title_info')</div>
                                <div class="panel-body">
                                    @if($teacher->gender)
                                    <div>
                                        @if($teacher->gender == 'male')
                                            <i class="fa fa-mars"></i> @lang('teacher-profile.gender-male')
                                        @elseif($teacher->gender == 'female')
                                            <i class="fa fa-venus"></i> @lang('teacher-profile.gender-female')
                                        @elseif($teacher->gender == 'other')
                                            <i class="fa fa-mars-stroke-h"></i> @lang('teacher-profile.gender-other')
                                        @endif
                                    </div>
                                    @endif
                                    @if($teacher->age)
                                    <div>
                                        <i class="fa fa-birthday-cake"></i> {{ $teacher->age }} @choice('teacher-profile.years',$teacher->age)
                                    </div>
                                    @endif
                                    @if($teacher->town)
                                    <div id="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                        <meta itemprop="addressRegion" content="{{ $teacher->region }}">
                                        <meta itemprop="postalCode" content="{{ $teacher->postalcode }}">
                                        <i class="fa fa-map-marker"></i> @lang('teacher-profile.town') <span itemprop="addressLocality">{{ $teacher->town }}</span>
                                    </div>
                                    @endif
                                    @if($teacher->description != '')
                                    <div>
                                        <i class="fa fa-user-plus"></i> Mi descripción:
                                    </div>
                                    <p class="tprofile-description">{{{ $teacher->description }}}</p>
                                    @endif
                                </div>
                            </div>

                        </div>
                        @endif

                    </div>
                </div>

                <div class="col-md-8 main-cntr">
                    <div class="row">
                        <div class="col-md-12 my-lessons-cntr">
                            <div class="my-lessons">

                                <div class="panel panel-milprofes panel-lessons">
                                    <div class="panel-heading">@lang('teacher-profile.title_lessons')</div>
                                    <div id="panel-body-lessons" class="panel-body">

                                        @if ($lessons->isEmpty())
                                            <span>Aún no tengo clases publicadas.</span>
                                        @else
                                            @foreach($lessons as $l)
                                                <div class="row bottom-buffer-45">

                                                    <div class="col-xs-12 col-sm-2">
                                                        <div class="row text-center subject-icon-lg">
                                                            <?php
                                                                $category_name = $l->subject()->pluck('name');
                                                                $n_reviews = $l->getNumberOfReviews();
                                                            ?>
                                                            <img title="Categoría {{ $category_name }}" alt="Categoría {{ $category_name }}" src="{{ asset('img/'.$category_name.'.png') }}"/>
                                                            <br/>
                                                            <a href="javascript:" class="@if(Auth::check()) trigger-review @else trigger-login @endif" data-lessonId="{{ $l->id }}"><span class="stars-container top-buffer-5 bottom-buffer-5" data-score="{{ $l->getLessonAvgRating() }}"></span></a>
                                                            <br/>
                                                            <span id="lesson-n-reviews"><small><i class="fa fa-user" title="@choice('teacher-profile.reviews',$n_reviews)"></i> {{ $n_reviews }}</small></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-8">
                                                        <div class="t-lesson-subject">
                                                            @if($l->title == '')
                                                                <h4><b>@lang('teacher-profile.lesson_of') @lang('teacher-profile.of_subject_'.$category_name)</b></h4>
                                                            @else
                                                                <h4><b>{{{ $l->title }}}</b></h4>
                                                            @endif
                                                        </div>

                                                        <div class="t-lesson-description result-description text-justify">
                                                            {{{ $l->description }}}
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-2 price-container-tp">
                                                        @if($l->price==0.0)
                                                            <div class="no-price-provided-tp text-center">Contáctame<br>para saber<br>el precio</div>
                                                        @else
                                                            <div class="price-tp text-center">
                                                                {{-- + 0 removes zeros to the right of the decimal separator --}}
                                                                {{{ str_replace('.', ',', $l->price + 0) }}}
                                                            </div>
                                                            <div class="text-center per-unit-tp">@lang('teacher-profile.price_unit')</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-xs-12 top-buffer-15">
                                                        <div class="t-lesson-comments-title">
                                                            <h5 class="t-lesson-title-reviews">@lang('teacher-profile.title_reviews')</h5> @if($n_reviews > 2)<a href="javascript:" class="trigger-all-reviews" data-lessonId="{{ $l->id }}">(ver todas)</a>@endif
                                                        </div>

                                                        <div class="row top-buffer-10">
                                                        <?php
                                                            $featured_reviews = $l->getFeaturedReviews(2);
                                                            $n_fr = count($featured_reviews);
                                                        ?>
                                                        @if($n_fr)
                                                            @foreach($featured_reviews as $f)
                                                                <?php
                                                                    //Get reviewer display name
                                                                    $student = Student::where('id',$f->student_id)->first();
                                                                    $reviewer = $student->user()->withTrashed()->first();
                                                                    $reviewer->displayName = ucwords($reviewer->name).' '.substr(ucwords($reviewer->lastname),0,1).'.';
                                                                ?>
                                                                {{--@if($n_fr < 2)--}}
                                                                {{--<div class="col-xs-12 col-sm-12" itemprop="review" itemscope itemtype="http://schema.org/Review">--}}
                                                                {{--@else--}}
                                                                <div class="col-xs-12 col-sm-6" itemprop="review" itemscope itemtype="http://schema.org/Review">
                                                                {{--@endif--}}
                                                                    <meta itemprop="datePublished" content="{{ $f->created_at->format('Y-m-d') }}">
                                                                    <div itemprop="itemReviewed" itemscope itemtype="http://schema.org/LocalBusiness">
                                                                        <meta itemprop="name" content="{{ $teacher->displayName }}">
                                                                    </div>
                                                                    <div class="row">
                                                                        {{--@if($n_fr < 2)--}}
                                                                        {{--<div class="col-xs-12 col-sm-2 padding-0">--}}
                                                                        {{--@else--}}
                                                                        <div class="col-xs-12 col-sm-3 padding-0">
                                                                        {{--@endif--}}
                                                                            <div class="text-center top-buffer-3"><img class="img-circle" width="46" height="46" src="{{ asset('img/avatars/'.$reviewer->avatar) }}"/></div>
                                                                            <div class="text-center top-buffer-10 ellipsis reviewer-name" itemprop="author">{{ $reviewer->displayName }}</div>
                                                                            <?php
                                                                                $ayes = $f->yes_helpful;
                                                                                $noes = $f->total_helpful - $f->yes_helpful;
                                                                                $helpSum = $ayes - $noes;
                                                                                $checkPositive = ($helpSum >= 0) ? true : false;
                                                                            ?>
                                                                            @if($checkPositive)
                                                                                <div class="text-center text-success"><small><i class="fa fa-plus"></i></small> {{ $helpSum }}</div>
                                                                            @else
                                                                                <div class="text-center text-danger"><small><i class="fa fa-minus"></i></small> {{ abs($helpSum) }}</div>
                                                                            @endif
                                                                        </div>
                                                                        {{--@if($n_fr < 2)--}}
                                                                        {{--<div class="col-xs-12 col-sm-10 padding-0">--}}
                                                                        {{--@else--}}
                                                                        <div class="col-xs-12 col-sm-9 padding-0">
                                                                        {{--@endif--}}
                                                                            <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                                                                                <meta itemprop="worstRating" content="0">
                                                                                <meta itemprop="ratingValue" content="{{ $f->value }}">
                                                                                <meta itemprop="bestRating" content="5">
                                                                                <div class="ratings-stars" data-score="{{ $f->value }}"><div class="inline-block float-right right-buffer-5">{{ $f->created_at->format('d/m/Y') }}</div></div>
                                                                                {{--<div class="comment-helpfulness"><small>{{ $f->yes_helpful }} de {{ $f->total_helpful }} encontraron útil esta valoración</small></div>--}}
                                                                                <div class="comment-text"><span itemprop="description">{{{ $f->comment }}}</span></div>
                                                                                <div class="comment-isithelpful">
                                                                                    ¿Te ha resultado útil esta valoración?<br/>
                                                                                    <a href="javascript:" data-reviewId="{{ $f->id }}" class="btn btn-xs btn-link btn-yes @if(Auth::check()) itwashelpful @else trigger-login @endif ">
                                                                                        <i class="fa fa-thumbs-up"></i> @lang('buttons.yes')
                                                                                    </a>
                                                                                    <a href="javascript:" data-reviewId="{{ $f->id }}" class="btn btn-xs btn-link btn-no @if(Auth::check()) nothelpful @else trigger-login @endif ">
                                                                                        <i class="fa fa-thumbs-down"></i> @lang('buttons.no')
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="col-xs-12">
                                                                <span class="no-reviews">¿Has estudiado con {{ $teacher->displayName2 }}? ¡Sé el primero o la primera en <a href="javascript:" class="@if(Auth::check()) trigger-review @else trigger-login @endif" data-lessonId="{{ $l->id }}">valorar</a> esta clase!</span>
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr align="center" width="100%" class="description-reviews-separator"/>

                                                <?php $all_reviews = $l->ratings()->orderBy('created_at','DESC')->get(); ?>
                                                @if(count($all_reviews) > 2)
                                                {{--All lesson reviews MODAL--}}
                                                <div class="modal fade" id="modal-all-reviews-lesson-{{ $l->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-all-review-lesson-{{ $l->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                @foreach($all_reviews as $a)
                                                                    <?php
                                                                        //Get reviewer display name
                                                                        $student = Student::where('id',$a->student_id)->first();
                                                                        $reviewer = $student->user()->withTrashed()->first();
                                                                        $reviewer->displayName = ucwords($reviewer->name).' '.substr(ucwords($reviewer->lastname),0,1).'.';
                                                                    ?>
                                                                    <div class="row bottom-buffer-15">
                                                                        <div class="col-xs-12" itemprop="review" itemscope itemtype="http://schema.org/Review">
                                                                            <meta itemprop="datePublished" content="{{ $a->created_at->format('Y-m-d') }}">
                                                                            <div itemprop="itemReviewed" itemscope itemtype="http://schema.org/LocalBusiness">
                                                                                <meta itemprop="name" content="{{ $teacher->displayName }}">
                                                                            </div>
                                                                            <div class="col-xs-12 col-sm-2 padding-0">
                                                                                <div class="text-center top-buffer-3"><img class="img-circle" width="46" height="46" src="{{ asset('img/avatars/'.$reviewer->avatar) }}"/></div>
                                                                                <div class="text-center top-buffer-10 ellipsis reviewer-name" itemprop="author">{{ $reviewer->displayName }}</div>
                                                                                <div class="text-center"><small>{{ $a->yes_helpful }} <i class="fa fa-thumbs-o-up"></i> de {{ $a->total_helpful }}</small></div>
                                                                                <?php
                                                                                    $ayes = $a->yes_helpful;
                                                                                    $noes = $a->total_helpful - $a->yes_helpful;
                                                                                    $helpSum = $ayes - $noes;
                                                                                    $checkPositive = ($helpSum >= 0) ? true : false;
                                                                                ?>
                                                                                @if($checkPositive)
                                                                                    <div class="text-center text-success"><small><i class="fa fa-plus"></i></small> {{ $helpSum }}</div>
                                                                                @else
                                                                                    <div class="text-center text-danger"><small><i class="fa fa-minus"></i></small> {{ abs($helpSum) }}</div>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-xs-12 col-sm-10 padding-0">
                                                                                <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                                                                                    <meta itemprop="worstRating" content="0">
                                                                                    <meta itemprop="ratingValue" content="{{ $a->value }}">
                                                                                    <meta itemprop="bestRating" content="5">
                                                                                    <div class="ratings-stars" data-score="{{ $a->value }}"><div class="inline-block float-right">{{ $a->created_at->format('d/m/Y') }}</div></div>
                                                                                    <div class="comment-text"><span itemprop="description">{{{ $a->comment }}}</span></div>
                                                                                    <div class="comment-isithelpful">
                                                                                        ¿Te ha resultado útil esta valoración?<br/>
                                                                                        <a href="javascript:" data-reviewId="{{ $a->id }}" class="btn btn-xs btn-link btn-yes @if(Auth::check()) itwashelpful @else trigger-login @endif ">
                                                                                            <i class="fa fa-thumbs-up"></i> @lang('buttons.yes')
                                                                                        </a>
                                                                                        <a href="javascript:" data-reviewId="{{ $a->id }}" class="btn btn-xs btn-link btn-no @if(Auth::check()) nothelpful @else trigger-login @endif ">
                                                                                            <i class="fa fa-thumbs-down"></i> @lang('buttons.no')
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                                <div class="text-right top-buffer-15">
                                                                    <a tabindex="1" type="button" class="btn btn-default" data-dismiss="modal">Volver</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- END all lessons review MODAL --}}
                                                @endif
                                            @endforeach
                                        @endif

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid background-gblack">
    <hr class="hr-page-end"/>
</div>

{{--Modal--}}
<div class="modal fade" id="modal-review" tabindex="-1" role="dialog" aria-labelledby="modal-review" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Valorar clase</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="POST" action="{{ URL::to('/review/lesson/') }}" accept-charset="UTF-8" id="form-review">
                    <input type="hidden" name="_token" value="{{ Session::getToken() }}">
                    <input type="hidden" id="form-lessonId" name="lessonId" value="-1">
                    <fieldset>
                        <div class="form-group">
                            <label for="score">Valoración (*)</label>
                            <div id="review-stars" data-score="3"></div>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comentario (*)</label>
                            <textarea rows="3" class="form-control" tabindex="1" placeholder="Comparte tu experiencia como estudiante" name="comment" id="review-comment" maxlength="255" required="required" data-error="Por favor, rellena este campo antes de enviar."></textarea>
                            <div id="rchars_feedback"></div>
                            <small><span class="help-block with-errors"></span></small>
                        </div>
                        <div class="form-group text-right top-buffer-15">
                            <button id="send-review" tabindex="2" type="submit" class="btn btn-milprofes">Enviar valoración</button>
                            <button tabindex="3" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

@endsection