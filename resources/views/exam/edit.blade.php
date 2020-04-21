@extends('layouts.app')
@section('title', 'Редактор графика экзаменов')
@section('content')
<?php
$kurs = ceil(@$_GET['semestr'] / 2 );
?>
<div class="alert alert-success col-sm-6 fixed-alert" id="saved" hidden>
	Сохранено
</div>
<h3>Редактор графика экзаменов</h3>
<hr>
<form>
	<div class="row">
		<div class="form-group col-sm-4">
			<label>Группа</label>
			<select name="group" class="form-control form-control-sm">
				<option value="">Группа</option>
				@foreach($groups as $g)
				<option value="{{ $g->id }}" {{ $g->id == @$_GET['group'] ? 'selected' : '' }}>{{ $g->name }}</option>
				@endforeach
			</select>
		</div>		
		<div class="form-group col-sm-4">
			<label>Семестр</label>
			<select name="semestr" class="form-control form-control-sm">
				<option value="">Семестр</option>
				@for($k = 1; $k <= 8; $k++)
				<option value="{{ $k }}" {{ $k == @$_GET['semestr'] ? 'selected' : '' }}>{{ $k }}</option>
				@endfor
			</select>
		</div>
		<div class="col-sm-2">
			<label>&nbsp;</label><input type="submit" class="btn btn-sm btn-info d-block" value="Показать">
		</div>		
	</div>
</form>
@if(@$_GET['group'])
<hr>
@if(count($exams))
<form action="/exams" method="post" class="self-reload" data-alert="#saved">@csrf
	<div class="d-flex justify-content-between">
		<div>
			<p>Учебный год: {{ ($group->year_create + $kurs - 1).'-'.($group->year_create + $kurs) }}</p>
			<p>Семестр: {{ $_GET['semestr'] % 2 ? 1 : 2 }}</p>
			<p>{{ $kurs }} курс, группа {{ $group->codes[$kurs] }}</p>
		</div>
		<div>
			<input type="submit" class="btn btn-sm btn-outline-primary" value="Сохранить">
		</div>
	</div>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th rowspan="2" style="vertical-align: middle;">Дисциплина</th>
				<th class="text-center" colspan="3">Экзамен</th>
				<th class="text-center" colspan="3">Консультация</th>
			</tr>
			<tr>
				<th class="text-center">Дата</th>
				<th class="text-center">Время</th>
				<th class="text-center">Кабинет</th>
				<th class="text-center">Дата</th>
				<th class="text-center">Время</th>
				<th class="text-center">Кабинет</th>
			</tr>
		</thead>
		<tbody>
			@foreach($exams as $key => $dis)
			<tr>
				<td>{{ $dis->subject->name }}<i class="d-block">{{ $dis->teacher->shortName }}</i></td>
				<td>
					<input type="date" name="exams[{{$dis->id}}][date]" 
					value="{{$dis->graphicExam->date}}" class="form-control">
				</td>
				<td>
					<input type="time" name="exams[{{$dis->id}}][time]" 
					value="{{$dis->graphicExam->time}}" class="form-control">
				</td>
				<td>
					<select class="form-control" name="exams[{{$dis->id}}][cab_id]">
						<option value=""></option>
						@foreach($cabs as $cab)
						<option value="{{$cab->id}}" {{$cab->id==$dis->graphicExam->cab_id ? 'selected' : ''}}>
							{{$cab->num}}
						</option>
						@endforeach
					</select>
				</td>
				<td>
					<input type="date" name="exams[{{$dis->id}}][kons_date]" 
					value="{{$dis->graphicExam->kons_date}}" class="form-control">
				</td>
				<td>
					<input type="time" name="exams[{{$dis->id}}][kons_time]" 
					value="{{$dis->graphicExam->kons_time}}" class="form-control">
				</td>
				<td>
					<select class="form-control" name="exams[{{$dis->id}}][kons_cab_id]">
						<option value=""></option>
						@foreach($cabs as $cab)
						<option value="{{$cab->id}}" {{$cab->id==$dis->graphicExam->kons_cab_id ? 'selected' : ''}}>
							{{$cab->num}}
						</option>
						@endforeach
					</select>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</form>
@else
<div class="alert alert-warning">В этом семестре нет экзаменов.</div>
@endif
@endif
@endsection