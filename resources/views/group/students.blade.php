@extends('layouts.app')
@section('title', 'Группа '.$group->name)
@section('content')
<div class="d-flex justify-content-between">
	<h3>Список студентов группы {{ $group->name }}</h3>
	@can('manager')
	<div class="dropdown">
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Действия
		</button>
		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" href="/students/create?group={{$group->id}}">Добавить</a>
			@if(count($group->students) >= 25)
			<a href="/students/{{$group->id}}/divide" class="dropdown-item self-reload">Сформировать подгруппы</a>
			@endif
			@if(count($group->students))
			<button class="dropdown-item" id="create">Создать учетки</button>
			@endif
		</div>
	</div>
	@endcan
</div>
<hr>
@if(count($group->students) >= 25)
<form>
	<div class="form-group col-sm-6">
		<select name="subgroup" class="form-control form-control-sm" onchange="this.form.submit()">
			<option value="">Все студенты</option>
			<option value="1" {{@$_GET['subgroup'] == 1 ? 'selected' : ''}}>1 подгруппа</option>
			<option value="2" {{@$_GET['subgroup'] == 2 ? 'selected' : ''}}>2 подгруппа</option>
		</select>
	</div>
</form>
@endif
<form action="/admin/users/register" method="post">
	@csrf
	<input type="hidden" name="role" value="student">
	<table class="table table-hover">
		<thead>
			<tr>
				<th class="create" hidden>
					<label class="font-weight-normal">
						<input type="checkbox" id="all" data-select="[name='users[]']">
					</label>
				</th>
				<th>№</th>
				<th>Фамилия</th>
				<th>Имя</th>
				<th>Отчество</th>
				@if(count($group->students) >= 25)
				<th class="text-center">Подгруппа</th>
				@endif
				<th class="text-right">
					<input type="submit" class="btn btn-outline-success create" value="Создать учетки" hidden>
					<button type="button" class="btn btn-outline-secondary create" hidden id="cancel">Отмена</button>
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach($students as $key => $s)
			<tr>
				<td class="create" hidden><input type="checkbox" name="users[]" value="{{ $s->id }}"></td>
				<td>{{ $key + 1 }}</td>
				<td>{{ $s->surname }}</td>
				<td>{{ $s->name }}</td>
				<td>{{ $s->patronymic }}</td>
				@if(count($group->students) >= 25)
				<td class="text-center">{{ $s->subgroup }}</td>
				@endif
				<td class="text-right">
					@can('manager')
					<a href="/students/{{$s->id}}/edit" class="btn btn-sm btn-link">Личная карта</a> | 
					@endcan
					<a href="/results/{{$s->id}}" class="btn btn-sm btn-link">Зачетка</a>
				</td>
			</tr>		
			@endforeach            
		</tbody>
	</table>
</form>
@endsection
@section('scripts')
<script type="text/javascript" src="/public/js/select.js"></script>
@endsection