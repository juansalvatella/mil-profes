@extends('blank')
@section('content')
    <h3>PROFESORES</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nombre</th>
        </tr>
        </thead>
        <tbody>
        @foreach($teachers as $teacher)
            <tr>
                <td>{{ $teacher->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop