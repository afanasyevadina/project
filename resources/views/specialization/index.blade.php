@extends('layouts.app')
@section('title', 'Специальности')
@section('content')
<div class="d-flex justify-content-between">
	<h3>Специальности</h3>
	<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Добавить новую</button>
</div>
<hr>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/specializations" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Новая специальность</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-sm-12">
							<label class="label-sm">Шифр</label>
							<input type="text" name="code" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Название на русском</label>
							<input type="text" name="name" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Название на казахском</label>
							<input type="text" name="name_kz" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Отделение</label>
							<select name="department_id" class="form-control form-control-sm">
								@foreach($departments as $dep)
								<option value="{{ $dep->id }}">{{ $dep->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer"><input type="submit" class="btn btn-success" value="Сохранить"></div>
			</form>
		</div>
	</div>
</div>
<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th>№</th>
			<th>Шифр</th>
			<th>Название на русском</th>
			<th>Название на казахском</th>
			<th>Отделение</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($specializations as $key => $spec)
		<tr>
			<td>{{ $key + 1 }}</td>
			<td>{{ $spec->code }}</td>
			<td>{{ $spec->name }}</td>
			<td>{{ $spec->name_kz }}</td>
			<td>{{ $spec->department->name }}</td>
			<td class="text-right text-nowrap">
				<button data-toggle="modal" data-target="#{{ $spec->id }}" class="btn btn-sm btn-outline-primary">Редактировать</button>
			</td>
		</tr>
		@endforeach            
	</tbody>
</table>
@foreach($specializations as $spec)
<div class="modal fade" id="{{$spec->id}}">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/specializations/{{$spec->id}}" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">{{$spec->name}}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-sm-12">
							<label class="label-sm">Шифр</label>
							<input type="text" name="code" value="{{$spec->code}}" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Название на русском</label>
							<input type="text" name="name" value="{{$spec->name}}" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Название на казахском</label>
							<input type="text" name="name_kz" value="{{$spec->name_kz}}" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Отделение</label>
							<select name="department_id" class="form-control form-control-sm">
								@foreach($departments as $dep)
								<option value="{{ $dep->id }}" {{$dep->id == $spec->department_id ? 'selected' : ''}}>
									{{ $dep->name }}
								</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-success" value="Сохранить">
					<a href="/specializations/{{$spec->id}}/delete" class="btn btn-light self-reload">Удалить</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach  
@endsection