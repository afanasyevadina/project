@extends('layouts.app')
@section('title', 'Группы')
@section('content')
<div class="d-flex justify-content-between">
	<h3>Группы</h3>
	<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Добавить новую</button>
</div>
<hr>
<form class="row">
	<div class="col-sm-4 form-group">
		<label class="label-sm">Специальность</label>
		<select name="spec" class="form-control form-control-sm">
			<option value="">Все специальности</option>
			@foreach($specializations as $spec)
			<option value="{{ $spec->id }}" {{$spec->id == @$_GET['spec'] ? 'selected' : ''}}>
				{{ $spec->code }} &laquo;{{ $spec->name }}&raquo;
			</option>
			@endforeach
		</select>
	</div>
	<div class="col-sm-2 form-group">
		<label class="label-sm">Курс</label>
		<select name="kurs" class="form-control form-control-sm">
			<option value="">Все курсы</option>
			@for($kurs = 1; $kurs <= 4; $kurs++)
			<option value="{{ $kurs }}" {{$kurs == @$_GET['kurs'] ? 'selected' : ''}}>{{ $kurs }} курс</option>
			@endfor
		</select>
	</div>
	<div class="col-sm-2 form-group">
		<label class="label-sm">База</label>
		<select name="base" class="form-control form-control-sm">
			<option value="">Все</option>
			<option value="9" {{@$_GET['base'] == 9 ? 'selected' : ''}}>9 классов</option>
			<option value="11" {{@$_GET['base'] == 11 ? 'selected' : ''}}>11 классов</option>
		</select>
	</div>
	<div class="col-sm-2 form-group">
		<label class="label-sm">Язык обучения</label>
		<select name="lang" class="form-control form-control-sm">
			<option value="">Все</option>
			@foreach($langs as $lang)
			<option value="{{ $lang->id }}" {{$lang->id == @$_GET['lang'] ? 'selected' : ''}}>{{ $lang->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="col-sm-2 form-group">
		<label class="label-sm">&nbsp;</label>
		<input type="submit" value="Поиск" class="btn d-block btn-sm btn-info">
	</div>
</form>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/groups" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Новая группа</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-sm-6">
							<label class="label-sm">Название</label>
							<input type="text" name="name" autocomplete="off" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-6">
							<label class="label-sm">База</label>
							<select name="base" class="form-control form-control-sm">
								<option value="9">9 классов</option>
								<option value="11">11 классов</option>
							</select>
						</div>
						<div class="form-group col-sm-4">
							<label class="label-sm">Год поступления</label>
							<input type="number" name="year_create" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-4">
							<label class="label-sm">Год выпуска</label>
							<input type="number" name="year_leave" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-4">
							<label class="label-sm">Курс</label>
							<input type="number" name="kurs" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Специальность</label>
							<select name="specialization_id" class="form-control form-control-sm">
								@foreach($specializations as $spec)
								<option value="{{ $spec->id }}">{{ $spec->code }} &laquo;{{ $spec->name }}&raquo;</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Язык обучения</label>
							<select name="lang_id" class="form-control form-control-sm">
								@foreach($langs as $lang)
								<option value="{{ $lang->id }}">{{ $lang->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Куратор</label>
							<select name="teacher_id" class="form-control form-control-sm">
								<option value="">Куратор</option>
								@foreach($teachers as $teacher)
								<option value="{{ $teacher->id }}">{{ $teacher->fullName }}</option>
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
<div class="table-responsive">
<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th>№</th>
			<th>Группа</th>
			<th>Год поступления</th>
			<th>Специальность</th>
			<th>Язык обучения</th>
			<th>Куратор</th>
			<th>Количество студентов</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($groups as $key => $group)
		<tr>
			<td>{{ $key + 1 }}</td>
			<td>{{ $group->name }}</td>
			<td class="text-center">{{ $group->year_create }}</td>
			<td>{{ $group->specialization->code }} &laquo;{{ $group->specialization->name }}&raquo;</td>
			<td>{{ $group->lang->name }}</td>
			<td  class="text-nowrap">{{ $group->teacher->shortName }}</td>
			<td class="text-center">{{ $group->students()->count() }}</td>
			<td class="text-right text-nowrap">
				<button data-toggle="modal" data-target="#{{ $group->id }}" class="btn btn-sm btn-outline-primary">Редактировать</button>
				<a href="/groups/{{ $group->id}}/students" class="btn btn-sm btn-outline-secondary">Студенты</a>
			</td>
		</tr>
		@endforeach            
	</tbody>
</table>
</div>
@foreach($groups as $group)
<div class="modal fade" id="{{ $group->id }}">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/groups/{{ $group->id }}" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">{{ $group->name }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-sm-6">
							<label class="label-sm">Название</label>
							<input type="text" name="name" autocomplete="off" class="form-control form-control-sm" value="{{ $group->name }}">
						</div>
						<div class="form-group col-sm-6">
							<label class="label-sm">База</label>
							<select name="base" class="form-control form-control-sm">
								<option {{ $group->base == 9 ? 'selected' : ''}} value="9">9 классов</option>
								<option {{ $group->base == 11 ? 'selected' : ''}} value="11">11 классов</option>
							</select>
						</div>
						<div class="form-group col-sm-4">
							<label class="label-sm">Год поступления</label>
							<input type="number" name="year_create" class="form-control form-control-sm" value="{{ $group->year_create }}">
						</div>
						<div class="form-group col-sm-4">
							<label class="label-sm">Год выпуска</label>
							<input type="number" name="year_leave" class="form-control form-control-sm" value="{{ $group->year_leave }}">
						</div>
						<div class="form-group col-sm-4">
							<label class="label-sm">Курс</label>
							<input type="number" name="kurs" class="form-control form-control-sm" value="{{ $group->kurs }}">
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Специальность</label>
							<select name="specialization_id" class="form-control form-control-sm">
								@foreach($specializations as $spec)
								<option {{ $spec->id == $group->specialization_id ? 'selected' : ''}} value="{{ $spec->id }}"
									>{{ $spec->code }} &laquo;{{ $spec->name }}&raquo;
								</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Язык обучения</label>
							<select name="lang_id" class="form-control form-control-sm">
								@foreach($langs as $lang)
								<option {{ $lang->id == $group->lang_id ? 'selected' : ''}} value="{{ $lang->id }}">
									{{ $lang->name }}
								</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Куратор</label>
							<select name="teacher_id" class="form-control form-control-sm">
								<option value="">Куратор</option>
								@foreach($teachers as $teacher)
								<option {{ $teacher->id == $group->teacher_id ? 'selected' : ''}} value="{{ $teacher->id }}">{{ $teacher->fullName }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-success" value="Сохранить">
					<a href="/groups/{{ $group->id }}/delete" class="btn btn-light self-reload">Удалить</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach  
@endsection