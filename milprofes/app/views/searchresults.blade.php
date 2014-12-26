@extends('results_template')
@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6">
            <!--GoogleMap-->
            {{ $gmap['js'] }}
            {{ $gmap['html'] }}
            <!--/GoogleMap-->
        </div>

        <!-- Form data -->
        {{ Form::open(array('action' => 'SearchController@search','id' => 'hiddenForm')) }}
            {{ Form::hidden('user_lat', $user_lat) }}
            {{ Form::hidden('user_lon', $user_lon) }}
            {{ Form::hidden('user_address', $user_address) }}
            {{ Form::hidden('prof_o_acad', $prof_o_acad) }}
            {{ Form::hidden('category', $category) }}
            {{ Form::hidden('subj_id', $subj_id) }}
            {{ Form::hidden('distance', $search_distance) }}
        {{ Form::close() }}
        <!--/Form data -->

        <div class="col-md-6">
            <div class="row" style="margin-top:20px;">&nbsp;</div><!--/Vertical spacing //-->
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
                        $('form#hiddenForm').submit();
                    });
                });
            </script>
            <!--/distance slider -->
            <div class="row" style="margin-top:20px;">&nbsp;</div><!--/Vertical spacing //-->
            <!--results-->
            <div class="search-total">
                {{ $results->count() }} @choice('search.'.$prof_o_acad,$results->count()) {{ @trans('search.'.$category) }} @choice('search.'.$prof_o_acad.'_found',$results->count())
            </div>
            <ul class="search-results-list">
                @if($prof_o_acad=='profesor')
                    @foreach($results as $result)
                        <li class="search-result">
                            {{  $result['name'] }}
                        </li>
                    @endforeach
                @else
                    @foreach($results as $result)
                        <li class="search-result">
                            {{  $result['name'] }}
                        </li>
                    @endforeach
                @endif
            </ul>
            <!--/results-->
        </div><!--/.col-md-4-->
    </div><!--/.row-->

</div><!--/.container-->

<!--a href="#">
    <article class="search-user">
        {{-- HTML::image("img/default-user.jpg", "Default user") --}}
    </article>
</a-->

@stop