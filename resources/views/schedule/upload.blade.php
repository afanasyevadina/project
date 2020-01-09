@extends('layouts.app')
@section('content')
<h3>Загрузка основного расписания</h3>
<hr>
<form action="/schedule/upload" method="post" enctype="multipart/form-data">
	@csrf
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				<label>Учебный год</label>
				<select name="year" class="form-control">
					@for($i = date('Y') - 1; $i <= date('Y'); $i++)
					<option value="{{ $i }}">{{ $i . '-' . ($i + 1) }}</option>
					@endfor
				</select>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Семестр</label>
				<select name="semestr" class="form-control">
					<option>1</option>
					<option>2</option>
				</select>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Файл Excel</label>
				<input type="file" name="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
			</div>
		</div>
	</div>
	<input type="submit" class="btn btn-outline-success" value="Загрузить">
</form>
@endsection