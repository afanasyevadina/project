@extends('layouts.app')
@section('content')
<h3>Учебный план</h3>
<hr>
@if(Session::has('errors'))
<div class="alert alert-warning">
	<p>Пропущены следующие строки:</p>
	@foreach(array_filter(session('errors')) as $error)
	<i>{{$error}}</i><br>
	@endforeach
</div>
@endif
<?php session()->forget('errors'); ?>
<form>
	<div class="row">
		<div class="col-sm-6">
			<select name="group" class="form-control" required onchange="this.form.submit()">
				<option value="">Выберите группу</option>
				@foreach($groups as $g)
				<option value="{{ $g->id }}" {{ $g->id == @$_GET['group'] ? 'selected' : ''}}>{{ $g->name }}</option>
				@endforeach
			</select>
		</div>
	</div>
</form>
@if(@$_GET['group'])
<form method="post" action="/plans">
	@csrf
	<div class="text-right">
		<input type="submit" value="Сохранить" class="btn btn-sm btn-outline-info">
		<button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#upload">Загрузить</button>
		<a href="/rup?group={{ $_GET['group'] }}" class="btn btn-sm btn-outline-secondary">РУП</a>
		<button type="button" data-toggle="modal" data-target="#reset" class="btn btn-sm btn-outline-danger">Удалить</button>
	</div>
	<hr>
	<table class="table table-bordered table-sm">
		<thead>
			<tr>
				<th rowspan="3">№ п/п</th>
				<th rowspan="3">Наименование учебных дисциплин</th>
				<th colspan="3">Распределение по семестрам</th>
				<th class="text-nowrap" rowspan="3">К-во<br>к/р</th>
				<th colspan="4">Количество часов</th>
				<th colspan="8">Распределение по курсам и семестрам</th>
			</tr>
			<tr>
				<th rowspan="2">экзаменов</th>
				<th rowspan="2">зачет</th>
				<th rowspan="2">курс.проект</th>
				<th rowspan="2">Всего</th>
				<th colspan="3">Из них</th>
				<th colspan="2">1 курс</th>
				<th colspan="2">2 курс</th>
				<th colspan="2">3 курс</th>
				<th colspan="2">4 курс</th>
			</tr>
			<tr>
				<th>теорет.</th>
				<th>практ.</th>
				<th>курс.проект</th>
				<th>1 сем</th>
				<th>2 сем</th>
				<th>3 сем</th>
				<th>4 сем</th>
				<th>5 сем</th>
				<th>6 сем</th>
				<th>7 сем</th>
				<th>8 сем</th>
			</tr>
		</thead>
		<tbody>
			@foreach($plans as $cikl)
			<tr>
				<td>{{ $cikl['cikl']->short_name }}</td>
				<td colspan="10">{{ $cikl['cikl']->name }}</td>
			</tr>
			@foreach($cikl['subjects'] as $key => $p)
			<?php @sort($p['zachet_sem']); ?>
			<tr data-toggle="collapse" data-target=".col{{ $key }}">
				<td class="text-nowrap">{{ $p['shifr'] }}</td>
				<td>{{ $p['subject']->name }}</td>
				<td>{{ @$p['exam_sem'] }}</td>
				<td>{{ @implode(', ', $p['zachet_sem']) }}</td>
				<td>{{ @$p['project_sem'] }}</td>
				<td>{{ $p['control'] ? $p['control'] : '' }}</td>
				<td>{{ $p['theory'] + $p['practice'] + @$p['project'] }}</td>
				<td>{{ $p['theory'] ? $p['theory'] : '' }}</td>
				<td>{{ $p['practice'] ? $p['practice'] : '' }}</td>
				<td>{{ @$p['project'] }}</td>
				<td>{{ @$p['sem1'] }}</td>
				<td>{{ @$p['sem2'] }}</td>
				<td>{{ @$p['sem3'] }}</td>
				<td>{{ @$p['sem4'] }}</td>
				<td>{{ @$p['sem5'] }}</td>
				<td>{{ @$p['sem6'] }}</td>
				<td>{{ @$p['sem7'] }}</td>
				<td>{{ @$p['sem8'] }}</td>
			</tr>
			@foreach($p['details'] as $d)
			<tr class="collapse col{{ $key }} bg-light">
				<td colspan="18">
					<h5 class="text-center my-3">{{ $d->semestr }} семестр</h5>
					<div class="row mx-4 my-2">
						<label class="col-sm-2">
							<input type="hidden" name="plan[{{$d->subject_id}}][{{$d->id}}][is_exam]" value="">
							<input type="checkbox" name="plan[{{$d->subject_id}}][{{$d->id}}][is_exam]" value="1" {{$d->is_exam ? 'checked' : ''}}>
							Экзамен
						</label>
						<label class="col-sm-2">
							<input type="hidden" name="plan[{{$d->subject_id}}][{{$d->id}}][is_zachet]" value="">
							<input type="checkbox" name="plan[{{$d->subject_id}}][{{$d->id}}][is_zachet]" value="1" {{$d->is_zachet ? 'checked' : ''}}>
							Зачет
						</label>
						<label class="col-sm-2">
							<input type="hidden" name="plan[{{$d->subject_id}}][{{$d->id}}][is_project]" value="">
							<input type="checkbox" name="plan[{{$d->subject_id}}][{{$d->id}}][is_project]" value="1" {{$d->is_project ? 'checked' : ''}}>
							Курсовая
						</label>
						<div class="col-sm-auto">
							<label>Кол-во недель</label>
						</div>
						<div class="col-sm-2">
							<input type="number" name="plan[{{$d->subject_id}}][{{$d->id}}][weeks]" value="{{ $d->weeks }}" class="form-control form-control-sm">
						</div>
					</div>
					<div class="text-center">Распределение часов</div>
					<div class="row mx-4 my-2">
						<div class="col-sm-3">
							<label class="label-sm">Всего</label>
							<input type="number" name="plan[{{$d->subject_id}}][{{$d->id}}][total]" value="{{ $d->total }}" class="form-control form-control-sm">
						</div>
						<div class="col-sm-3">
							<label class="label-sm">Теоретических</label>
							<input type="number" name="plan[{{$d->subject_id}}][{{$d->id}}][theory]" value="{{ $d->theory }}" class="form-control form-control-sm">
						</div>
						<div class="col-sm-3">
							<label class="label-sm">Практических</label>
							<input type="number" name="plan[{{$d->subject_id}}][{{$d->id}}][practice]" value="{{ $d->practice }}" class="form-control form-control-sm">
						</div>
						<div class="col-sm-3">
							<label class="label-sm">Лабораторных</label>
							<input type="number" name="plan[{{$d->subject_id}}][{{$d->id}}][lab]" value="{{ $d->lab }}" class="form-control form-control-sm">
						</div>
						<div class="col-sm-3">
							<label class="label-sm">Кол-во контрольных</label>
							<input type="number" name="plan[{{$d->subject_id}}][{{$d->id}}][controls]" value="{{ $d->controls }}" class="form-control form-control-sm">
						</div>
						<div class="col-sm-3 consul" {{$d->is_exam ? '' : 'hidden'}}>
							<label class="label-sm">Консультация</label>
							<input type="number" class="form-control form-control-sm" 
							name="plan[{{$d->subject_id}}][{{$d->id}}][consul]" 
							value="{{ $d->consul }}">
						</div>
						<div class="col-sm-3 exam" {{$d->is_exam ? '' : 'hidden'}}>
							<label class="label-sm">Экзамен</label>
							<input type="number" class="form-control form-control-sm" 
							name="plan[{{$d->subject_id}}][{{$d->id}}][exam]" 
							value="{{ $d->exam }}">
						</div>
						<div class="col-sm-3 project" {{$d->is_project ? '' : 'hidden'}}>
							<label class="label-sm">Курсовая</label>
							<input type="number" class="form-control form-control-sm" 
							name="plan[{{$d->subject_id}}][{{$d->id}}][project]" 
							value="{{ $d->project }}">
						</div>
					</div>
				</td>
			</tr>
			@endforeach
			@endforeach
			@endforeach
		</tbody>
	</table>
</form>
<div class="modal fade" id="upload">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/plans/upload" method="post" enctype="multipart/form-data">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Загрузить из файла</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="group" value="{{ @$_GET['group'] }}">
					<div class="form-group">
						<label>Файл для импорта</label>
						<input type="file" name="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
					</div>
				</div>
				<div class="modal-footer"><input type="submit" class="btn btn-success" value="Загрузить"></div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="reset">
	<div class="modal-dialog">
		<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Подтверждение</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Учебный план на данную группу будет полностью удален. Продолжить?
				</div>
				<div class="modal-footer">
					<a href="/plans/{{@$_GET['group']}}/reset" class="btn btn-primary">Да</a>
					<button data-dismiss="modal" class="btn btn-light">Нет</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endif
@endsection