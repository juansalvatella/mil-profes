@extends('layout')
@section('content')

    <script type="text/javascript">
        $(document).ready(function() {
            function async_search() {
                var soForm = $('form#newSearchForm');
                var ninput = $('#current-slices-showing');
                ninput.val(0);
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
                    slices_showing: 0
                    },
                    function(data) { //handle the controller response
                      //$('.search-total').replaceWith($(data).find('.search-total'));
                      //$('.search-results-list').replaceWith($(data).find('.search-results-list'));
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
    <div class="row text-center">
        <div class="form-inline">
            <div class="form-group">
                <div class="sub-header-label">{{ Form::label('keywords', 'Busco clases de:') }}</div>
                <div class="sub-header-textbox">{{ Form::text('keywords', $keywords) }}</div>
            </div>
            <div class="form-group">
                <div class="sub-header-label">{{ Form::label('user_address', 'Estoy en:') }}</div>
                <div class="sub-header-textbox">{{ Form::text('user_address', $user_address) }}</div>
            </div>
            {{ Form::submit('Encontrar',array('id'=>'btn-submit-search')) }}
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

<div class="container-fluid">
    <div id="search-options-menu" class="col-xs-0 col-sm-2 well">
        <div id="search-options-menu-container">

            <div class="form-group">
                {{ Form::label('', 'Quién enseña') }}
                @if($prof_o_acad=='profesor')
                    <div class="radio">{{ Form::radio('prof_o_acad', 'academia', false, array('id'=>'pa_1')) }}{{ Form::label('pa_1', 'Academias') }}</div>
                    <div class="radio">{{ Form::radio('prof_o_acad', 'profesor', true, array('id'=>'pa_2')) }}{{ Form::label('pa_2', 'Profes.') }}</div>
                @else
                    <div class="radio">{{ Form::radio('prof_o_acad', 'academia', true, array('id'=>'pa_1')) }}{{ Form::label('pa_1', 'Academias') }}</div>
                    <div class="radio">{{ Form::radio('prof_o_acad', 'profesor', false, array('id'=>'pa_2')) }}{{ Form::label('pa_2', 'Profes.') }}</div>
                @endif
            </div>

            <div class="form-group">
                <div class="radio">
                    {{ Form::label('search_distance', 'Distancia') }}

                    {{--GoogleMap--}}
                    <div id="gmapDiv" class="row">
                        {{ $gmap['js'] }}
                        {{ $gmap['html'] }}
                    </div>

                    @if($search_distance=='rang0')
                        <div class="radio">{{ Form::radio('search_distance', 'rang0', true, array('id'=>'sd_1')) }}{{ Form::label('sd_1', '< 2 Km') }}</div>
                    @else
                        <div class="radio">{{ Form::radio('search_distance', 'rang0', false, array('id'=>'sd_1')) }}{{ Form::label('sd_1', '< 2 Km') }}</div>
                    @endif
                    @if($search_distance=='rang1')
                        <div class="radio">{{ Form::radio('search_distance', 'rang1', true, array('id'=>'sd_2')) }}{{ Form::label('sd_2', '< 5 Km') }}</div>
                    @else
                        <div class="radio">{{ Form::radio('search_distance', 'rang1', false, array('id'=>'sd_2')) }}{{ Form::label('sd_2', '< 5 Km') }}</div>
                    @endif
                    @if($search_distance=='rang2')
                        <div class="radio">{{ Form::radio('search_distance', 'rang2', true, array('id'=>'sd_3')) }}{{ Form::label('sd_3', '< 20 Km') }}</div>
                    @else
                        <div class="radio">{{ Form::radio('search_distance', 'rang2', false, array('id'=>'sd_3')) }}{{ Form::label('sd_3', '< 20 Km') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('subject', 'Categorías') }}
                @if($subject=='all')
                    <div class="radio">{{ Form::radio('subject', 'all', true, array('id'=>'su_1')) }}{{ Form::label('su_1', 'Todas') }}</div>
                @else
                    <div class="radio">{{ Form::radio('subject', 'all', false, array('id'=>'su_1')) }}{{ Form::label('su_1', 'Todas') }}</div>
                @endif
                @if($subject=='escolar')
                    <div class="radio">{{ Form::radio('subject', 'escolar', true, array('id'=>'su_2')) }}{{ Form::label('su_2', 'Escolar') }}</div>
                @else
                    <div class="radio">{{ Form::radio('subject', 'escolar', false, array('id'=>'su_2')) }}{{ Form::label('su_2', 'Escolar') }}</div>
                @endif
                @if($subject=='cfp')
                    <div class="radio">{{ Form::radio('subject', 'cfp', true, array('id'=>'su_3')) }}{{ Form::label('su_3', 'CFP') }}</div>
                @else
                    <div class="radio">{{ Form::radio('subject', 'cfp', false, array('id'=>'su_3')) }}{{ Form::label('su_3', 'CFP') }}</div>
                @endif
                @if($subject=='universitario')
                    <div class="radio">{{ Form::radio('subject', 'universitario', true, array('id'=>'su_4')) }}{{ Form::label('su_4', 'Universitario') }}</div>
                @else
                    <div class="radio">{{ Form::radio('subject', 'universitario', false, array('id'=>'su_4')) }}{{ Form::label('su_4', 'Universitario') }}</div>
                @endif
                @if($subject=='artes')
                    <div class="radio">{{ Form::radio('subject', 'artes', true, array('id'=>'su_5')) }}{{ Form::label('su_5', 'Artes') }}</div>
                @else
                    <div class="radio">{{ Form::radio('subject', 'artes', false, array('id'=>'su_5')) }}{{ Form::label('su_5', 'Artes') }}</div>
                @endif
                @if($subject=='musica')
                    <div class="radio">{{ Form::radio('subject', 'musica', true, array('id'=>'su_6')) }}{{ Form::label('su_6', 'Música') }}</div>
                @else
                    <div class="radio">{{ Form::radio('subject', 'musica', false, array('id'=>'su_6')) }}{{ Form::label('su_6', 'Música') }}</div>
                @endif
                @if($subject=='idiomas')
                    <div class="radio">{{ Form::radio('subject', 'idiomas', true, array('id'=>'su_7')) }}{{ Form::label('su_7', 'Idiomas') }}</div>
                @else
                    <div class="radio">{{ Form::radio('subject', 'idiomas', false, array('id'=>'su_7')) }}{{ Form::label('su_7', 'Idiomas') }}</div>
                @endif
                @if($subject=='deportes')
                    <div class="radio">{{ Form::radio('subject', 'deportes', true, array('id'=>'su_8')) }}{{ Form::label('su_8', 'Deportes') }}</div>
                @else
                    <div class="radio">{{ Form::radio('subject', 'deportes', false, array('id'=>'su_8')) }}{{ Form::label('su_8', 'Deportes') }}</div>
                @endif
            </div>
            <div id="price-tags">
                <div class="form-group">
                    @if($prof_o_acad=='profesor')
                        {{ Form::label('price', 'Precios') }}
                        @if($price=='all')
                            <div class="radio-price">{{ Form::radio('price', 'all', true, array('id'=>'pr_1')) }}{{ Form::label('pr_1', 'Todos') }}</div>
                        @else
                            <div class="radio-price">{{ Form::radio('price', 'all', false, array('id'=>'pr_1')) }}{{ Form::label('pr_1', 'Todos') }}</div>
                        @endif
                        @if($price == 'rang0')
                            <div class="radio-price">{{ Form::radio('price', 'rang0', true, array('id'=>'pr_2')) }}{{ Form::label('pr_2', 'Menos de 10€') }} </div>
                        @else
                            <div class="radio-price">{{ Form::radio('price', 'rang0', false, array('id'=>'pr_2')) }}{{ Form::label('pr_2', 'Menos de 10€') }} </div>
                        @endif
                        @if($price== 'rang1')
                            <div class="radio-price">{{ Form::radio('price', 'rang1', true, array('id'=>'pr_3')) }}{{ Form::label('pr_3', '10 - 30€') }} </div>
                        @else
                            <div class="radio-price">{{ Form::radio('price', 'rang1', false, array('id'=>'pr_3')) }}{{ Form::label('pr_3', '10 - 30€') }} </div>
                        @endif
                        @if($price == 'rang2')
                            <div class="radio-price">{{ Form::radio('price', 'rang2', true, array('id'=>'pr_4')) }}{{ Form::label('pr_4', '30 - 50€') }} </div>
                        @else
                            <div class="radio-price">{{ Form::radio('price', 'rang2', false, array('id'=>'pr_4')) }}{{ Form::label('pr_4', '30 - 50€') }} </div>
                        @endif
                        @if($price == 'rang3')
                            <div class="radio-price">{{ Form::radio('price', 'rang3', true, array('id'=>'pr_5')) }}{{ Form::label('pr_5', '50 - 100€') }} </div>
                        @else
                            <div class="radio-price">{{ Form::radio('price', 'rang3', false, array('id'=>'pr_5')) }}{{ Form::label('pr_5', '50 - 100€') }} </div>
                        @endif
                        @if($price == 'rang4')
                            <div class="radio-price">{{ Form::radio('price', 'rang4', true, array('id'=>'pr_6')) }}{{ Form::label('pr_6', 'Más de 100€') }} </div>
                        @else
                            <div class="radio-price">{{ Form::radio('price', 'rang4', false, array('id'=>'pr_6')) }}{{ Form::label('pr_6', 'Más de 100€') }} </div>
                        @endif
                    @else
                        {{ Form::label('price', 'Precios') }}
                        @if($price=='all')
                            <div class="radio-price">{{ Form::radio('price', 'all', true, array('id'=>'pr_1')) }}{{ Form::label('pr_1', 'Todos') }}</div>
                        @else
                            <div class="radio-price">{{ Form::radio('price', 'all', false, array('id'=>'pr_1')) }}{{ Form::label('pr_1', 'Todos') }}</div>
                        @endif
                        @if($price == 'rang0')
                            <div class="radio-price">{{ Form::radio('price', 'rang0', true, array('id'=>'pr_2')) }}{{ Form::label('pr_2', 'Menos de 150€') }} </div>
                        @else
                            <div class="radio-price">{{ Form::radio('price', 'rang0', false, array('id'=>'pr_2')) }}{{ Form::label('pr_2', 'Menos de 150€') }} </div>
                        @endif
                        @if($price== 'rang1')
                            <div class="radio-price">{{ Form::radio('price', 'rang1', true, array('id'=>'pr_3')) }}{{ Form::label('pr_3', '150 - 350€') }} </div>
                        @else
                            <div class="radio-price">{{ Form::radio('price', 'rang1', false, array('id'=>'pr_3')) }}{{ Form::label('pr_3', '150 - 350€') }} </div>
                        @endif
                        @if($price == 'rang2')
                            <div class="radio-price">{{ Form::radio('price', 'rang2', true, array('id'=>'pr_4')) }}{{ Form::label('pr_4', '350 - 500€') }} </div>
                        @else
                            <div class="radio-price">{{ Form::radio('price', 'rang2', false, array('id'=>'pr_4')) }}{{ Form::label('pr_4', '350 - 500€') }} </div>
                        @endif
                        @if($price == 'rang3')
                            <div class="radio-price">{{ Form::radio('price', 'rang3', true, array('id'=>'pr_5')) }}{{ Form::label('pr_5', '500 - 1500€') }} </div>
                        @else
                            <div class="radio-price">{{ Form::radio('price', 'rang3', false, array('id'=>'pr_5')) }}{{ Form::label('pr_5', '500 - 1500€') }} </div>
                        @endif
                        @if($price == 'rang4')
                            <div class="radio-price">{{ Form::radio('price', 'rang4', true, array('id'=>'pr_6')) }}{{ Form::label('pr_6', 'Más de 1500€') }} </div>
                        @else
                            <div class="radio-price">{{ Form::radio('price', 'rang4', false, array('id'=>'pr_6')) }}{{ Form::label('pr_6', 'Más de 1500€') }} </div>
                        @endif
                    @endif
                    <script type="text/javascript">
                        $(document).on("change", ".radio-price", function(e) {
                            e.stopImmediatePropagation();
                            var ninput = $('#current-slices-showing');
                            ninput.val(0);
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
                                    slices_showing: 0
                                },
                                function(data) { //handle the controller response
//                                    $('.search-total').replaceWith($(data).find('.search-total'));
//                                    $('.search-results-list').replaceWith($(data).find('.search-results-list'));
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
        </div>
    </div>
    {{ Form::close() }}

        <div class="col-xs-8" id="results-main-content">

            <div id="saveReviewAlertDiv" class="bb-alert alert alert-info" style="display:none;position: fixed;top: 25%;right: 0px;margin-bottom: 0px;font-size: 1.2em;padding: 1em 1.3em;z-index: 2000;">
                <span id="saveReviewAlert">Save review success/failure alert</span>
            </div>

            <!--results-->
            {{--<div class="search-total">--}}
                {{--{{ $results->count() }} @choice('search.'.$prof_o_acad,$results->count()) {{ @trans('search.'.$subject) }} @choice('search.'.$prof_o_acad.'_found',$results->count())--}}
            {{--</div>--}}

            <div class="panel panel-default search-total">
                <div class="panel-body">
                    @if($total_results==0)
                        No se encontraron resultados
                    @else
                        {{ $total_results }} @choice('search.results',$total_results) cerca de ti
                    @endif
                </div>
            </div>

            <div class="search-results-list">
                <div id="results-slice-{{ $slices_showing }}">
                @foreach($results as $result)
                    <div class="row">
                        <div class="col-xs-12">
                            Distance to  user = within {{ $result->dist_to_user }} Km
                        </div>
                        <div class="col-xs-12">
                            Avatar/logo:
                            @if($prof_o_acad=='profesor')
                                <img src="{{ asset('img/avatars/'.$result->avatar) }}" class="img-thumbnail" style="min-height: 50px;height: 50px;min-width: 50px;width: 50px;">
                            @else
                                <img src="{{ asset('img/logos/'.$result->logo) }}" class="img-thumbnail" style="min-height: 50px;height: 50px;min-width: 50px;width: 50px;">
                            @endif
                        </div>
                        <div class="col-xs-12">
                            @if($prof_o_acad=='profesor')
                                Nombre profesor: {{ $result->username }}
                            @else
                                Nombre academia: {{ $result->name }}
                            @endif
                        </div>
                            <div class="col-xs-12">
                                @if($prof_o_acad=='profesor')
                                    Teacher rating: {{ $result->teacher_avg_rating }} <span id="teacher-stars-{{$result->id}}"></span>
                                    <script type="text/javascript">
                                        $('#teacher-stars-{{$result->id}}').raty({ readOnly: true, score: {{ $result->teacher_avg_rating }} });
                                    </script>
                                @else
                                    School rating: {{ $result->school_avg_rating }} <span id="school-stars-{{$result->id}}"></span>
                                    <script type="text/javascript">
                                        $('#school-stars-{{$result->id}}').raty({ readOnly: true, score: {{ $result->school_avg_rating }} });
                                    </script>
                                @endif

                            </div>

                        <div class="col-xs-12">
                            Descripción de la clase: {{ $result->description }}
                        </div>
                        <div class="col-xs-12">
                            Email: {{ $result->email }}
                        </div>
                        <div class="col-xs-12">
                            Tlf.: <span id="thisPhone-{{$result->id}}">{{ $result->phone }}</span>
                            {{--<a href="#" id="buttonDescubrir-{{$result->id}}" class="btn btn-info">Ver teléfono</a>--}}
                            {{--<script type="text/javascript">--}}
                                {{--$(document).on("click", "#buttonDescubrir-{{$result->id}}", function(e) {--}}
                                    {{--e.preventDefault();--}}
                                    {{--e.stopImmediatePropagation();--}}
                                {{--@if($prof_o_acad=='profesor')--}}
                                    {{--$.post('/phoneHandler/t_phone/{{$result->id}}', null,--}}
                                {{--@else--}}
                                    {{--$.post('/phoneHandler/s_phone/{{$result->id}}', null,--}}
                                {{--@endif--}}
                                        {{--function (phone) { //handle the controller response--}}
                                            {{--$('#thisPhone-{{$result->id}}').replaceWith(phone);--}}
                                        {{--}--}}
                                    {{--);--}}
                                {{--});--}}
                            {{--</script>--}}
                        </div>
                        <div class="col-xs-12">
                            Precio de la clase: {{ $result->price }}
                            @if($prof_o_acad=='profesor')
                                €/hora
                            @else
                                €/curso
                            @endif
                        </div>
                        <div class="col-xs-12">
                            @if($prof_o_acad=='profesor')
                                Lesson rating: {{ $result->lesson_avg_rating }} <span id="lesson-stars-{{$result->id}}"></span>
                                <script type="text/javascript">
                                    $('#lesson-stars-{{$result->id}}').raty({ readOnly: true, score: {{ $result->lesson_avg_rating }} });
                                </script>
                            @else
                                Lesson rating: {{ $result->lesson_avg_rating }} <span id="schoolLesson-stars-{{$result->id}}"></span>
                                <script type="text/javascript">
                                    $('#schoolLesson-stars-{{$result->id}}').raty({ readOnly: true, score: {{ $result->lesson_avg_rating }} });
                                </script>
                            @endif
                        </div>
                        <div class="col-xs-12">
                            {{ $result->number_of_reviews }} valoraciones
                        </div>
                        {{--<div class="col-xs-12">--}}
                            {{--Horario: {{ $result->availability }}--}}
                        {{--</div>--}}
                        <div class="col-xs-12">
                            <a href="#" id="rate-lesson-{{ $result->id }}" class="btn btn-info">Valorar clase</a>
                            <script type="text/javascript">
                                $(document).on("click", "#rate-lesson-{{ $result->id }}", function(e) {
                                    e.preventDefault();
                                    e.stopImmediatePropagation();
                                    bootbox.dialog({
                                        @if($prof_o_acad=='profesor')
                                        title: "¿Qué te ha parecido la clase de {{ $result->username }}?",
                                        @else
                                        title: "¿Qué te ha parecido la clase de {{ $result->name }}?",
                                        @endif
                                        message: '<div class="row"> ' +
                                                    '<div class="col-md-12"> ' +
                                                        '<form id="review-form-{{ $result->id }}" class="form-horizontal"> ' +
                                                        '<input type="hidden" name="_token" id="token-{{ $result->id }}" value="{{{ Session::getToken() }}}"> ' +
                                                            '<div class="form-group"> ' +
                                                                '<label class="col-md-4 control-label" for="review-comment-{{ $result->id }}">Mi comentario:</label> ' +
                                                                '<div class="col-md-8"> ' +
                                                                    '<textarea id="review-comment-{{ $result->id }}" name="review-comment-{{ $result->id }}" type="text" class="form-control input-md" rows="4"></textarea> ' +
                                                                '</div> ' +
                                                            '</div> ' +
                                                            '<div class="form-group"> ' +
                                                                '<label class="col-md-4 control-label" for="review-rating-{{ $result->id }}">Mi valoración:</label> ' +
                                                                '<div class="col-md-8"> ' +
                                                                    '<span id="review-rating-{{$result->id}}"></span>' +
                                                                '</div> ' +
                                                            '</div>' +
                                                        '</form> ' +
                                                    '</div> ' +
                                                '</div>',
                                        buttons: {
                                            success: {
                                                label: "Enviar valoración",
                                                className: "btn-success",
                                                callback: function () {
                                                    //registrar valoración en base de datos
                                                    var token = $('input#token-{{ $result->id }}').val();
                                                    var lesson_id = {{ $result->id }};
                                                    var review_comment = $('textarea#review-comment-{{$result->id}}').val();
                                                    var review_rating = $('#review-rating-{{$result->id}}').raty('score');
                                                @if($prof_o_acad=='profesor')
                                                    $.post('/reviews/handleReview',
                                                @else
                                                    $.post('/reviews/handleSchoolLessonReview',
                                                @endif
                                                        {
                                                            _token: token,
                                                            review_lesson_id: lesson_id,
                                                            review_comment: review_comment,
                                                            review_rating: review_rating
                                                        },
                                                        function(data){ //handle the controller response
                                                            if(data==1)
                                                            {
                                                                saveAlert("Tu valoración ha sido guardada");
                                                            }
                                                            else
                                                            {
                                                                saveAlert("No se ha podido guardar tu valoración");
                                                            }
                                                        }
                                                    );
                                                }
                                            }
                                        }
                                    });
                                    $('#review-rating-{{$result->id}}').raty({ half: true, score: 3 });
                                });
                            </script>
                            <script type="text/javascript">
                                function saveAlert(text) {
                                    $('#saveReviewAlert').html(text);
                                    $('#saveReviewAlertDiv').delay(200).fadeIn().delay(4000).fadeOut();
                                }
                            </script>
                        </div><!-- /.col-xs-12 -->
                    </div><!-- /.row -->
                @endforeach
                </div>
            </div><!-- /.search-results-list -->

            <div class="row text-center" id="show-more-results-{{ $slices_showing }}">
            {{--Show more link--}}
            @if($display_show_more)
                <a href="#">
                    Mostrar más resultados<br>
                    <i class="fa fa-arrow-down"></i>
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

        </div><!--/.col-xs-8 /#results-main-content -->

</div><!--/.container-fluid-->

{{--Loader overlay--}}
<div class="modal-loading"></div>
<script type="text/javascript">
    $(document).ready(function() {
        $body = $("body");
        $(document).on({
            ajaxSend: function() { $body.addClass("loading"); },
            ajaxStop: function() { $body.removeClass("loading"); },
            ajaxError: function() { $body.removeClass("loading"); }
        });
    });
</script>
@stop