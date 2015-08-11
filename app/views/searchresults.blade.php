@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')

@endsection

@section('content')
    {{ Form::open(array('action' => 'SearchController@search', 'id' => 'newSearchForm')) }}

    {{ Form::hidden('user_lat', $user_lat) }}
    {{ Form::hidden('user_lon', $user_lon) }}
    {{ Form::hidden('slices_showing', $slices_showing, ['id' => 'current-slices-showing']) }}
    {{ Form::hidden('show_more', $show_more, ['id'=>'show-more']) }}

    <div id="sub-header-menu" class="container-fluid">

        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                    <div class="">
                        <div class="">{{ Form::label('keywords', trans('search.keywords-lbl')) }}</div>
                    </div>
                    <div class="">
                        <div class="">{{ Form::text('keywords', $keywords, array('class'=>'form-control')) }}</div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                    <div class="">
                        <div class="">{{ Form::label('user_address', trans('search.user_address-ph')) }}</div>
                    </div>
                    <div class="">
                        <div class="">{{ Form::text('user_address', $user_address, array('class'=>'form-control')) }}</div>
                    </div>
                </div>
                <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-4 col-md-2 col-lg-2">
                    <div class="top-buffer-4">
                        <div class="">{{ Form::label('', '') }}</div>
                    </div>
                    <div class="">
                        {{ Form::submit(trans('buttons.find'), array('id'=>'btn-submit-search','class'=>'form-control mp-submit-find')) }}
                    </div>
                </div>

            </div>
        </div>
    </div>

<div class="container-fluid">

    <div id="search-options-menu" class="col-xs-0 hidden-xs col-sm-0 hidden-sm col-md-2 well mp-shadow">
        <div id="search-options-menu-container">

            <div class="row text-center">
                {{ Form::label('', trans('search.who-teaches-lbl')) }}
            </div>

            <div class="row">
                @if($prof_o_acad=='profesor')
                    <div class="radio"><label>{{ Form::radio('prof_o_acad', trans('search.school'), false, array('id'=>'pa_1')) }} @lang('search.schools') </label></div>
                    <div class="radio"><label>{{ Form::radio('prof_o_acad', trans('search.teacher'), true, array('id'=>'pa_2')) }} @lang('search.teachers') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('prof_o_acad', trans('search.school'), true, array('id'=>'pa_1')) }} @lang('search.schools') </label></div>
                    <div class="radio"><label>{{ Form::radio('prof_o_acad', trans('search.teacher'), false, array('id'=>'pa_2')) }} @lang('search.teachers') </label></div>
                @endif
            </div>

            <hr class="hr-sm-separator"/>

            <div class="row text-center top-buffer-15">
                {{ Form::label('search_distance',  trans('search.distance-lbl')) }}
            </div>
            {{--GoogleMap--}}
            <div id="gmapDiv" class="row text-center">
                <div class="staticMap">
                    <img class="staticMapImg" src="{{{ $MapImgURL }}}" alt="@lang('search.static-img-alt')"/>
                </div>
                <div class="dynMap hidden">
                    {{ $gmap['js'] }}
                    {{ $gmap['html'] }}
                </div>
            </div>

            <div class="row">
                @if($search_distance=='rang0')
                    <div class="radio"><label>{{ Form::radio('search_distance', 'rang0', true, array('id'=>'sd_1')) }} @lang('search.distance1') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('search_distance', 'rang0', false, array('id'=>'sd_1')) }} @lang('search.distance1') </label></div>
                @endif
                @if($search_distance=='rang1')
                    <div class="radio"><label>{{ Form::radio('search_distance', 'rang1', true, array('id'=>'sd_2')) }} @lang('search.distance2') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('search_distance', 'rang1', false, array('id'=>'sd_2')) }} @lang('search.distance2') </label></div>
                @endif
                @if($search_distance=='rang2')
                    <div class="radio"><label>{{ Form::radio('search_distance', 'rang2', true, array('id'=>'sd_3')) }} @lang('search.distance3') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('search_distance', 'rang2', false, array('id'=>'sd_3')) }} @lang('search.distance3') </label></div>
                @endif
            </div>

            <hr class="hr-sm-separator"/>

            <div id="price-tags">
                <div class="row text-center top-buffer-15">
                    {{ Form::label('price', trans('search.prices')) }}
                </div>
                @if($prof_o_acad=='profesor')
                <div class="row text-left">
                    @if($price=='all')
                        <div class="radio"><label>{{ Form::radio('price', 'all', true, array('id'=>'pr_1')) }} @lang('search.tprice1') </label></div>
                    @else
                        <div class="radio"><label>{{ Form::radio('price', 'all', false, array('id'=>'pr_1')) }} @lang('search.tprice1') </label></div>
                    @endif
                    @if($price == 'rang0')
                        <div class="radio"><label>{{ Form::radio('price', 'rang0', true, array('id'=>'pr_2')) }} @lang('search.tprice2') </label></div>
                    @else
                        <div class="radio"><label>{{ Form::radio('price', 'rang0', false, array('id'=>'pr_2')) }} @lang('search.tprice2') </label></div>
                    @endif
                    @if($price== 'rang1')
                        <div class="radio"><label>{{ Form::radio('price', 'rang1', true, array('id'=>'pr_3')) }} @lang('search.tprice3') </label></div>
                    @else
                        <div class="radio"><label>{{ Form::radio('price', 'rang1', false, array('id'=>'pr_3')) }} @lang('search.tprice3') </label></div>
                    @endif
                    @if($price == 'rang2')
                        <div class="radio"><label>{{ Form::radio('price', 'rang2', true, array('id'=>'pr_4')) }} @lang('search.tprice4') </label></div>
                    @else
                        <div class="radio"><label>{{ Form::radio('price', 'rang2', false, array('id'=>'pr_4')) }} @lang('search.tprice4') </label></div>
                    @endif
                    @if($price == 'rang3')
                        <div class="radio"><label>{{ Form::radio('price', 'rang3', true, array('id'=>'pr_5')) }} @lang('search.tprice5') </label></div>
                    @else
                        <div class="radio"><label>{{ Form::radio('price', 'rang3', false, array('id'=>'pr_5')) }} @lang('search.tprice5') </label></div>
                    @endif
                    @if($price == 'rang4')
                        <div class="radio"><label>{{ Form::radio('price', 'rang4', true, array('id'=>'pr_6')) }} @lang('search.tprice6') </label></div>
                    @else
                        <div class="radio"><label>{{ Form::radio('price', 'rang4', false, array('id'=>'pr_6')) }} @lang('search.tprice6') </label></div>
                    @endif
                </div>
                @else
                <div class="row text-left">
                    @if($price=='all')
                        <div class="radio"><label>{{ Form::radio('price', 'all', true, array('id'=>'pr_1')) }} @lang('search.sprice1') </label></div>
                    @else
                        <div class="radio"><label>{{ Form::radio('price', 'all', false, array('id'=>'pr_1')) }} @lang('search.sprice1') </label></div>
                    @endif
                    @if($price == 'rang0')
                        <div class="radio"><label>{{ Form::radio('price', 'rang0', true, array('id'=>'pr_2')) }} @lang('search.sprice2') </label></div>
                    @else
                        <div class="radio"><label>{{ Form::radio('price', 'rang0', false, array('id'=>'pr_2')) }} @lang('search.sprice2') </label></div>
                    @endif
                    @if($price== 'rang1')
                        <div class="radio"><label>{{ Form::radio('price', 'rang1', true, array('id'=>'pr_3')) }} @lang('search.sprice3') </label></div>
                    @else
                        <div class="radio"><label>{{ Form::radio('price', 'rang1', false, array('id'=>'pr_3')) }} @lang('search.sprice3') </label></div>
                    @endif
                    @if($price == 'rang2')
                        <div class="radio"><label>{{ Form::radio('price', 'rang2', true, array('id'=>'pr_4')) }} @lang('search.sprice4') </label></div>
                    @else
                        <div class="radio"><label>{{ Form::radio('price', 'rang2', false, array('id'=>'pr_4')) }} @lang('search.sprice4') </label></div>
                    @endif
                    @if($price == 'rang3')
                        <div class="radio"><label>{{ Form::radio('price', 'rang3', true, array('id'=>'pr_5')) }} @lang('search.sprice5') </label></div>
                    @else
                        <div class="radio"><label>{{ Form::radio('price', 'rang3', false, array('id'=>'pr_5')) }} @lang('search.sprice5') </label></div>
                    @endif
                    @if($price == 'rang4')
                        <div class="radio"><label>{{ Form::radio('price', 'rang4', true, array('id'=>'pr_6')) }} @lang('search.sprice6') </label></div>
                    @else
                        <div class="radio"><label>{{ Form::radio('price', 'rang4', false, array('id'=>'pr_6')) }} @lang('search.sprice6') </label></div>
                    @endif
                </div>
                @endif
            </div>

            <hr class="hr-sm-separator"/>

            <div class="row text-center top-buffer-15">
                {{ Form::label('subject',  trans('search.subjects')) }}
            </div>

            <div class="row">
                <div class="radio"><label>{{ Form::radio('subject', 'all', ($subject=='all'), array('id'=>'su_1')) }} @lang('subjects.all') </label></div>
                <?php $k=2; ?>
                @foreach(Subject::orderBy('name')->get() as $subj)
                    <div class="radio"><label>{{ Form::radio('subject', $subj->name, ($subject==$subj->name), array('id'=>'su_'.$k)) }} @lang('subjects.'.$subj->name) </label></div>
                    <?php ++$k; ?>
                @endforeach
            </div>

        </div>
    </div>

    {{ Form::close() }}

    <div class="col-xs-12 col-sm-10 col-md-8 co-lg-8" id="results-main-content">

        <div id="results-info" class="panel panel-default mp-shadow">
            <div class="panel-body search-total">
                <div class="row"><div class="col-xs-12">
                @if($prof_o_acad=='profesor')
                    @if($total_results==0)
                        <span><strong>@lang('search.no-teachers-found')</strong></span>
                    @else
                        <span><strong>{{ $total_results }} @choice('search.found-teachers',$total_results) @lang('search.close-to-you')</strong></span>
                    @endif
                @else
                    @if($total_results==0)
                        <span><strong>@lang('search.no-schools-found')</strong></span>
                    @else
                        <span><strong>{{ $total_results }} @choice('search.found-schools',$total_results) @lang('search.close-to-you')</strong></span>
                    @endif
                @endif
                </div></div>
            </div>
        </div>

        <div class="search-results-list" style="position:relative;">
        @foreach($results as $result)
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3">
                    <div class="row search-image-container">
                        @if($prof_o_acad=='profesor')
                            <a href="{{ route('profiles-teacher',['user_slug'=>$result->slug,'clase'=>$result->id]) }}"><img class="img-responsive img-thumbnail best-img" alt="{{{ $result->displayName }}}" src="{{ asset('img/avatars/'.$result->avatar) }}"/></a>
                        @else
                            <a href="{{ route('profiles-school',['school_slug'=>$result->slug,'curso'=>$result->id]) }}"><img class="img-responsive img-thumbnail best-img" alt="{{ $result->name }}" src="{{ asset('img/logos/'.$result->logo) }}"/></a>
                        @endif
                    </div>
                    <div class="text-center profile-link-name">
                        @if($prof_o_acad=='profesor')
                            <a href="{{ route('profiles-teacher',['user_slug'=>$result->slug,'clase'=>$result->id]) }}">{{{ $result->displayName }}}</a>
                        @else
                            <a href="{{ route('profiles-school',['school_slug'=>$result->slug,'curso'=>$result->id]) }}">{{{ $result->name }}}</a>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 col-md-6">
                    <div class="row lesson-name">
                    @if($result->title == '')
                        @if($prof_o_acad=='profesor')
                            @lang('teacher-profile.lesson_of') @lang('subjects.'.$result->subject)
                        @else
                            @lang('school-profile.lesson_of') @lang('subjects.'.$result->subject)
                        @endif
                    @else
                        {{{ $result->title }}}
                    @endif
                    </div>
                    <div class="row result-subject">
                        @if($prof_o_acad=='profesor')
                            <span class="span-subject-teacher">&nbsp;@lang('subjects.'.$result->subject)&nbsp;</span>
                        @else
                            <span class="span-subject-school">&nbsp;@lang('subjects.'.$result->subject)&nbsp;</span>
                        @endif
                    </div>
                    <div class="row result-distance">
                        @lang('search.within') {{ $result->dist_to_user }} @lang('search.distance-unit') <img alt="marcador" src="{{ asset('../img/marcador-distancia.png') }}"/>
                    </div>
                    <div class="row result-description-title top-srs-separator">
                        @lang('search.DESCRIPTION')
                    </div>
                    <div class="row result-description bottom-srs-separator">
                        <small>{{{ $result->description }}}</small>
                    </div>
                    <div class="row result-availability-title">
                        @if(!$result->availability->isEmpty())
                            @if($result->availability->first()->day != '')
                                @lang('search.AVAILABILITY')
                            @endif
                        @endif
                    </div>
                    <div class="row result-availability">
                        @foreach($result->availability as $pick)
                            @if($pick->day != '')
                                <small><span class="pick"><span class="pick-day">&nbsp;{{ $pick->day }}&nbsp;</span> <span class="pick-time">&nbsp;{{ substr($pick->start,0,-3) }} - {{ substr($pick->end,0,-3) }}&nbsp;&nbsp;</span></span></small>
                            @endif
                        @endforeach
                    </div>
                    @if($result->aggregated > 1)
                    <div class="row result-aggregated">
                        @if($prof_o_acad=='profesor')
                            <a class="btn btn-default btn-sm" href="{{ route('profiles-teacher',['user_slug'=>$result->slug,'clase'=>$result->id]) }}"><i class="fa fa-search-plus"></i> @lang('search.see') {{ $result->aggregated-1 }} @choice('search.lessons',$result->aggregated-1) @lang('search.more-of') {{ $result->displayName }} @lang('search.that') @choice('search.may',$result->aggregated-1) @lang('search.interest-you').</a>
                        @else
                            <a class="btn btn-default btn-sm" href="{{ route('profiles-school',['school_slug'=>$result->slug,'curso'=>$result->id]) }}"><i class="fa fa-search-plus"></i> Ver {{ $result->aggregated-1 }} @choice('search.courses',$result->aggregated-1) @lang('search.more-of') {{ $result->name }} @lang('search.that') @choice('search.may',$result->aggregated-1) @lang('search.interest-you').</a>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 hidden-md hidden-lg specialsep">
                            &nbsp;
                        </div>
                    </div>
                    <div class="row text-center lesson-stars-container">
                        <span class="lesson-stars" data-pk="{{ $result->id }}" data-score="{{ $result->lesson_avg_rating }}"></span>
                    </div>
                    <div class="row text-center">
                        @if($result->price=='0')
                            @if($prof_o_acad=='profesor')
                                <div class="row no-price-provided">@lang('search.t-price-unknown')</div>
                            @else
                                <div class="row no-price-provided">@lang('search.s-price-unknown')</div>
                            @endif
                        @else
                            <div class="row price">
                                {{-- + 0 removes zeros to the right of decimal separator --}}
                                {{{ str_replace('.', ',', $result->price + 0) }}}
                            </div>
                            @if($prof_o_acad=='profesor')
                                <div class="row per-unit">@lang('search.unit_per_hour')</div>
                            @else
                                <div class="row per-unit">@lang('search.unit_per_course')</div>
                            @endif
                        @endif
                    </div>
                    <div class="row text-center top-buffer-15">
                        @if($prof_o_acad=='profesor')
                            <a id="contact-me-{{ $result->id }}" href="{{ route('profiles-teacher',['user_slug'=>$result->slug,'clase'=>$result->id]) }}" class="btn btn-milprofes">@lang('search.t-contact-me')</a>
                        @else
                            <a id="contact-me-{{ $result->id }}" href="{{ route('profiles-school',['school_slug'=>$result->slug,'curso'=>$result->id]) }}" class="btn btn-milprofes">@lang('search.s-contact-me')</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-offset-0 col-sm-offset-2 col-xs-12 col-sm-8 lessons-separator">&nbsp;</div>
            </div>
        @endforeach
        </div>
        <div class="row">
            <div class="col-xs-12 text-center" id="loading-more">
                <img id="loading-more-img" class="hidden" height="15" width="15" src="{{ asset('img/infoloader.gif') }}">
            </div>
        </div>
    </div>
</div>

@endsection

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function() {
            SearchResults.init();
        });
    </script>
@endsection
