@extends('blank')
@section('content')

<div class="container">

    <div class="row">
        <div class="col-md-5">
            {{ HTML::image("img/map.png", "Map") }}
        </div>
        <div class="col-md-7">
            <div class="search-total">
                {{ $data['results']->count() }} @choice('search.'.$data['prof_o_acad'],$data['results']->count()) {{ @trans('search.'.$data['categoria']) }} @choice('search.'.$data['prof_o_acad'].'_found',$data['results']->count())
            </div>
            <ul class="search-results-list">
                @if($data['prof_o_acad']=='profesor')
                    @foreach($data['results'] as $result)
                        <li class="search-result">
                            {{  $result['nombre'] }}
                            {{  $result['preciohora'] }}
                            {{  $result['disponibilidad'] }}
                            {{  $result['direccion'] }}
                            {{  $result['poblacion'] }}
                            {{  $result['email'] }}
                            {{  $result['telefono'] }}
                            {{  $result['descripcion'] }}
                        </li>
                    @endforeach
                @else
                    @foreach($data['results'] as $result)
                        <li class="search-result">
                            {{  $result['nombre'] }}
                            {{  $result['precio'] }}
                            {{  $result['horario'] }}
                            {{  $result['direccion'] }}
                            {{  $result['poblacion'] }}
                            {{  $result['email'] }}
                            {{  $result['telefono'] }}
                            {{  $result['descripcion'] }}
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