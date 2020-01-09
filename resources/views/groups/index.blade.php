@extends('layouts.app')
@section('content')
<h3>Группы</h3>
<hr>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/groups" method="post">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Новая группа</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Название</label>
						<input type="text" name="name" autocomplete="off" class="form-control">
					</div>
					<div class="form-group">
						<label>Год поступления</label>
						<input type="number" name="year_create" class="form-control">
					</div>
					<div class="form-group">
						<label>Отделение</label>
						<select name="department_id" class="form-control">
							@foreach($departments as $dep)
							<option value="{{ $dep->id }}">{{ $dep->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Язык обучения</label>
						<select name="lang_id" class="form-control">
							@foreach($langs as $lang)
							<option value="{{ $lang->id }}">{{ $lang->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="modal-footer"><input type="submit" class="btn btn-success" value="Сохранить"></div>
			</form>
		</div>
	</div>
</div>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Группа</th>
			<th>Курс</th>
			<th>Отделение</th>
			<th>Язык обучения</th>
			<th class="text-right">
				<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Добавить новую</button>
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach($groups as $group)
		<tr>
			<td>{{ $group->name }}</td>
			<td>{{ $group->kurs }}</td>
			<td>{{ $group->department->name }}</td>
			<td>{{ $group->lang->name }}</td>
			<td class="text-right">
				<button data-toggle="modal" data-target="#{{ $group->id }}" class="btn btn-sm btn-outline-success">Редактировать</button>
			</td>
		</tr>
		<div class="modal fade" id="{{ $group->id }}">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="/groups/{{ $group->id }}" method="post">
						@csrf
						<div class="modal-header">
							<h5 class="modal-title">{{ $group->name }}</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>Название</label>
								<input type="text" name="name" autocomplete="off" class="form-control" value="{{ $group->name }}">
							</div>
							<div class="form-group">
								<label>Год поступления</label>
								<input type="number" name="year_create" class="form-control" value="{{ $group->year_create }}">
							</div>
							<div class="form-group">
								<label>Отделение</label>
								<select name="department_id" class="form-control">
									@foreach($departments as $dep)
									<option {{ $dep->id == $group->department_id ? 'selected' : ''}} value="{{ $dep->id }}">{{ $dep->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>Язык обучения</label>
								<select name="lang_id" class="form-control">
									@foreach($langs as $lang)
									<option {{ $lang->id == $group->lang_id ? 'selected' : ''}} value="{{ $lang->id }}">{{ $lang->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<input type="submit" class="btn btn-success" value="Сохранить">
							<a href="/groups/{{ $group->id }}/delete" class="btn btn-light">Удалить</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		@endforeach            
	</tbody>
</table>
@endsection