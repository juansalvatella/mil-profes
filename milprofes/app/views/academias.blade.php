@extends('blank')
@section('content')
    <h3>ACADEMIAS</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Horario</th>
            <th>Dirección</th>
            <th>Población</th>
            <th>E-Mail</th>
            <th>Teléfono</th>
            <th>Categoría</th>
            <th>Descripción</th>
        </tr>
        </thead>
        <tbody>
        @foreach($academias as $academia)
            <tr>
                <td>{{ $academia->nombre }}</td>
                <td>{{ $academia->precio }}</td>
                <td>{{ $academia->horario }}</td>
                <td>{{ $academia->direccion }}</td>
                <td>{{ $academia->poblacion }}</td>
                <td>{{ $academia->email }}</td>
                <td>{{ $academia->telefono }}</td>
                <td>{{ $academia->categoria }}</td>
                <td>{{ $academia->descripcion }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop