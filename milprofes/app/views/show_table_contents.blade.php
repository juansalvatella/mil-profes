@extends('blank')
@section('content')
    <h3>{{ $table }}</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            @foreach($columns as $column)
            <th>{{ $column }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <tr>
                @foreach($columns as $column)
                <td>{{ $row->$column }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
@stop