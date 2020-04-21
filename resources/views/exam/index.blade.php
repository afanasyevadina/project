@extends('layouts.app')
@section('title', 'График экзаменов')
@section('content')
<?php
$kurs = ceil(@$_GET['semestr'] / 2 );
?>
<h3>График экзаменов</h3>
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
<p>Учебный год: {{ ($group->year_create + $kurs - 1).'-'.($group->year_create + $kurs) }}</p>
<p>Семестр: {{ $_GET['semestr'] % 2 ? 1 : 2 }}</p>
<p>{{ $kurs }} курс, группа {{ $group->codes[$kurs] }}</p>
<table class="table table-bordered">
	<thead>
		<tr>
			<th class="text-center" rowspan="2">№</th>
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
			<td class="text-center">{{$key + 1}}</td>
			<td>{{ $dis->subject->name }}<i class="d-block">{{ $dis->teacher->shortName }}</i></td>
			<td class="text-center">
				{{ $dis->graphicExam->date ? date('d.m.Y', strtotime($dis->graphicExam->date)) : '' }}
			</td>
			<td class="text-center">{{ $dis->graphicExam->time }}</td>
			<td class="text-center">{{ $dis->graphicExam->cab->num }}</td>
			<td class="text-center">
				{{ $dis->graphicExam->kons_date ? date('d.m.Y', strtotime($dis->graphicExam->kons_date)) : '' }}
			</td>
			<td class="text-center">{{ $dis->graphicExam->kons_time }}</td>
			<td class="text-center">{{ $dis->graphicExam->konsCab->num }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@else
<div class="alert alert-warning">В этом семестре нет экзаменов.</div>
@endif
@endif
@endsection