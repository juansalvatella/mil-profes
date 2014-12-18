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
	@foreach($users as $user)
			<tr>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
			</tr>
	@endforeach
		</tbody>
	</table>
@stop