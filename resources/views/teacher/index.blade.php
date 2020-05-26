@extends('layouts.app')
@section('title', 'Преподаватели')
@section('content')
<div class="d-flex justify-content-between">
	<h3>Преподаватели</h3>
	<div class="dropdown">
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Действия
		</button>
		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" href="/teachers/create">Добавить</a>
			<button class="dropdown-item" data-toggle="modal" data-target="#upload">Загрузить</button>
			<button class="dropdown-item" id="create">Создать учетки</button>
		</div>
	</div>
</div>
<hr>
<div class="form-group">
	<input type="text" class="form-control" autocomplete="off" data-search="tbody tr" placeholder="Поиск...">
</div>
<form action="/admin/users/register" method="post">
	@csrf
	<input type="hidden" name="role" value="teacher">
	<div class="table-responsive">
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
					<th class="text-right">
						<input type="submit" class="btn btn-outline-success create" value="Создать учетки" hidden>
						<button type="button" class="btn btn-outline-secondary create" hidden id="cancel">Отмена</button>
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($teachers as $key => $t)
				<tr>
					<td class="create" hidden><input type="checkbox" name="users[]" value="{{ $t->id }}"></td>				
					<td>{{ $key + 1 }}</td>
					<td>{{ $t->surname }}</td>
					<td>{{ $t->name }}</td>
					<td>{{ $t->patronymic }}</td>
					<td class="text-right">
						<a href="/teachers/{{$t->id}}/edit" class="btn btn-sm btn-link">Личная карта</a>
					</td>
				</tr>
				@endforeach            
			</tbody>
		</table>
	</div>
</form>
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
<script type="text/javascript" src="/public/js/select.js"></script>
@endsection