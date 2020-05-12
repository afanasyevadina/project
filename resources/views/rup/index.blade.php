@extends('layouts.app')
@section('title', 'Рабочий учебный план на год')
@section('content')
<div class="alert alert-success col-sm-6" id="saved" hidden style="position: fixed;z-index: 999;top: 60px;right: 15px;">
	Сохранено
</div>
<h3>Рабочий учебный план на год</h3>
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
			<label>Курс</label>
			<select name="kurs" class="form-control form-control-sm">
				@for($i = 1; $i <= 4; $i++)
				<option value="{{ $i }}" {{ $i == $kurs ? 'selected' : '' }}>{{ $i }}</option>
				@endfor
			</select>
		</div>
		<div class="col-sm-2">
			<label>&nbsp;</label><input type="submit" class="btn btn-sm btn-info d-block" value="Показать">
		</div>
	</div>
</form>
@if($group)
<form action="/rup/{{ $group->id }}/{{ $kurs }}" method="POST" class="self-reload" data-alert="#saved">
	@csrf
	<div class="py-2 d-flex justify-content-between">
		<p>Количество студентов: {{ count($group->students) }}</p>
		<div>
			<input type="submit" value="Сохранить" class="btn btn-sm btn-outline-success">
			<a href="/rup/{{ $group->id }}/export/{{ $kurs }}" class="btn btn-sm btn-outline-info">Экспорт в Excel</a>
			<a href="/rup/{{ $group->id }}/refresh/{{ $kurs }}" class="btn btn-sm btn-outline-secondary self-reload">Обновить подгруппы</a>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-sm table-xs table-bordered">
			<thead>
				<tr>
					<th rowspan="2">Преподаватели</th>
					<th rowspan="2">Наименование предмета</th>
					<th class="text-center" colspan="3">Распределение по семестрам</th>
					<th rowspan="2">К/р</th>
					<th class="text-center" colspan="3">По РУП</th>
					<th class="vertical" rowspan="2"><p>Всего часов на учебный год</p></th>
					<th class="vertical" rowspan="2"><p>Из них теор.</p></th>
					<th class="vertical" rowspan="2"><p>Из них ЛПР</p></th>
					<th class="vertical" rowspan="2"><p>Из них курс. раб.</p></th>
					<th class="text-center" colspan="3">1 семестр</th>
					<th class="text-center" colspan="3">2 семестр</th>
					<th rowspan="2">Конс.</th>
					<th rowspan="2">Экз.</th>
					<th rowspan="2">Всего за год</th>
				</tr>
				<tr>
					<th>экз.</th>
					<th>зач.</th>
					<th>курс. раб.</th>
					<th>всего по РУП</th>
					<th>теор.</th>
					<th>лаб-практ.</th>
					<th>кол-во нед.</th>
					<th>часов в нед.</th>
					<th>часов в сем.</th>
					<th>кол-во нед.</th>
					<th>часов в нед.</th>
					<th>часов в сем.</th>
				</tr>
			</thead>
			<tbody>
				@foreach($plans as $key => $p)
				<?php @sort($p['zachet_sem']); ?>
				<tr>
					<td>
						<input type="hidden" name="plan[{{$key}}][subject]" value="{{$p['subject']->id}}">
						<input type="hidden" name="plan[{{$key}}][subgroup]" value="{{$p['subgroup']}}">
						<input type="hidden" name="plan[{{$key}}][cikl_id]" value="{{$p['cikl_id']}}">
						<select name="plan[{{$key}}][teacher_id]" class="form-control form-control-sm">
							<option value="">ФИО</option>
							@foreach($teachers as $t)
							<option value="{{$t->id}}" {{$t->id == $p['teacher']->id ? 'selected' : ''}}>{{$t->shortName}}</option>
							@endforeach
						</select>
					</td>
					<td>{{ $p['subject']->name }}</td>
					<td>{{ @$p['exam_sem'] }}</td>
					<td>{{ @implode(', ', $p['zachet_sem']) }}</td>
					<td>{{ @$p['project_sem'] }}</td>
					<td>{{ $p['control'] ? $p['control'] : '' }}</td>
					<td>{{ $p['theory_main'] + $p['practice_main'] }}</td>
					<td>{{ $p['theory_main'] ? $p['theory_main'] : '' }}</td>
					<td>{{ $p['practice_main'] ? $p['practice_main'] : '' }}</td>
					<td>{{ $p['theory'] + $p['practice'] + @$p['project'] }}</td>
					<td>{{ @$p['theory'] ? $p['theory'] : '' }}</td>
					<td>{{ @$p['practice'] ? $p['practice'] : '' }}</td>
					<td>{{ @$p['project'] }}</td>
					<td>{{ @$p['weeks1'] }}</td>
					<td>{{ @($p['sem1'] && $p['weeks1']) ? ceil($p['sem1'] / $p['weeks1']) :'' }}</td>
					<td>{{ @$p['sem1'] }}</td>
					<td>{{ @$p['weeks2'] }}</td>
					<td>{{ @($p['sem2'] && $p['weeks2']) ? ceil($p['sem2'] / $p['weeks2']) :'' }}</td>
					<td>{{ @$p['sem2'] }}</td>
					<td>{{ @$p['consul'] ? $p['consul'] : '' }}</td>
					<td>{{ @$p['exam'] ? $p['exam'] : '' }}</td>
					<td>{{ $p['theory'] + $p['practice'] + @$p['project'] + $p['consul'] + $p['exam'] }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</form>
@endif
@endsection