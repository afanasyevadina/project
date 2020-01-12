@extends('layouts.app')
@section('content')
<h3>Рабочий учебный план группы {{ $group->name }} на {{ $group->year_create + $kurs - 1 }} - {{ $group->year_create + $kurs }} уч.год</h3>
<hr>
<form>
	<div class="form-group col-sm-6">
		<label>Учебный год</label>
		<select name="kurs" class="form-control form-control-sm" onchange="this.form.submit()">
			@for($i = 1; $i <= 4; $i++)
			<option value="{{ $i }}" {{ $i == $kurs ? 'selected' : '' }}>{{ $group->year_create + $i - 1 }} - {{ $group->year_create + $i }}</option>
			@endfor
		</select>
	</div>
</form>
<div class="text-right form-group">
	<a href="/rup/{{ $group->id }}/refresh/{{ $kurs }}" class="btn btn-sm btn-outline-secondary">Обновить</a>
</div>
<div class="table-responsive">
	<table class="table table-sm table-xs table-bordered">
		<thead>
			<tr>
				<th rowspan="2">Преподаватели</th>
				<th rowspan="2">Наименование предмета</th>
				<th colspan="3">Распределение по семестрам</th>
				<th rowspan="2">К/р</th>
				<th colspan="3">По РУП</th>
				<th class="vertical" rowspan="2"><p>Всего часов на учебный год</p></th>
				<th class="vertical" rowspan="2"><p>Из них теор.</p></th>
				<th class="vertical" rowspan="2"><p>Из них ЛПР</p></th>
				<th class="vertical" rowspan="2"><p>Из них курс. раб.</p></th>
				<th colspan="3">1 семестр</th>
				<th colspan="3">2 семестр</th>
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
			@foreach($plans as $p)
			<?php @sort($p['zachet_sem']); ?>
			<tr>
				<td>{{ $p['teacher']->name }}</td>
				<td>{{ $p['subject']->name }}</td>
				<td>{{ @$p['exam_sem'] }}</td>
				<td>{{ @implode(', ', $p['zachet_sem']) }}</td>
				<td>{{ @$p['project_sem'] }}</td>
				<td>{{ $p['control'] ? $p['control'] : '' }}</td>
				<td>{{ $p['theory_main'] + $p['practice_main'] }}</td>
				<td>{{ $p['theory_main'] }}</td>
				<td>{{ $p['practice_main'] }}</td>
				<td>{{ $p['theory'] + $p['practice'] + @$p['project'] }}</td>
				<td>{{ @$p['theory'] ? $p['theory'] : '' }}</td>
				<td>{{ @$p['practice'] ? $p['practice'] : '' }}</td>
				<td>{{ @$p['project'] }}</td>
				<td>{{ @$p['weeks1'] }}</td>
				<td>{{ @($p['sem1'] && $p['week1']) ? ceil($p['sem1'] / $p['weeks1']) :'' }}</td>
				<td>{{ @$p['sem1'] }}</td>
				<td>{{ @$p['weeks2'] }}</td>
				<td>{{ @($p['sem2'] && $p['week2']) ? ceil($p['sem2'] / $p['weeks2']) :'' }}</td>
				<td>{{ @$p['sem2'] }}</td>
				<td>{{ @$p['consul'] ? $p['consul'] : '' }}</td>
				<td>{{ @$p['exam'] ? $p['exam'] : '' }}</td>
				<td>{{ $p['theory'] + $p['practice'] + @$p['project'] + $p['consul'] + $p['exam'] }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection