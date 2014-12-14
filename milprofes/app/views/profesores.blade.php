@extends('blank')
@section('content')
    <h3>PROFESORES</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Precio/hora</th>
            <th>Disponibilidad</th>
            <th>Dirección</th>
            <th>Población</th>
            <th>E-Mail</th>
            <th>Teléfono</th>
            <th>Categoría</th>
            <th>Descripción</th>
        </tr>
        </thead>
        <tbody>
        @foreach($profesores as $profesor)
            <tr>
                <td>{{ $profesor->nombre }}</td>
                <td>{{ $profesor->preciohora }}</td>
                <td>{{ $profesor->disponibilidad }}</td>
                <td>{{ $profesor->direccion }}</td>
                <td>{{ $profesor->poblacion }}</td>
                <td>{{ $profesor->email }}</td>
                <td>{{ $profesor->telefono }}</td>
                <td>{{ $profesor->categoria }}</td>
                <td>{{ $profesor->descripcion }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop