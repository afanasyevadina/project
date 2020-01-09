@extends('layouts.app')
@section('content')
<div class="text-right">
	<button class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#upload">Загрузить</button>
</div>
<div class="modal fade" id="upload">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/teachers/upload" method="post" enctype="multipart/form-data">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Загрузить из файла</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
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
<h3>Преподаватели</h3>
<hr>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/teachers" method="post">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Новый преподаватель</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
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
<table class="table table-hover">
	<thead>
		<tr>
			<th>Фамилия</th>
			<th>Имя</th>
			<th>Отчество</th>
			<th class="text-right">
				<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Добавить</button>
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach($teachers as $t)
		<tr>
			<td>{{ $t->surname }}</td>
			<td>{{ $t->name }}</td>
			<td>{{ $t->patronymic }}</td>
			<td class="text-right">
				<button data-toggle="modal" data-target="#{{ $t->id }}" class="btn btn-sm btn-outline-success">Редактировать</button>
			</td>
		</tr>
		<div class="modal fade" id="{{ $t->id }}">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="/teachers/{{ $t->id }}" method="post">
						@csrf
						<div class="modal-header">
							<h5 class="modal-title">{{ $t->shortName }}</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="modal-body">
								<div class="form-group">
									<label>Фамилия</label>
									<input type="text" name="surname" autocomplete="off" class="form-control" required value="{{ $t->surname }}">
								</div>
								<div class="form-group">
									<label>Имя</label>
									<input type="text" name="name" autocomplete="off" class="form-control" required value="{{ $t->name }}">
								</div>
								<div class="form-group">
									<label>Отчество</label>
									<input type="text" name="patronymic" autocomplete="off" class="form-control" value="{{ $t->patronymic }}">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="submit" class="btn btn-success" value="Сохранить">
							<a href="/teachers/{{ $t->id }}/delete" class="btn btn-light">Удалить</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		@endforeach            
	</tbody>
</table>
@endsection