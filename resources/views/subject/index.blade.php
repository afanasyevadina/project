@extends('layouts.app')
@section('title', 'Дисциплины')
@section('content')
<?php
$divide = ['-', 'Всегда', 'На практики'];
?>
<div class="modal fade" id="upload">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/subjects/upload" method="post" enctype="multipart/form-data">
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
<div class="d-flex justify-content-between">
	<h3>Дисциплины</h3>
	<div>
		<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Добавить новую</button>
		<button class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#upload">Загрузить</button>
	</div>
</div>
<hr>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/subjects" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Новая дисциплина</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Название на рус.яз.</label>
						<input type="text" name="name" autocomplete="off" class="form-control">
					</div>
					<div class="form-group">
						<label>Название на каз.яз.</label>
						<input type="text" name="name_kz" autocomplete="off" class="form-control">
					</div>
					<div class="form-group">
						<label>Сокращение на рус.яз.</label>
						<input type="text" name="short_name" autocomplete="off" class="form-control">
					</div>
					<div class="form-group">
						<label>Сокращение на каз.яз.</label>
						<input type="text" name="short_name_kz" autocomplete="off" class="form-control">
					</div>
					<div class="form-group">
						<label>
							<input type="radio" name="divide" value="0" checked> 
						Не формировать подгруппы</label>
						<label>
							<input type="radio" name="divide" value="1"> 
						Формировать подгруппы всегда</label>
						<label>
							<input type="radio" name="divide" value="2"> 
						Формировать подгруппы на практики</label>
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
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>№</th>
			<th>Название на рус.яз.</th>
			<th>Название на каз.яз.</th>
			<th>Сокращение на рус.яз.</th>
			<th>Сокращение на каз.яз.</th>
			<th>Деление на подгруппы</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($subjects as $key => $s)
		<tr>
			<td>{{ $key + 1 }}</td>
			<td>{{ $s->name }}</td>
			<td>{{ $s->name_kz }}</td>
			<td>{{ $s->short_name }}</td>
			<td>{{ $s->short_name_kz }}</td>
			<td>{{ $divide[$s->divide] }}</td>
			<td class="text-right">
				<button data-toggle="modal" data-target="#{{ $s->id }}" class="btn btn-sm btn-outline-primary">Редактировать</button>
			</td>
		</tr>
		@endforeach            
	</tbody>
</table>
@foreach($subjects as $s)

<div class="modal fade" id="{{ $s->id }}">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/subjects/{{ $s->id }}" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">{{ $s->name }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Название на рус.яз.</label>
						<input type="text" name="name" autocomplete="off" class="form-control" value="{{ $s->name }}">
					</div>
					<div class="form-group">
						<label>Название на каз.яз.</label>
						<input type="text" name="name_kz" autocomplete="off" class="form-control" value="{{ $s->name_kz }}">
					</div>
					<div class="form-group">
						<label>Сокращение на рус.яз.</label>
						<input type="text" name="short_name" autocomplete="off" class="form-control" value="{{ $s->short_name }}">
					</div>
					<div class="form-group">
						<label>Сокращение на каз.яз.</label>
						<input type="text" name="short_name_kz" autocomplete="off" class="form-control" value="{{ $s->short_name_kz }}">
					</div>
					<div class="form-group">
						<label><input type="radio" name="divide" value="0" 
							{{$s->divide == '0' ? 'checked' : ''}}> 
							Не формировать подгруппы</label>
						<label><input type="radio" name="divide" value="1" 
							{{$s->divide == '1' ? 'checked' : ''}}> 
							Формировать подгруппы всегда</label>
						<label><input type="radio" name="divide" value="2" 
							{{$s->divide == '2' ? 'checked' : ''}}> 
							Формировать подгруппы на практики</label>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-success" value="Сохранить">
					<a href="/subjects/{{ $s->id }}/delete" class="btn btn-light self-reload">Удалить</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach
@endsection