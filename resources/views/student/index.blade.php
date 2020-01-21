@extends('layouts.app')
@section('content')
<div class="text-right">
	@if(count($group->students) >= 25)
	<a href="/students/{{$group->id}}/divide" class="btn btn-sm btn-outline-primary">Сформировать подгруппы</a>
	@endif
	<button class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#upload">Загрузить</button>
</div>
<div class="modal fade" id="upload">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/students/upload" method="post" enctype="multipart/form-data">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Загрузить из файла</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="group" value="{{ $group->id }}">
					<div class="form-group">
						<label>Файл для импорта</label>
						<input type="file" name="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
					</div>
				</div>
				<div class="modal-footer"><input type="submit" class="btn btn-success" value="Загрузить"></div>
			</form>
		</div>
	</div>
</div>
<h3>Список студентов группы {{ $group->name }}</h3>
<hr>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/students" method="post">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Новый студент</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="group_id" value="{{ $group->id }}">
					<div class="form-group">
						<label>Фамилия</label>
						<input type="text" name="surname" autocomplete="off" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Имя</label>
						<input type="text" name="name" autocomplete="off" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Отчество</label>
						<input type="text" name="patronymic" autocomplete="off" class="form-control">
					</div>
				</div>
				<div class="modal-footer"><input type="submit" class="btn btn-success" value="Сохранить"></div>
			</form>
		</div>
	</div>
</div>
@if(count($group->students) >= 25)
<form>
	<div class="form-group col-sm-6">
		<select name="subgroup" class="form-control" onchange="this.form.submit()">
			<option value="">Все студенты</option>
			<option value="1" {{@$_GET['subgroup'] == 1 ? 'selected' : ''}}>1 подгруппа</option>
			<option value="2" {{@$_GET['subgroup'] == 2 ? 'selected' : ''}}>2 подгруппа</option>
		</select>
	</div>
</form>
@endif
<table class="table table-hover">
	<thead>
		<tr>
			<th>№</th>
			<th>Фамилия</th>
			<th>Имя</th>
			<th>Отчество</th>
			@if(count($group->students) >= 25)
			<th>Подгруппа</th>
			@endif
			<th class="text-right">
				<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Добавить</button>
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach($students as $key => $s)
		<tr>
			<td>{{ $key + 1 }}</td>
			<td>{{ $s->surname }}</td>
			<td>{{ $s->name }}</td>
			<td>{{ $s->patronymic }}</td>
			@if(count($group->students) >= 25)
			<td>{{ $s->subgroup }}</td>
			@endif
			<td class="text-right">
				<button data-toggle="modal" data-target="#{{ $s->id }}" class="btn btn-sm btn-outline-success">Редактировать</button>
			</td>
		</tr>
		<div class="modal fade" id="{{ $s->id }}">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="/students/{{ $s->id }}" method="post">
						@csrf
						<div class="modal-header">
							<h5 class="modal-title">{{ $s->shortName }}</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="modal-body">
								<div class="form-group">
									<label>Фамилия</label>
									<input type="text" name="surname" autocomplete="off" class="form-control" required value="{{ $s->surname }}">
								</div>
								<div class="form-group">
									<label>Имя</label>
									<input type="text" name="name" autocomplete="off" class="form-control" required value="{{ $s->name }}">
								</div>
								<div class="form-group">
									<label>Отчество</label>
									<input type="text" name="patronymic" autocomplete="off" class="form-control" value="{{ $s->patronymic }}">
								</div>
								<div class="form-group">
									<label>Группа</label>
									<select name="group_id" class="form-control" required>
										@foreach($groups as $g)
										<option value="{{ $g->id }}" {{$g->id == $s->group_id ? 'selected' : ''}}>{{ $g->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="submit" class="btn btn-success" value="Сохранить">
							<a href="/students/{{ $s->id }}/delete" class="btn btn-light">Удалить</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		@endforeach            
	</tbody>
</table>
@endsection