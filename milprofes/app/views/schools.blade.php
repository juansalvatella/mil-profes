@extends('blank')
@section('content')
    <h3>ACADEMIAS</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nombre</th>
        </tr>
        </thead>
        <tbody>
        @foreach($schools as $school)
            <tr>
                <td>{{ $school->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop