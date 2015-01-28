@extends('results_template')
@section('content')

<!-- Hidden form data -->
{{ Form::open(array('', 'id' => 'hiddenForm')) }}
    {{ Form::hidden('user_lat', $user_lat) }}
    {{ Form::hidden('user_lon', $user_lon) }}
    {{ Form::hidden('user_address', $user_address) }}
    {{ Form::hidden('prof_o_acad', $prof_o_acad) }}
    {{ Form::hidden('category', $category) }}
    {{ Form::hidden('subj_id', $subj_id) }}
    {{ Form::hidden('distance', $search_distance) }}
{{ Form::close() }}
<!--/Hidden form data -->

<div class="container">

    <div class="row">
        <div class="col-xs-12">
            <h1>Here may go some header?</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-3 well" style="min-height:768px;">
            <p>This is a distance slider to filter the search results by distance</p>
            <!--distance slider-->
            <div class="slider slider-horizontal"></div>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('.slider').slider({
                        min:    1.0,
                        max:    20.0,
                        step:   1.0,
                        value:  {{ $search_distance }}.0,
                        formater: function(value){
                            return value+' km';
                        },
                        handle: 'square'
                    }).on('slideStop', function(slideEv){
                        $('[name=distance]').val(slideEv.value);
                        var hiddenForm = $('form#hiddenForm');
                        $.post('/demo/ajaxsearch',
                                {
                                    _token: hiddenForm.find('input[name=_token]').val(),
                                    user_lat: hiddenForm.find('input[name=user_lat]').val(),
                                    user_lon: hiddenForm.find('input[name=user_lon]').val(),
                                    user_address: hiddenForm.find('input[name=user_address]').val(),
                                    prof_o_acad: hiddenForm.find('input[name=prof_o_acad]').val(),
                                    category: hiddenForm.find('input[name=category]').val(),
                                    subj_id: hiddenForm.find('input[name=subj_id]').val(),
                                    distance: hiddenForm.find('input[name=distance]').val()
                                },
                                function(data){ //handle the controller response
                                    $('.search-total').replaceWith($(data).find('.search-total'));
                                    $('.search-results-list').replaceWith($(data).find('.search-results-list'));
                                    $('#gmapDiv').replaceWith($(data).find("#gmapDiv"));
                                    initialize_map(); //necesario tras cargar el código js del gmap de forma asíncrona
                                }
                        );
                    });
                });
            </script>
            <!--/distance slider -->
        </div>

        <div class="col-xs-9">
            <p>Here goes the results and related information</p>
            <div id="saveReviewAlertDiv" class="bb-alert alert alert-info" style="display:none;position: fixed;top: 25%;right: 0px;margin-bottom: 0px;font-size: 1.2em;padding: 1em 1.3em;z-index: 2000;">
                <span id="saveReviewAlert">Save review success/failure alert</span>
            </div>
            <!--results-->
            <div class="search-total">
                {{ $results->count() }} @choice('search.'.$prof_o_acad,$results->count()) {{ @trans('search.'.$category) }} @choice('search.'.$prof_o_acad.'_found',$results->count())
            </div>
            <div class="search-results-list">
                @foreach($results as $result)
                    <div class="row">
                        <div class="col-xs-12">
                            Avatar/logo:
                            @if($prof_o_acad=='profesor')
                                <img src="{{ asset('img/avatars/'.$result->avatar) }}" class="img-thumbnail" style="min-height: 50px;height: 50px;min-width: 50px;width: 50px;">
                            @else
                                <img src="{{ asset('img/logos/'.$result->logo) }}" class="img-thumbnail" style="min-height: 50px;height: 50px;min-width: 50px;width: 50px;">
                            @endif
                        </div>
                        <div class="col-xs-12">
                            Nombre profe/academia: {{ $result->name }}
                        </div>
                        @if($prof_o_acad=='profesor')
                            <div class="col-xs-12">
                                Teacher rating: {{ $result->teacher_rating }} <span id="teacher-stars-{{$result->id}}"></span>
                                <script type="text/javascript">
                                    $('#teacher-stars-{{$result->id}}').raty({ readOnly: true, score: {{ $result->teacher_rating }} });
                                </script>
                            </div>
                        @endif
                        <div class="col-xs-12">
                            Descripción de la clase: {{ $result->description }}
                        </div>
                        <div class="col-xs-12">
                            Email: {{ $result->email }}
                        </div>
                        <div class="col-xs-12">
                            Tlf.: <span id="thisPhone-{{$result->id}}">{{ $result->trimmered_phone }}</span>
                            <a href="#" id="buttonDescubrir-{{$result->id}}" class="btn btn-info">Ver teléfono</a>
                            <script type="text/javascript">
                                $(document).on("click", "#buttonDescubrir-{{$result->id}}", function(e) {
                                    e.preventDefault();
                                    e.stopImmediatePropagation();
                                @if($prof_o_acad=='profesor')
                                    $.post('/phoneHandler/t_phone/{{$result->id}}', null,
                                @else
                                    $.post('/phoneHandler/s_phone/{{$result->id}}', null,
                                @endif
                                        function (phone) { //handle the controller response
                                            $('#thisPhone-{{$result->id}}').replaceWith(phone);
                                        }
                                    );
                                });
                            </script>
                        </div>
                        <div class="col-xs-12">
                            Precio de la clase: {{ $result->price }}
                            @if($prof_o_acad=='profesor')
                                €/hora
                            @else
                                €/curso
                            @endif
                        </div>
                        @if($prof_o_acad=='profesor')
                            <div class="col-xs-12">
                                Lesson rating: {{ $result->lesson_rating }} <span id="lesson-stars-{{$result->id}}"></span>
                                <script type="text/javascript">
                                    $('#lesson-stars-{{$result->id}}').raty({ readOnly: true, score: {{ $result->lesson_rating }} });
                                </script>
                            </div>
                            <div class="col-xs-12">
                                {{ $result->number_of_reviews }} valoraciones
                            </div>
                        <div class="col-xs-12">
                            Availability (horarios posibles): (to be implemented, only for teachers)
                        </div>
                        <div class="col-xs-12">
                            <a href="#" id="rate-lesson-{{ $result->id }}" class="btn btn-info">Valorar clase</a>
                            <script type="text/javascript">
                                $(document).on("click", "#rate-lesson-{{ $result->id }}", function(e) {
                                    e.preventDefault();
                                    e.stopImmediatePropagation();
                                    bootbox.dialog({
                                        title: "¿Qué te ha parecido la clase de {{ $result->name }}?",
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
                                                    $.post('/reviews/handleReview',
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
                                    $('#review-rating-{{$result->id}}').raty({ half: true });
                                });
                            </script>
                            <script type="text/javascript">
                                function saveAlert(text) {
                                    $('#saveReviewAlert').html(text);
                                    $('#saveReviewAlertDiv').delay(200).fadeIn().delay(4000).fadeOut();
                                }
                            </script>
                        </div><!-- /.col-xs-12 -->
                        @endif
                    </div><!-- /.row -->
                @endforeach
            </div><!-- /.search-results-list -->

            <!--GoogleMaps-->
            <div id="gmapDiv">
                    {{ $gmap['js'] }}
                    {{ $gmap['html'] }}
            </div><!--/GoogleMap-->

        </div><!--/.col-xs-9 -->

    </div><!--/.row-->
</div><!--/.container-->

@stop