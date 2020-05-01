@extends('layouts.app')
@section('title', 'Аудиторный фонд')
@section('content')
<div class="d-flex justify-content-between">
	<h3>Аудиторный фонд</h3>
	<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Добавить</button>
</div>
<hr>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/cabs" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Новый кабинет</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Номер</label>
						<input type="text" name="num" autocomplete="off" class="form-control">
					</div>
					<div class="form-group">
						<label>Название</label>
						<input type="text" name="name" autocomplete="off" class="form-control">
					</div>
					<div class="form-group">
						<label>Вместимость</label>
						<input type="number" name="capacity" autocomplete="off" class="form-control">
					</div>
					<div class="form-group">
						<label>Описание</label>
						<textarea name="description" autocomplete="off" class="form-control"></textarea>
					</div>
				</div>
				<div class="modal-footer"><input type="submit" class="btn btn-success" value="Сохранить"></div>
			</form>
		</div>
	</div>
</div>
<div class="form-group">
	<input type="text" class="form-control" autocomplete="off" data-search="tbody tr" placeholder="Поиск...">
</div>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Номер</th>
			<th>Название</th>
			<th>Вместимость</th>
			<th>Описание</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($cabs as $cab)
		<tr>
			<td>{{ $cab->num }}</td>
			<td>{{ $cab->name }}</td>
			<td>{{ $cab->capacity }}</td>
			<td>{{ $cab->description }}</td>
			<td class="text-right text-nowrap">
				<button data-toggle="modal" data-target="#{{ $cab->id }}" class="btn btn-sm btn-outline-primary">Редактировать</button>
			</td>
		</tr>
		@endforeach            
	</tbody>
</table>
@foreach($cabs as $cab)
<div class="modal fade" id="{{ $cab->id }}">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/cabs/{{ $cab->id }}" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">{{ $cab->num }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Номер</label>
						<input type="text" name="num" autocomplete="off" class="form-control" value="{{ $cab->num }}">
					</div>
					<div class="form-group">
						<label>Название</label>
						<input type="text" name="name" autocomplete="off" class="form-control" value="{{ $cab->name }}">
					</div>
					<div class="form-group">
						<label>Вместимость</label>
						<input type="number" name="capacity" autocomplete="off" class="form-control" value="{{ $cab->capacity }}">
					</div>
					<div class="form-group">
						<label>Описание</label>
						<textarea name="description" autocomplete="off" class="form-control">{{ $cab->description }}</textarea>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-success" value="Сохранить">
					<a href="/cabs/{{ $cab->id }}/delete" class="btn btn-light self-reload">Удалить</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach 
@endsection