@extends('layouts.app')
@section('title', 'Список пользователей')
@section('content')
<div class="d-flex justify-content-between">
	<h3>Пользователи</h3>
	<a href="/admin/users/create" class="btn btn-outline-info">Добавить</a>
</div>
<hr>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Логин</th>
			<th>E-mail</th>
			<th>Роль в системе</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users as $user)
		<tr>
			<td>{{ $user->name }}</td>
			<td>{{ $user->email }}</td>
			<td>{{ $user->role }}</td>
		</tr>
		@endforeach           
	</tbody>
</table>
@endsection