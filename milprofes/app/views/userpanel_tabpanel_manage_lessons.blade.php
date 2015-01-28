
<div class="panel panel-default">
    <div class="panel-body">
        <a href="{{ url('teacher/create/lesson') }}" class="btn btn-primary">Nueva clase</a>
    </div>
</div>

@if ($lessons->isEmpty())
    <p>Aún no tienes clases publicadas</p>
@else
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Materia</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
        </thead>
        <tbody>
        @foreach($lessons as $lesson)
            <tr>
                <td>{{ $lesson->price }}</td>
                <td>{{ $lesson->description }}</td>
                <td>{{ $subjects[$lesson->id]->name }}</td>
                <td>
                    <a href="{{ url('teacher/edit/lesson',array($lesson->id)) }}" class="btn btn-default">Modificar clase</a>
                </td>
                <td>
                    <a href="{{ url('teacher/delete/lesson',array($lesson->id)) }}" class="btn btn-danger">Eliminar clase</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="panel panel-default">
        <div class="panel-body">
            <p>Tienes publicadas {{ count($lessons) }} clase(s)</p>
        </div>
    </div>
@endif