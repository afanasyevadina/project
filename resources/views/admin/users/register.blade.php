@extends('layouts.app')
@section('title', 'Секретная информация')
@section('content')
<h3>Данные для входа</h3>
<hr>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Логин</th>
			<th>Пароль</th>
			<th>Роль в системе</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users as $user)
		<tr>
			<td>{{ $user->name }}</td>
			<td>{{ $user->password }}</td>
			<td>{{ $user->role }}</td>
		</tr>
		@endforeach           
	</tbody>
</table>
@endsection