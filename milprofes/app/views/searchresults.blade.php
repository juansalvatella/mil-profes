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
            <h1>Here may go some header and such</h1>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-3 well" style="min-height:768px;">
            <p>Here goes the search options</p>
            <!--distance slider-->
            <div class="slider slider-horizontal"></div>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('.slider').slider({
                        min:    1.0,
                        max:    20.0,
                        step:   1.0,
                        value:  {{ $search_distance }},
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
                                    initialize_map(); //necesaria llamada a función tras cargar el código js del gmap de forma asíncrona
                                }
                        );
                    });
                });
            </script>
            <!--/distance slider -->
        </div>

        <div class="col-xs-9">
            <p>Here goes the results and related information</p>
            <!--results-->
            <div class="search-total">
                {{ $results->count() }} @choice('search.'.$prof_o_acad,$results->count()) {{ @trans('search.'.$category) }} @choice('search.'.$prof_o_acad.'_found',$results->count())
            </div>
            <div class="search-results-list">
                @foreach($results as $result)
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="row"><!--Picture, name, age, rate info -->
                                <div class="img-thumbnail col-xs-5">
                                        {{ $result['avatar'] }}
                                        {{ $result['logo'] }}
                                </div>
                                <div class="col-xs-7">{{ $result['name'] }}</div>
                                <div class="col-xs-7">{{-- $result['age'] --}}</div>
                                <div class="col-xs-7">Rating: ?.?</div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="row"><!-- Description -->
                                <div class="col-xs-12">{{ $result['description'] }}</div>
                            </div>
                            <div class="row"><!-- email, tel -->
                                <div class="col-xs-6">{{ $result['email'] }}</div>
                                <div class="col-xs-6">{{ $result['phone'] }}</div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="row"><!-- Price, schedule -->
                                <div class="col-xs-12">Precio??</div>
                                <div class="col-xs-12">{{ $result['availability'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!--/results-->
            <!--GoogleMap-->
            <div id="gmapDiv">
                    {{ $gmap['js'] }}
                    {{ $gmap['html'] }}
            </div>
            <!--/GoogleMap-->
        </div><!--/.col-->

    </div><!--/.row-->
</div><!--/.container-->

<!--a href="#">
    <article class="search-user">
        {{-- HTML::image("img/default-user.jpg", "Default user") --}}
    </article>
</a-->

@stop