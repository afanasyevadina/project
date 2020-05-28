@extends('layouts.app')
@section('title', 'Личная карта | '.$student->fullName)
@section('content')
<style type="text/css">
	.form-control:disabled, .form-control[readonly] {
		background-color: initial;
	}
</style>
<div class="alert alert-success col-sm-6 fixed-alert" id="saved" hidden>
	Сохранено
</div>
<h3>{{$student->fullName}}</h3>
<hr>
<div class="row mx-0">
	<div class="col-sm-6 card p-0">
		<div class="row card-body">
			<div class="col-sm-12"><h5>Личные данные</h5><hr class="mb-0"></div>
			<div class="mb-1 col-sm-12">
				<label class="label-sm">Фамилия</label>
				<input type="text" name="surname" autocomplete="off" class="form-control form-control-sm" 
				required value="{{ $student->surname }}" disabled>
			</div>
			<div class="mb-1 col-sm-12">
				<label class="label-sm">Имя</label>
				<input type="text" name="name" autocomplete="off" class="form-control form-control-sm" 
				required value="{{ $student->name }}" disabled>
			</div>
			<div class="form-group col-sm-12">
				<label class="label-sm">Отчество</label>
				<input type="text" name="patronymic" autocomplete="off" class="form-control form-control-sm" 
				value="{{ $student->patronymic }}" disabled>
			</div>
			<div class="col-sm-6">
				<label class="label-sm">Дата рождения</label>
				<input type="date" name="born" class="form-control form-control-sm" value="{{ $student->born }}" disabled>
			</div>
			<div class="col-sm-6">
				<label class="label-sm">ИИН</label>
				<input type="text" name="iin" autocomplete="off" class="form-control form-control-sm" 
				value="{{ $student->iin }}" pattern="\d{12}" disabled>
			</div>
		</div>
	</div>
	<div class="col-sm-1"></div>
	<div class="col-sm-4">
		<div class="text-center" style="height: 250px">
			<img src="{{$student->photo ?? asset('public/img/no-avatar.png')}}" class="img-fluid" alt="Photo">
		</div>
		<hr>
	</div>
</div>
<div class="card my-3">
	<div class="row card-body">
		<div class="col-sm-12"><h5>Обучение</h5><hr></div>
		<div class="col-sm-4">
			<label class="label-sm">Дата зачисления</label>
			<input type="date" name="enter" class="form-control form-control-sm" value="{{$student->enter}}" disabled>
		</div>
		<div class="col-sm-4">
			<label class="label-sm">Группа</label>
			<select name="group_id" class="form-control form-control-sm" disabled>
				<option value="">Не выбрано</option>
				@foreach($groups as $g)
				<option value="{{ $g->id }}" {{$g->id == $student->group_id ? 'selected' : ''}}>{{ $g->name }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-sm-4">
			<label class="label-sm">Форма оплаты</label>
			<select name="pay_id" class="form-control form-control-sm" disabled>
				<option value="">Не выбрано</option>
				@foreach($pays as $p)
				<option value="{{ $p->id }}" {{$p->id == $student->pay_id ? 'selected' : ''}}>{{ $p->name }}</option>
				@endforeach
			</select>
		</div>
		@if($student->group->students->count() >= 25)
		<div class="col-sm-4">
			<label class="label-sm pt-2">Подгруппа</label>
			<select name="subgroup" class="form-control form-control-sm" disabled>
				<option {{1 == $student->subgroup ? 'selected' : ''}}>1</option>
				<option {{2 == $student->subgroup ? 'selected' : ''}}>2</option>
			</select>
		</div>
		@endif
	</div>
</div>
<div class="card my-3">
	<div class="row card-body">
		<div class="col-sm-12"><h5>Контактные данные</h5><hr></div>
		<div class="col-sm-4">
			<label class="label-sm">Адрес</label>
			<input type="text" autocomplete="off" name="address" class="form-control form-control-sm" value="{{$student->address}}" disabled>
		</div>
		<div class="col-sm-4">
			<label class="label-sm">Телефон</label>
			<input type="text" autocomplete="off" name="phone" class="form-control form-control-sm" value="{{$student->phone}}" disabled>
		</div>
		<div class="col-sm-4">
			<label class="label-sm">E-mail</label>
			<input type="email" autocomplete="off" name="email" class="form-control form-control-sm" value="{{$student->email}}" disabled>
		</div>
	</div>
</div>
@endsection