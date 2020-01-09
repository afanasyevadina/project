@extends('layouts.app')
@section('content')
<h3>Загрузка изменений в расписании</h3>
<hr>
<form action="/changes/upload" method="post" enctype="multipart/form-data">
	@csrf
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label>Дата</label>
				<input type="date" name="date" class="form-control" required>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label>Файл Excel</label>
				<input type="file" name="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
			</div>
		</div>
	</div>
	<input type="submit" class="btn btn-outline-success" value="Загрузить">
</form>
@endsection