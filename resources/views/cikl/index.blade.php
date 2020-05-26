@extends('layouts.app')
@section('title', 'Циклы дисциплин')
@section('content')
<div class="d-flex justify-content-between">
	<h3>Циклы дисциплин</h3>
	<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Добавить</button>
</div>
<hr>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/cikls" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Новый цикл</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-sm-12">
							<label class="label-sm">Название на русском</label>
							<input type="text" name="name" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Название на казахском</label>
							<input type="text" name="name_kz" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Сокращение на русском</label>
							<input type="text" name="short_name" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Сокращение на казахском</label>
							<input type="text" name="short_name_kz" autocomplete="off" class="form-control form-control-sm">
						</div>
					</div>
				</div>
				<div class="modal-footer"><input type="submit" class="btn btn-success" value="Сохранить"></div>
			</form>
		</div>
	</div>
</div>
<div class="table-responsive">
	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th>№</th>
				<th>Название на русском</th>
				<th>Название на казахском</th>
				<th>Сокращение на русском</th>
				<th>Сокращение на казахском</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($cikls as $key => $cikl)
			<tr>
				<td>{{ $key + 1 }}</td>
				<td>{{ $cikl->name }}</td>
				<td>{{ $cikl->name_kz }}</td>
				<td>{{ $cikl->short_name }}</td>
				<td>{{ $cikl->short_name_kz }}</td>
				<td class="text-right text-nowrap">
					<button data-toggle="modal" data-target="#{{ $cikl->id }}" class="btn btn-sm btn-outline-primary">Редактировать</button>
				</td>
			</tr>
			@endforeach            
		</tbody>
	</table>
</div>
@foreach($cikls as $cikl)
<div class="modal fade" id="{{$cikl->id}}">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/cikls/{{$cikl->id}}" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">{{$cikl->name}}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-sm-12">
							<label class="label-sm">Название на русском</label>
							<input type="text" name="name" value="{{$cikl->name}}" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Название на казахском</label>
							<input type="text" name="name_kz" value="{{$cikl->name_kz}}" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Сокращение на русском</label>
							<input type="text" name="short_name" value="{{$cikl->short_name}}" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Сокращение на казахском</label>
							<input type="text" name="short_name_kz" value="{{$cikl->short_name_kz}}" autocomplete="off" class="form-control form-control-sm">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-success" value="Сохранить">
					<a href="/cikls/{{$cikl->id}}/delete" class="btn btn-light self-reload">Удалить</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach  
@endsection