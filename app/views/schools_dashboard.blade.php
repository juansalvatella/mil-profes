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
    @endif
    @if(Session::has('failure'))
        <div class="alert alert-warning" role="alert">{{ Session::get('failure') }}</div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-warning" role="alert">{{ Session::get('error') }}</div>
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
                    <th>Cursos</th>
                    <th>Perfil</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schools as $school)
                <tr>
                    <td>{{ $school->name }}</td>
                    <td class="text-center">@if($school->address)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->address }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center">@if($school->cif)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->cif }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center">@if($school->email)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->email }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center">@if($school->phone)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->phone }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center">@if($school->phone2)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->phone2 }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center">@if($school->logo)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->logo }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center">@if($school->description)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->description }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center">@if($school->lon)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->lat }},{{ $school->lon }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center">{{ count($lessons[$school->id]) }}</td>
                    <td class="text-center">
                        <a href="{{ url('academia',array($school->slug)) }}" class="btn-xs btn-success">Ver perfil</a>
                    </td>
                    <td class="text-center">
                        <a href="{{ url('admin/lessons',array($school->id)) }}" class="btn-xs btn-info">Editar cursos</a>
                        <a href="{{ url('admin/edit/school',array($school->id)) }}" class="btn-xs btn-primary">Editar academia</a>
                    </td>
                    <td class="text-center">
                        <a href="{{ url('admin/delete/school',array($school->id)) }}" class="btn-xs btn-danger">Eliminar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="panel panel-default">
            <div class="panel-body">
                <p>{{ count($schools) }} academias en total</p>
            </div>
        </div>
    @endif

    </div>

@stop