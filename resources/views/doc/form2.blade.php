@extends('layouts.app')
@section('title', 'Форма 2')
@section('content')
<h3>Форма 2</h3>
<hr>
<form>
	<div class="row">
		<div class="form-group col-sm-3">
			<label>Группа</label>
			<select name="group" class="form-control" required>
				<option value="">Выберите группу</option>
				@foreach($groups as $group)
				<option value="{{ $group->id }}">{{ $group->name }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-sm-2">
			<label>Учебный год</label>
			<select name="year" class="form-control" required>
				@for($year = date('Y') - 4; $year <= date('Y'); $year++)
				<option value="{{ $year }}">{{ $year.'-'.($year + 1) }}</option>
				@endfor
			</select>
		</div>
		<div class="form-group col-sm-2">
			<label>Семестр</label>
			<select name="semestr" class="form-control" required>
				<option>1</option>
				<option>2</option>
			</select>
		</div>
		<div class="form-group col-sm-3">
			<label>Месяц</label>
			<select name="month" class="form-control" required>
				<option value="09">Сентябрь</option>
				<option value="10">Октябрь</option>
				<option value="11">Ноябрь</option>
				<option value="12">Декабрь</option>
				<option value="01">Январь</option>
				<option value="02">Февраль</option>
				<option value="03">Март</option>
				<option value="04">Апрель</option>
				<option value="05">Май</option>
				<option value="06">Июнь</option>
			</select>
		</div>
		<div class="col-sm-2">
			<label>&nbsp;</label><input type="submit" class="btn btn-info d-block" value="Скачать">
		</div>		
	</div>
</form>
@endsection