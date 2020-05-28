@extends('layouts.app')
@section('title', 'Личная карта | '.$teacher->fullName)
@section('content')
<style type="text/css">
	.form-control:disabled, .form-control[readonly] {
		background-color: initial;
	}
</style>
<div class="alert alert-success col-sm-6 fixed-alert" id="saved" hidden>
	Сохранено
</div>
<h3>{{$teacher->fullName}}</h3>
<hr>
<div class="row mx-0">
	<div class="col-sm-6 card p-0">
		<div class="row card-body">
			<div class="col-sm-12"><h5>Личные данные</h5><hr class="mb-0"></div>
			<div class="mb-1 col-sm-12">
				<label class="label-sm">Фамилия</label>
				<input type="text" name="surname" autocomplete="off" class="form-control form-control-sm" 
				required value="{{ $teacher->surname }}" disabled>
			</div>
			<div class="mb-1 col-sm-12">
				<label class="label-sm">Имя</label>
				<input type="text" name="name" autocomplete="off" class="form-control form-control-sm" 
				required value="{{ $teacher->name }}" disabled>
			</div>
			<div class="form-group col-sm-12">
				<label class="label-sm">Отчество</label>
				<input type="text" name="patronymic" autocomplete="off" class="form-control form-control-sm" 
				value="{{ $teacher->patronymic }}" disabled>
			</div>
			<div class="col-sm-6">
				<label class="label-sm">Дата рождения</label>
				<input type="date" name="born" class="form-control form-control-sm" value="{{ $teacher->born }}" disabled>
			</div>
			<div class="col-sm-6">
				<label class="label-sm">ИИН</label>
				<input type="text" name="iin" autocomplete="off" class="form-control form-control-sm" 
				value="{{ $teacher->iin }}" pattern="\d{12}" disabled>
			</div>
		</div>
	</div>
	<div class="col-sm-1"></div>
	<div class="col-sm-4">
		<div class="text-center" style="height: 250px">
			<img src="{{$teacher->photo ?? asset('public/img/no-avatar.png')}}" class="img-fluid" alt="Photo">
		</div>
		<hr>
	</div>
</div>
<div class="card my-3">
	<div class="row card-body">
		<div class="col-sm-12"><h5>Контактные данные</h5><hr></div>
		<div class="col-sm-4">
			<label class="label-sm">Адрес</label>
			<input type="text" autocomplete="off" name="address" class="form-control form-control-sm" value="{{$teacher->address}}" disabled>
		</div>
		<div class="col-sm-4">
			<label class="label-sm">Телефон</label>
			<input type="text" autocomplete="off" name="phone" class="form-control form-control-sm" value="{{$teacher->phone}}" disabled>
		</div>
		<div class="col-sm-4">
			<label class="label-sm">E-mail</label>
			<input type="email" autocomplete="off" name="email" class="form-control form-control-sm" value="{{$teacher->email}}" disabled>
		</div>
	</div>
</div>
@endsection