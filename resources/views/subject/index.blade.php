@extends('layouts.app')
@section('content')
<div class="text-right">
	<button class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#upload">Загрузить</button>
</div>
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
<h3>Дисциплины</h3>
<hr>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/subjects" method="post">
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
<table class="table table-hover">
	<thead>
		<tr>
			<th>Название на рус.яз.</th>
			<th>Название на каз.яз.</th>
			<th class="text-right">
				<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Добавить новую</button>
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach($subjects as $s)
		<tr>
			<td>{{ $s->name }}</td>
			<td>{{ $s->name_kz }}</td>
			<td class="text-right">
				<button data-toggle="modal" data-target="#{{ $s->id }}" class="btn btn-sm btn-outline-success">Редактировать</button>
			</td>
		</tr>
		<div class="modal fade" id="{{ $s->id }}">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="/subjects/{{ $s->id }}" method="post">
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
								<label>
									<input type="radio" name="divide" value="0" 
									{{$s->divide == '0' ? 'checked' : ''}}> 
								Не формировать подгруппы</label>
								<label>
									<input type="radio" name="divide" value="1" 
									{{$s->divide == '1' ? 'checked' : ''}}> 
								Формировать подгруппы всегда</label>
								<label>
									<input type="radio" name="divide" value="2" 
									{{$s->divide == '2' ? 'checked' : ''}}> 
								Формировать подгруппы на практики</label>
							</div>
						</div>
						<div class="modal-footer">
							<input type="submit" class="btn btn-success" value="Сохранить">
							<a href="/subjects/{{ $s->id }}/delete" class="btn btn-light">Удалить</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		@endforeach            
	</tbody>
</table>
@endsection