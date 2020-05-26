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
						<label class="label-sm">Номер</label>
						<input type="text" name="num" autocomplete="off" class="form-control form-control-sm">
					</div>
					<div class="form-group">
						<label class="label-sm">Название</label>
						<input type="text" name="name" autocomplete="off" class="form-control form-control-sm">
					</div>
					<div class="form-group">
						<label class="label-sm">Корпус</label>
						<select name="corpus_id" class="form-control form-control-sm">
							@foreach($corps as $c)
							<option value="{{$c->id}}">{{$c->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label class="label-sm">Вместимость</label>
						<input type="number" name="capacity" autocomplete="off" class="form-control form-control-sm">
					</div>
					<div class="form-group">
						<label class="label-sm">Описание</label>
						<textarea name="description" autocomplete="off" class="form-control form-control-sm"></textarea>
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
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Номер</th>
				<th>Название</th>
				<th>Корпус</th>
				<th>Вместимость</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($cabs as $cab)
			<tr>
				<td>{{ $cab->num }}</td>
				<td>{{ $cab->name }}</td>
				<td>{{ $cab->corpus->name }}</td>
				<td>{{ $cab->capacity }}</td>
				<td class="text-right text-nowrap">
					<button data-toggle="modal" data-target="#{{ $cab->id }}" class="btn btn-sm btn-outline-primary">Редактировать</button>
				</td>
			</tr>
			@endforeach            
		</tbody>
	</table>
</div>
@foreach($cabs as $cab)
<div class="modal fade" id="{{ $cab->id }}">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/cabs/{{ $cab->id }}" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">{{ $cab->num }} ({{$cab->name}})</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="label-sm">Номер</label>
						<input type="text" name="num" autocomplete="off" class="form-control form-control-sm" value="{{ $cab->num }}">
					</div>
					<div class="form-group">
						<label class="label-sm">Название</label>
						<input type="text" name="name" autocomplete="off" class="form-control form-control-sm" value="{{ $cab->name }}">
					</div>
					<div class="form-group">
						<label class="label-sm">Корпус</label>
						<select name="corpus_id" class="form-control form-control-sm">
							@foreach($corps as $c)
							<option value="{{$c->id}}" {{$c->id==$cab->corpus_id?'selected':''}}>{{$c->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label class="label-sm">Вместимость</label>
						<input type="number" name="capacity" autocomplete="off" class="form-control form-control-sm" value="{{ $cab->capacity }}">
					</div>
					<div class="form-group">
						<label class="label-sm">Описание</label>
						<textarea name="description" autocomplete="off" class="form-control form-control-sm">{{ $cab->description }}</textarea>
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