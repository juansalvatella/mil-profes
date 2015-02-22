@extends('basic_template')
@section('content')

    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    <h1>Valoraciones <small>Panel de control</small></h1>
                </div>
                <div class="pull-right">
                    <a href="{{ url('userpanel/dashboard') }}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @elseif(Session::has('failure'))
        <div class="alert alert-warning" role="alert">{{ Session::get('failure') }}</div>
    @endif

    @if ($reviews->isEmpty())
        <p>No se han encontrado valoraciones.</p>
    @else

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Comentador</th>
                <th>¿Es usuario?</th>
                <th>Comentario</th>
                <th>Valoración</th>
                <th>Valorado</th>
                <th>Tipo</th>
                <th>Eliminar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td>{{ $review->created_at }}</td>
                    <td>{{ $review->valorador }}</td>
                    <td>@if($review->wasUser)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="Sí"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="No"></i> @endif</td>
                    <td>{{ $review->comment }}</td>
                    <td>{{ $review->value }}</td>
                    <td>{{ $review->valorado }}</td>
                    <td>{{ $review->type }}</td>
                    <td>
                        <a href="{{ url('admin/delete/review',array($review->type,$review->id)) }}" class="btn btn-danger">Eliminar valoración</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="panel panel-default">
            <div class="panel-body">
                <p>{{ count($reviews) }} valoraciones en total</p>
            </div>
        </div>
    @endif

@stop