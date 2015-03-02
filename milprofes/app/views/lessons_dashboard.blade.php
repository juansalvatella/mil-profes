@extends('layout')
@section('content')
<div class="container top-buffer-15 bottom-buffer-45">
    <div class="page-header">
        <h1>Editor de clases <small>Academia: {{ $school->name }}</small></h1>
    </div>

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @elseif(Session::has('failure'))
        <div class="alert alert-warning" role="alert">{{ Session::get('failure') }}</div>
    @endif

    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ url('admin/create/lesson',array($school->id)) }}" class="btn btn-primary">Nueva clase</a>
        </div>
    </div>

    @if ($lessons->isEmpty())
        <p>No existen clases de esta academia.</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Precio (€/curso)</th>
                <th>Descripción de la clase</th>
                <th>Materia</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->price }}</td>
                    <td>{{ $lesson->description }}</td>
                    <td>{{ $subjects[$lesson->id]->name }}</td>
                    <td>
                        <a href="{{ url('admin/edit/lesson',array($lesson->id)) }}" class="btn btn-default">Modificar clase</a>
                        &nbsp;
                        <a href="{{ url('admin/delete/lesson',array($lesson->id)) }}" class="btn btn-danger">Eliminar clase</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="panel panel-default">
            <div class="panel-body">
                <p>{{ count($lessons) }} clase(s) en total</p>
            </div>
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-body">
            <a style="float:right;" href="{{ url('admin/schools') }}" class="btn btn-info">Volver a academias</a>
        </div>
    </div>
</div>
@stop