@extends('blank')
@section('content')

<div class="container">

    <div class="row">
        <div class="col-md-5">
            {{ HTML::image("img/map.png", "Map") }}
        </div>
        <div class="col-md-7">
            <div class="search-total">
                {{ $results->count() }} @choice('search.'.$prof_o_acad,$results->count()) {{ @trans('search.'.$categoria) }} @choice('search.'.$prof_o_acad.'_found',$results->count())
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
        </div><!--/.col-md-7-->
    </div><!--.row-->

</div><!--/.container-->

<!--a href="#">
    <article class="search-user">
        {{-- HTML::image("img/default-user.jpg", "Default user") --}}
    </article>
</a-->

@stop