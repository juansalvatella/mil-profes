@extends('layout')
@section('content')

<script type="text/javascript">
    $(document).ready(function() {
        function async_search() {
            var soForm = $('form#newSearchForm');
            var ninput = $('#current-slices-showing');
            ninput.val(0);
            $.post('/resultados',
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
                slices_showing: 0
                },
                function(data) { //handle the controller response
                    $('#price-tags').replaceWith($(data).find('#price-tags'));
                    $('#gmapDiv').replaceWith($(data).find('#gmapDiv'));
                    initialize_map(); //necesario tras cargar el código js del gmap de forma asíncrona
                    $('#results-main-content').replaceWith($(data).find('#results-main-content'));
            });
            ninput.val(1);
        }
        $(".radio").change(function(e){
            e.stopImmediatePropagation();
            async_search();
        });
    });
</script>

{{ Form::open(array('action' => 'SearchController@search', 'id' => 'newSearchForm')) }}

    <!-- Hidden form data -->
    {{ Form::hidden('user_lat', $user_lat) }}
    {{ Form::hidden('user_lon', $user_lon) }}
    {{ Form::hidden('slices_showing', $slices_showing, array('id' => 'current-slices-showing')) }}
    <!--/Hidden form data -->

    {{--sub-header search options--}}
    <div id="sub-header-menu" class="container-fluid">

        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                    <div class="">
                        <div class="">{{ Form::label('keywords', 'Busco clases de:') }}</div>
                    </div>
                    <div class="">
                        <div class="">{{ Form::text('keywords', $keywords, array('class'=>'form-control')) }}</div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                    <div class="">
                        <div class="">{{ Form::label('user_address', 'Estoy en:') }}</div>
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
                        {{ Form::submit('Encontrar',array('id'=>'btn-submit-search','class'=>'form-control mp-submit-find')) }}
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $(document).on("click", "#btn-submit-search", function(e) {
                                var ninput = $('#current-slices-showing');
                                ninput.val(0);
                                return true;
                            });
                        });
                    </script>
                </div>

            </div>
        </div>
    </div>

<div class="container-fluid">

    <div id="search-options-menu" class="col-xs-0 hidden-xs col-sm-0 hidden-sm col-md-2 well mp-shadow">
        <div id="search-options-menu-container">

            <div class="row text-center">
                {{ Form::label('', 'Quién enseña') }}
            </div>

            <div class="row">
                @if($prof_o_acad=='profesor')
                    <div class="radio"><label>{{ Form::radio('prof_o_acad', 'academia', false, array('id'=>'pa_1')) }} @lang('search.schools') </label></div>
                    <div class="radio"><label>{{ Form::radio('prof_o_acad', 'profesor', true, array('id'=>'pa_2')) }} @lang('search.teachers') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('prof_o_acad', 'academia', true, array('id'=>'pa_1')) }} @lang('search.schools') </label></div>
                    <div class="radio"><label>{{ Form::radio('prof_o_acad', 'profesor', false, array('id'=>'pa_2')) }} @lang('search.teachers') </label></div>
                @endif
            </div>

            <hr class="hr-sm-separator"/>

            <div class="row text-center top-buffer-15">
                {{ Form::label('search_distance', 'Distancia') }}
            </div>
            {{--GoogleMap--}}
            <div id="gmapDiv" class="row text-center">
                <div class="staticMap">
                    <img class="staticMapImg" src="{{{ $MapImgURL }}}" alt="Área de búsqueda"/>
                </div>
                <script type="text/javascript">
                    $(document).on("click", ".staticMapImg", function(e) {
                        e.stopImmediatePropagation();
                        $('.staticMap').hide();
                        $('.dynMap').removeClass('hidden');
                        initialize_map();
                    });
                </script>
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

            <div class="row text-center top-buffer-15">
                {{ Form::label('subject', 'Categorías') }}
            </div>

            <div class="row">
                @if($subject=='all')
                    <div class="radio"><label>{{ Form::radio('subject', 'all', true, array('id'=>'su_1')) }} @lang('search.all') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('subject', 'all', false, array('id'=>'su_1')) }} @lang('search.all') </label></div>
                @endif
                @if($subject=='escolar')
                    <div class="radio"><label>{{ Form::radio('subject', 'escolar', true, array('id'=>'su_2')) }} @lang('search.escolar') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('subject', 'escolar', false, array('id'=>'su_2')) }} @lang('search.escolar') </label></div>
                @endif
                @if($subject=='cfp')
                    <div class="radio"><label>{{ Form::radio('subject', 'cfp', true, array('id'=>'su_3')) }} @lang('search.cfp') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('subject', 'cfp', false, array('id'=>'su_3')) }} @lang('search.cfp') </label></div>
                @endif
                @if($subject=='universitario')
                    <div class="radio"><label>{{ Form::radio('subject', 'universitario', true, array('id'=>'su_4')) }} @lang('search.universitario') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('subject', 'universitario', false, array('id'=>'su_4')) }} @lang('search.universitario') </label></div>
                @endif
                @if($subject=='artes')
                    <div class="radio"><label>{{ Form::radio('subject', 'artes', true, array('id'=>'su_5')) }} @lang('search.artes') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('subject', 'artes', false, array('id'=>'su_5')) }} @lang('search.artes') </label></div>
                @endif
                @if($subject=='musica')
                    <div class="radio"><label>{{ Form::radio('subject', 'musica', true, array('id'=>'su_6')) }} @lang('search.musica') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('subject', 'musica', false, array('id'=>'su_6')) }} @lang('search.musica') </label></div>
                @endif
                @if($subject=='idiomas')
                    <div class="radio"><label>{{ Form::radio('subject', 'idiomas', true, array('id'=>'su_7')) }} @lang('search.idiomas') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('subject', 'idiomas', false, array('id'=>'su_7')) }} @lang('search.idiomas') </label></div>
                @endif
                @if($subject=='deportes')
                    <div class="radio"><label>{{ Form::radio('subject', 'deportes', true, array('id'=>'su_8')) }} @lang('search.deportes') </label></div>
                @else
                    <div class="radio"><label>{{ Form::radio('subject', 'deportes', false, array('id'=>'su_8')) }} @lang('search.deportes') </label></div>
                @endif
            </div>


            <hr class="hr-sm-separator"/>

            <div id="price-tags">

                @if($prof_o_acad=='profesor')

                    <div class="row text-center top-buffer-15">
                        {{ Form::label('price', 'Precios') }}
                    </div>

                    <div class="row text-left">
                        @if($price=='all')
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'all', true, array('id'=>'pr_1')) }} @lang('search.tprice1') </label></div>
                        @else
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'all', false, array('id'=>'pr_1')) }} @lang('search.tprice1') </label></div>
                        @endif
                        @if($price == 'rang0')
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang0', true, array('id'=>'pr_2')) }} @lang('search.tprice2') </label></div>
                        @else
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang0', false, array('id'=>'pr_2')) }} @lang('search.tprice2') </label></div>
                        @endif
                        @if($price== 'rang1')
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang1', true, array('id'=>'pr_3')) }} @lang('search.tprice3') </label></div>
                        @else
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang1', false, array('id'=>'pr_3')) }} @lang('search.tprice3') </label></div>
                        @endif
                        @if($price == 'rang2')
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang2', true, array('id'=>'pr_4')) }} @lang('search.tprice4') </label></div>
                        @else
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang2', false, array('id'=>'pr_4')) }} @lang('search.tprice4') </label></div>
                        @endif
                        @if($price == 'rang3')
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang3', true, array('id'=>'pr_5')) }} @lang('search.tprice5') </label></div>
                        @else
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang3', false, array('id'=>'pr_5')) }} @lang('search.tprice5') </label></div>
                        @endif
                        @if($price == 'rang4')
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang4', true, array('id'=>'pr_6')) }} @lang('search.tprice6') </label></div>
                        @else
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang4', false, array('id'=>'pr_6')) }} @lang('search.tprice6') </label></div>
                        @endif
                    </div>

                @else

                    <div class="row text-center top-buffer-15">
                        {{ Form::label('price', 'Precios') }}
                    </div>

                    <div class="row text-left">
                        @if($price=='all')
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'all', true, array('id'=>'pr_1')) }} @lang('search.sprice1') </label></div>
                        @else
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'all', false, array('id'=>'pr_1')) }} @lang('search.sprice1') </label></div>
                        @endif
                        @if($price == 'rang0')
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang0', true, array('id'=>'pr_2')) }} @lang('search.sprice2') </label></div>
                        @else
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang0', false, array('id'=>'pr_2')) }} @lang('search.sprice2') </label></div>
                        @endif
                        @if($price== 'rang1')
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang1', true, array('id'=>'pr_3')) }} @lang('search.sprice3') </label></div>
                        @else
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang1', false, array('id'=>'pr_3')) }} @lang('search.sprice3') </label></div>
                        @endif
                        @if($price == 'rang2')
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang2', true, array('id'=>'pr_4')) }} @lang('search.sprice4') </label></div>
                        @else
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang2', false, array('id'=>'pr_4')) }} @lang('search.sprice4') </label></div>
                        @endif
                        @if($price == 'rang3')
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang3', true, array('id'=>'pr_5')) }} @lang('search.sprice5') </label></div>
                        @else
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang3', false, array('id'=>'pr_5')) }} @lang('search.sprice5') </label></div>
                        @endif
                        @if($price == 'rang4')
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang4', true, array('id'=>'pr_6')) }} @lang('search.sprice6') </label></div>
                        @else
                            <div class="radio radio-price"><label>{{ Form::radio('price', 'rang4', false, array('id'=>'pr_6')) }} @lang('search.sprice6') </label></div>
                        @endif
                    </div>

                @endif

            </div>
            <script type="text/javascript">
                $(document).on("change", ".radio-price", function(e) {
                    e.stopImmediatePropagation();
                    var ninput = $('#current-slices-showing');
                    ninput.val(0);
                    var soForm = $('form#newSearchForm');
                    $.post('/resultados',
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
                            slices_showing: 0
                        },
                        function(data) { //handle the controller response
                            $('#price-tags').replaceWith($(data).find('#price-tags'));
                            $('#gmapDiv').replaceWith($(data).find('#gmapDiv'));
                            initialize_map(); //necesario tras cargar el código js del gmap de forma asíncrona
                            $('#results-main-content').replaceWith($(data).find('#results-main-content'));
                    });
                    ninput.val(1);
                });
            </script>

        </div>
    </div>

    {{ Form::close() }}

    <div class="col-xs-12 col-sm-10 col-md-8 co-lg-8" id="results-main-content">

        <div id="saveReviewAlertDiv" class="bb-alert alert alert-info" style="display:none;position: fixed;top: 25%;right: 0px;margin-bottom: 0px;font-size: 1.2em;padding: 1em 1.3em;z-index: 2000;">
            <span id="saveReviewAlert">Save review success/failure alert</span>
        </div>

        <div class="panel panel-default mp-shadow">
            <div class="panel-body search-total">
                <div class="row"><div class="col-xs-12">
                @if($total_results==0)
                    <span><strong>No se encontraron resultados</strong></span>
                @else
                    <span><strong>{{ $total_results }} @choice('search.results',$total_results) cerca de ti</strong></span>
                @endif
                </div></div>
            </div>
        </div>


        {{ Form::open(array('id' => 'aPostForm')) }}
        {{ Form::close() }}
        <div class="search-results-list">
            <div id="results-slice-{{ $slices_showing }}">
            @foreach($results as $result)
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="row search-image-container">
                            @if($prof_o_acad=='profesor')
                                <a href="{{ url('profe/'.$result->slug) }}"><img class="img-responsive img-thumbnail best-img" alt="{{ $result->username }}" src="{{ asset('img/avatars/'.$result->avatar) }}"/></a>
                            @else
                                <a href="{{ url('academia/'.$result->slug) }}"><img class="img-responsive img-thumbnail best-img" alt="{{ $result->name }}" src="{{ asset('img/logos/'.$result->logo) }}"/></a>
                            @endif
                        </div>
                        <div class="row text-center profile-link">
                            @if($prof_o_acad=='profesor')
                                <a href="{{ url('profe/'.$result->slug) }}">VER PERFIL</a>
                            @else
                                <a href="{{ url('academia/'.$result->slug) }}">VER PERFIL</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5 col-md-6">
                        <div class="row result-name">
                            @if($prof_o_acad=='profesor')
                                <span>{{{ $result->username }}}</span>
                            @else
                                <span>{{{ $result->name }}}</span>
                            @endif
                        </div>
                        <div class="row result-subject">
                            @if($prof_o_acad=='profesor')
                                <span class="span-subject-teacher">&nbsp;PROFE. @lang('search.of_subject_'.$result->subject)&nbsp;</span>
                            @else
                                <span class="span-subject-school">&nbsp;ACADEMIA @lang('search.of_subject_'.$result->subject)&nbsp;</span>
                            @endif
                        </div>
                        <div class="row result-distance">
                            Dentro de {{ $result->dist_to_user }} Km <img alt="marcador" src="{{ asset('../img/marcador-distancia.png') }}"/>
                        </div>
                        <div class="row result-description-title top-srs-separator">
                            @if($result->title == '')
                                DESCRIPCIÓN DE LA CLASE
                            @else
                                {{{ $result->title }}}
                            @endif
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
                                    <small><span class="pick"><span class="pick-day">&nbsp;{{ $pick->day }}&nbsp;</span> <span class="pick-time">&nbsp;{{ substr($pick->start,0,-3) }} - {{ substr($pick->end,0,-3) }}&nbsp;&nbsp;</span></span></small>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 hidden-md hidden-lg specialsep">
                                &nbsp;
                            </div>
                        </div>

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
                                        var aPostForm = $('form#aPostForm');
                                        @if($prof_o_acad=='profesor')
                                            $.post('/reviews/handleReview', {
                                                _token: aPostForm.find('input[name=_token]').val(),
                                                review_lesson_id: lesson_id,
                                                review_rating: review_rating
                                            }, function (data) {
                                                $('#lesson-stars-{{$result->id}}').raty({readOnly:true,half:true,score:review_rating});
                                            });
                                        @else
                                            $.post('/reviews/handleSchoolLessonReview', {
                                                _token: aPostForm.find('input[name=_token]').val(),
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
                                @if($prof_o_acad=='profesor')
                                    <div class="row no-price-provided">Contáctame<br>para saber<br>el precio</div>
                                @else
                                    <div class="row no-price-provided">Contáctanos<br>para saber<br>el precio</div>
                                @endif
                            @else
                                <div class="row price">
                                    {{{ $result->price }}} €
                                </div>
                                @if($prof_o_acad=='profesor')
                                    <div class="row per-unit">@lang('search.per_hour')</div>
                                @else
                                    <div class="row per-unit">@lang('search.per_course')</div>
                                @endif
                            @endif
                        </div>
                        <div class="row text-center top-buffer-15">
                                @if($prof_o_acad=='profesor')
                                    <a id="contact-me-{{ $result->id }}" class="btn btn-milprofes" role="button" data-toggle="popover" data-placement="top" title="Contacto">Contáctame</a>
                                @else
                                    <a id="contact-me-{{ $result->id }}" class="btn btn-milprofes" role="button" data-toggle="popover" data-placement="top" title="Contacto">Contáctanos</a>
                                @endif
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $("#contact-me-{{ $result->id }}").popover({
                                            html: true,
                                            content:    ''+
    @if($result->phone == '' && $result->email == '')  'Nuestra información de contacto aún no está disponible.'+ @endif
                            @if($result->phone != '')  '<div class="text-center contact-info-title1">Teléfono</div>'+
                                                        '<div class="text-center contact-info-tel">{{ $result->phone }}</div>'+ @endif
    @if($result->phone != '' && $result->email != '')   '<hr class="contact-info-hr">'+  @endif
                            @if($result->email != '')   '<div class="text-center contact-info-title2">E-mail</div><div class="arrow"></div>'+
                                                        '<div class="text-center contact-info-mail">{{ $result->email  }}</div>'+ @endif
                                                        ''
                                        });
                                    });
                                    $(document).on("click", "#contact-me-{{ $result->id }}", function(e) {
                                        e.preventDefault();
                                        e.stopImmediatePropagation();
                                        var aPostForm = $('form#aPostForm');
                                        @if($prof_o_acad=='profesor')
                                            $.post('/request/info/teacher/{{$result->id}}',{
                                                _token: aPostForm.find('input[name=_token]').val()
                                            },function(data){});
                                        @else
                                            $.post('/request/info/school/{{$result->id}}',{
                                                _token: aPostForm.find('input[name=_token]').val()
                                            },function(data){});
                                        @endif
                                    });
                                </script>
                        </div>
                    </div>
                </div>
                <!-- separator -->
                <div class="col-xs-12">
                    <div class="col-xs-offset-0 col-sm-offset-2 col-xs-12 col-sm-8 lessons-separator">&nbsp;</div>
                </div>
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
                    $.post('/resultados',
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

    </div><!--/.col-xs-8 /#results-main-content -->

</div><!--/.container-fluid-->

{{--Loader overlay--}}
<div class="modal-loading"></div>
<script type="text/javascript">
    $(document).ready(function() {
        $body = $("body");
        $(document).on({
            ajaxSend: function(evt, request, settings) {
                if(!settings.url.match('^/request/info/')) {
                    $body.addClass("loading");
                }
            },
            ajaxStop: function() { $body.removeClass("loading"); },
            ajaxError: function() { $body.removeClass("loading"); }
        });
    });
</script>
@stop