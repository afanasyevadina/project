@extends('layouts.app')
@section('title', 'Праздничные дни')
@section('content')
<div class="d-flex justify-content-between">
	<h3>Праздничные дни</h3>
	<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Добавить</button>
</div>
<hr>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/holidays" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Добавить</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Дата</label>
						<input type="date" name="date" autocomplete="off" class="form-control">
					</div>
					<div class="form-group">
						<label>Название</label>
						<input type="text" name="name" autocomplete="off" class="form-control">
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
			<th>Дата</th>
			<th>Название</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($holidays as $holiday)
		<tr>
			<td>{{ date('d.m.Y', strtotime($holiday->date)) }}</td>
			<td>{{ $holiday->name }}</td>
			<td class="text-right text-nowrap">
				<button data-toggle="modal" data-target="#{{ $holiday->id }}" class="btn btn-sm btn-outline-primary">Редактировать</button>
			</td>
		</tr>
		@endforeach            
	</tbody>
</table>
@foreach($holidays as $holiday)
<div class="modal fade" id="{{ $holiday->id }}">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/holidays/{{$holiday->id}}" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">{{ date('d.m.Y', strtotime($holiday->date)) }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Дата</label>
						<input type="date" name="date" autocomplete="off" class="form-control" value="{{$holiday->date}}">
					</div>
					<div class="form-group">
						<label>Название</label>
						<input type="text" name="name" autocomplete="off" class="form-control" value="{{$holiday->name}}">
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-success" value="Сохранить">
					<a href="/holidays/{{$holiday->id}}/delete" class="btn btn-light self-reload">Удалить</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach 
@endsection