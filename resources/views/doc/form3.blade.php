@extends('layouts.app')
@section('title', 'Форма 3')
@section('content')
<h3>Форма 3</h3>
<hr>
<form>
	<div class="row">
		<div class="form-group col-sm-6">
			<label>Преподаватель</label>
			<select name="teacher" class="form-control" required>
				<option value="">ФИО</option>
				@foreach($teachers as $teacher)
				<option value="{{ $teacher->id }}">{{ $teacher->fullName }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-sm-4">
			<label>Учебный год</label>
			<select name="year" class="form-control" required>
				<option value="">Выберите год</option>
				@for($year = date('Y') - 4; $year <= date('Y'); $year++)
				<option value="{{ $year }}">{{ $year.'-'.($year + 1) }}</option>
				@endfor
			</select>
		</div>
		<div class="col-sm-2">
			<label>&nbsp;</label><input type="submit" class="btn btn-info d-block" value="Скачать">
		</div>		
	</div>
</form>
@endsection