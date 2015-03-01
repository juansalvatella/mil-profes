@extends('layout')
@section('content')

    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    <h1>Academias <small>Panel de control</small></h1>
                </div>
                <div class="pull-right">
                    <a href="{{ url('userpanel/dashboard') }}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @elseif(Session::has('failure'))
        <div class="alert alert-warning" role="alert">{{ Session::get('failure') }}</div>
    @endif

    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ url('/admin/create/school') }}" class="btn btn-primary">Nueva Academia</a>
        </div>
    </div>

    @if ($schools->isEmpty())
        <p>There are no schools... yet?</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Dir</th>
                    <th>CIF</th>
                    <th>EMail</th>
                    <th>Tlf</th>
                    <th>Tlf2</th>
                    <th>Logo</th>
                    <th>Desc</th>
                    <th>Geo</th>
                    <th>Clases</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schools as $school)
                <tr>
                    <td>{{ $school->name }}</td>
                    <td>@if($school->address)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->address }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td>@if($school->cif)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->cif }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td>@if($school->email)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->email }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td>@if($school->phone)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->phone }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td>@if($school->phone2)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->phone2 }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td>@if($school->logo)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->logo }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td>@if($school->description)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->description }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td>@if($school->lon)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->lat }},{{ $school->lon }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td>{{ count($lessons[$school->id]) }} clase(s)</td>
                    <td>
                        <a href="{{ url('admin/lessons',array($school->id)) }}" class="btn btn-primary">Editar clases</a>
                        <a href="{{ url('admin/edit/school',array($school->id)) }}" class="btn btn-success">Editar academia</a>
                    </td>
                    <td>
                        <a href="{{ url('admin/delete/school',array($school->id)) }}" class="btn btn-danger">Eliminar academia</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="panel panel-default">
            <div class="panel-body">
                <p>{{ count($schools) }} academia(s) en total</p>
            </div>
        </div>
    @endif

    </div>

@stop