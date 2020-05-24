@extends('layouts.app')
@section('title', 'Студенты')
@section('content')
<div class="d-flex justify-content-between">
	<h3>Студенты</h3>
	<div class="dropdown">
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Действия
		</button>
		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" href="/students/create">Добавить</a>
			<button class="dropdown-item" data-toggle="modal" data-target="#upload">Загрузить</button>
			@if(count($students))
			<button class="dropdown-item" id="create">Создать учетки</button>
			@endif
		</div>
	</div>
</div>
<form class="border pt-3 mb-3 row bg-light">
	<div class="col-sm-6 form-group">
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
	<div class="col-sm-3 form-group">
		<label class="label-sm">Курс</label>
		<select name="kurs" class="form-control form-control-sm">
			<option value="">Все курсы</option>
			@for($kurs = 1; $kurs <= 4; $kurs++)
			<option value="{{ $kurs }}" {{$kurs == @$_GET['kurs'] ? 'selected' : ''}}>{{ $kurs }} курс</option>
			@endfor
		</select>
	</div>
	<div class="col-sm-3 form-group">
		<label class="label-sm">База</label>
		<select name="base" class="form-control form-control-sm">
			<option value="">Все</option>
			<option value="9" {{9 == @$_GET['base'] ? 'selected' : ''}}>9 классов</option>
			<option value="11" {{11 == @$_GET['base'] ? 'selected' : ''}}>11 классов</option>
		</select>
	</div>
	<div class="col-sm-4 form-group">
		<label class="label-sm">Группа</label>
		<select name="group" class="form-control form-control-sm">
			<option value="">Все группы</option>
			@foreach($groups as $group)
			<option value="{{ $group->id }}" {{$group->id == @$_GET['group'] ? 'selected' : ''}}>{{ $group->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="col-sm-4 form-group">
		<label class="label-sm">Язык обучения</label>
		<select name="lang" class="form-control form-control-sm">
			<option value="">Все</option>
			@foreach($langs as $lang)
			<option value="{{ $lang->id }}" {{$lang->id == @$_GET['lang'] ? 'selected' : ''}}>{{ $lang->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="col-sm-4 form-group">
		<label class="label-sm">Форма оплаты</label>
		<select name="pay" class="form-control form-control-sm">
			<option value="">Все</option>
			@foreach($pays as $pay)
			<option value="{{ $pay->id }}" {{$pay->id == @$_GET['pay'] ? 'selected' : ''}}>{{ $pay->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="col-sm-10 form-group">
		<label class="label-sm">Поиск по ФИО</label>
		<input type="text" name="search" value="{{@$_GET['search']}}" autocomplete="off" class="form-control form-control-sm">
	</div>
	<div class="col-sm-2 form-group">
		<label class="label-sm">&nbsp;</label>
		<input type="submit" value="Поиск" class="btn d-block btn-sm btn-info">
	</div>
</form>
<form action="/admin/users/register" method="post">
	@csrf
	<input type="hidden" name="role" value="student">
	{{ $students->appends(Request::except('page'))->links() }}
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
				<th>Дата рождения</th>
				<th>Группа</th>
				<th class="text-right">
					<input type="submit" class="btn btn-outline-success create" value="Создать учетки" hidden>
					<button type="button" class="btn btn-outline-secondary create" hidden id="cancel">Отмена</button>
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach($students as $key => $s)
			<tr>
				<td class="create" hidden><input type="checkbox" name="users[]" value="{{ $s->id }}"></td>
				<td>{{ $key + 1 }}</td>
				<td>{{ $s->surname }}</td>
				<td>{{ $s->name }}</td>
				<td>{{ $s->patronymic }}</td>
				<td>{{ date('d.m.Y', strtotime($s->born)) }}</td>
				<td>{{ $s->group->name }}</td>
				<td class="text-right">
					@can('manager')
					<a href="/students/{{$s->id}}/edit" class="btn btn-sm btn-link">Личная карта</a> | 
					@endcan
					<a href="/results/{{$s->id}}" class="btn btn-sm btn-link">Зачетка</a>
				</td>
			</tr>		
			@endforeach            
		</tbody>
	</table>
	{{ $students->appends(Request::except('page'))->links() }}
</form>
<div class="modal fade" id="upload">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/students/upload" method="post" enctype="multipart/form-data">
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
@endsection
@section('scripts')
<script type="text/javascript" src="/public/js/select.js"></script>
@endsection