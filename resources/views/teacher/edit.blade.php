@extends('layouts.app')
@section('title', 'Личная карта | '.$teacher->fullName)
@section('content')
<div class="alert alert-success col-sm-6 fixed-alert" id="saved" hidden>
	Сохранено
</div>
<h3>{{$teacher->fullName}}</h3>
<hr>
<form action="/teachers/{{ $teacher->id }}" method="post" class="" data-alert="#saved" enctype="multipart/form-data">
	@csrf
	<div class="row mx-0">
		<div class="col-sm-6 card p-0">
			<div class="row card-body">
				<div class="col-sm-12"><h5>Личные данные</h5><hr class="mb-0"></div>
				<div class="mb-1 col-sm-12">
					<label class="label-sm">Фамилия</label>
					<input type="text" name="surname" autocomplete="off" class="form-control form-control-sm" 
					required value="{{ $teacher->surname }}">
				</div>
				<div class="mb-1 col-sm-12">
					<label class="label-sm">Имя</label>
					<input type="text" name="name" autocomplete="off" class="form-control form-control-sm" 
					required value="{{ $teacher->name }}">
				</div>
				<div class="form-group col-sm-12">
					<label class="label-sm">Отчество</label>
					<input type="text" name="patronymic" autocomplete="off" class="form-control form-control-sm" 
					value="{{ $teacher->patronymic }}">
				</div>
				<div class="col-sm-6">
					<label class="label-sm">Дата рождения</label>
					<input type="date" name="born" class="form-control form-control-sm" value="{{ $teacher->born }}">
				</div>
				<div class="col-sm-6">
					<label class="label-sm">ИИН</label>
					<input type="text" name="iin" autocomplete="off" class="form-control form-control-sm" 
					value="{{ $teacher->iin }}" pattern="\d{12}">
				</div>
			</div>
		</div>
		<div class="col-sm-1"></div>
		<div class="col-sm-4">
			<div class="text-center" style="height: 250px">
				<img src="{{$teacher->photo ?? asset('public/img/no-avatar.png')}}" class="img-fluid" alt="Photo">
			</div>
			<hr>
			<input type="hidden" name="photo" value="{{$teacher->photo}}">
			<div class="form-group">
				<label class="label-sm">Фото</label>
				<input type="file" name="photo" accept="image/*" class="form-control form-control-sm">
			</div>
		</div>
	</div>
	<div class="card my-3">
		<div class="row card-body">
			<div class="col-sm-12"><h5>Контактные данные</h5><hr></div>
			<div class="col-sm-4">
				<label class="label-sm">Адрес</label>
				<input type="text" autocomplete="off" name="address" class="form-control form-control-sm" value="{{$teacher->address}}">
			</div>
			<div class="col-sm-4">
				<label class="label-sm">Телефон</label>
				<input type="text" autocomplete="off" name="phone" class="form-control form-control-sm" value="{{$teacher->phone}}">
			</div>
			<div class="col-sm-4">
				<label class="label-sm">E-mail</label>
				<input type="email" autocomplete="off" name="email" class="form-control form-control-sm" value="{{$teacher->email}}">
			</div>
		</div>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-success" value="Сохранить" style="position: fixed;bottom: 15px;right: 20px;z-index: 999">
		<button type="button" data-toggle="modal" data-target="#delete" class="btn btn-outline-danger">Удалить</button>
	</div>
</form>
<div class="modal fade" id="delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Подтверждение</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Удалить преподавателя из базы? Вы уверены?
			</div>
			<div class="modal-footer">
				<a href="/teachers/{{ $teacher->id }}/delete" class="btn btn-secondary">Да</a>
				<button type="button" class="btn btn-light" data-dismiss="modal">Нет</button>
			</div>
		</div>
	</div>
</div>
@endsection