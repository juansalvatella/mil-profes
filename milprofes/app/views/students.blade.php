@extends('blank')
@section('content')
	<h3>USERS</h3>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>E-mail</th>
			</tr>
		</thead>
		<tbody>
	@foreach($students as $student)
			<tr>
				<td>{{ $student->name }}</td>
				<td>{{ $student->email }}</td>
			</tr>
	@endforeach
		</tbody>
	</table>
@stop