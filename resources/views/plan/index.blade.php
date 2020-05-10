@extends('layouts.app')
@section('title', 'План учебного процесса')
@section('content')
<div class="alert alert-success col-sm-6" id="saved" hidden style="position: fixed;z-index: 999;top: 60px;right: 15px;">
	Сохранено
</div>
<div class="alert alert-success col-sm-6" id="deleted" hidden style="position: fixed;z-index: 999;top: 60px;right: 15px;">
	Удалено
</div>
<div class="d-flex justify-content-between">
	<h3>Учебный план</h3>
	@if(@$_GET['group'])
	<div class="dropdown">
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Действия
		</button>
		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
			<button class="dropdown-item" data-toggle="modal" data-target="#add">Добавить</button>
			<button class="dropdown-item" data-toggle="modal" data-target="#upload">Загрузить</button>
			<button class="dropdown-item" data-toggle="modal" data-target="#copy">Скопировать</button>
			<a href="/rup?group={{ $_GET['group'] }}" class="dropdown-item">РУП</a>
			@if($plans)
			<button class="dropdown-item" data-toggle="modal" data-target="#reset">Очистить</button>
			@endif
		</div>
	</div>
	@endif
</div>
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
<form class="mb-3">
	<div class="row">
		<div class="col-sm-6">
			<select name="group" class="form-control form-control-sm" required onchange="this.form.submit()">
				<option value="">Выберите группу</option>
				@foreach($groups as $g)
				<option value="{{ $g->id }}" {{ $g->id == @$_GET['group'] ? 'selected' : ''}}>{{ $g->name }}</option>
				@endforeach
			</select>
		</div>
	</div>
</form>
@if(@$_GET['group'])
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
		<tr class="table-active">
			<td>{{ $cikl['cikl']->short_name }}</td>
			<td colspan="17">{{ $cikl['cikl']->name }}</td>
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
			<td>{{ $p['theory'] + $p['practice'] + $p['project'] }}</td>
			<td>{{ $p['theory'] ? $p['theory'] : '' }}</td>
			<td>{{ $p['practice'] ? $p['practice'] : '' }}</td>
			<td>{{ $p['project'] ? $p['project'] : '' }}</td>
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
				<form action="/plans/{{$d->id}}" method="post" class="self-reload" data-alert="#saved">@csrf
					<h5 class="text-center my-3">{{ $d->semestr }} семестр</h5>
					<div class="row mx-4 my-2">
						<div class="col-sm-2">
							<input type="text" name="shifr" value="{{ $d->shifr }}" class="form-control form-control-sm" autocomplete="off" placeholder="Шифр">
						</div>
						<label class="col-sm-2">
							<input type="hidden" name="is_exam" value="">
							<input type="checkbox" name="is_exam" value="1" {{$d->is_exam ? 'checked' : ''}}>
							Экзамен
						</label>
						<label class="col-sm-2">
							<input type="hidden" name="is_zachet" value="">
							<input type="checkbox" name="is_zachet" value="1" {{$d->is_zachet ? 'checked' : ''}}>
							Зачет
						</label>
						<label class="col-sm-2">
							<input type="hidden" name="is_project" value="">
							<input type="checkbox" name="is_project" value="1" {{$d->is_project ? 'checked' : ''}}>
							Курсовая
						</label>
						<div class="col-sm-auto">
							<label>Кол-во недель</label>
						</div>
						<div class="col-sm-2">
							<input type="number" name="weeks" value="{{ $d->weeks }}" class="form-control form-control-sm">
						</div>
					</div>
					<div class="text-center">Распределение часов</div>
					<div class="row mx-4 my-2">
						<div class="col-sm-3">
							<label class="label-sm">Всего</label>
							<input type="number" name="total" value="{{ $d->total }}" class="form-control form-control-sm total" readonly>
						</div>
						<div class="col-sm-3">
							<label class="label-sm">Теоретических</label>
							<input type="number" name="theory" value="{{ $d->theory }}" class="form-control form-control-sm theory">
						</div>
						<div class="col-sm-3">
							<label class="label-sm">Практических</label>
							<input type="number" name="practice" value="{{ $d->practice }}" class="form-control form-control-sm practice" data-total="{{$d->lab + $d->practice}}">
						</div>
						<div class="col-sm-3">
							<label class="label-sm">Лабораторных</label>
							<input type="number" name="lab" value="{{ $d->lab }}" class="form-control form-control-sm lab">
						</div>
						<div class="col-sm-3">
							<label class="label-sm">Кол-во контрольных</label>
							<input type="number" name="controls" value="{{ $d->controls }}" class="form-control form-control-sm">
						</div>
						<div class="col-sm-3 consul" {{$d->is_exam ? '' : 'hidden'}}>
							<label class="label-sm">Консультация</label>
							<input type="number" class="form-control form-control-sm" 
							name="consul" 
							value="{{ $d->consul }}">
						</div>
						<div class="col-sm-3 exam" {{$d->is_exam ? '' : 'hidden'}}>
							<label class="label-sm">Экзамен</label>
							<input type="number" class="form-control form-control-sm" 
							name="exam" 
							value="{{ $d->exam }}">
						</div>
						<div class="col-sm-3 project" {{$d->is_project ? '' : 'hidden'}}>
							<label class="label-sm">Курсовая</label>
							<input type="number" class="form-control form-control-sm kurs" 
							name="project" 
							value="{{ $d->project }}">
						</div>
						<div class="col-sm-12 text-right">
							<input type="submit" class="btn btn-sm btn-outline-success" value="Сохранить">
							<button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#delete{{$d->id}}">Удалить</button>
						</div>
					</div>
					<div class="modal fade" id="delete{{$d->id}}">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Внимание!</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									Вы действительно хотите удалить дисциплину <i>{{$d->subject->name}}</i> из плана?
								</div>
								<div class="modal-footer">
									<a href="/plans/{{ $d->id }}/delete" class="btn btn-outline-secondary self-reload">Да</a>
									<button type="button" class="btn btn-light" data-dismiss="modal">Нет</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</td>
		</tr>
		@endforeach
		@endforeach
		@endforeach
	</tbody>
</table>
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
				<a href="/plans/{{@$_GET['group']}}/reset" class="btn btn-primary self-reload">Да</a>
				<button data-dismiss="modal" class="btn btn-light">Нет</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="copy">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/plans/copy">
				<input type="hidden" name="to" value="{{@$_GET['group']}}">
				<div class="modal-header">
					<h5 class="modal-title">Выбор группы</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class="list-group">
						@foreach($available as $item)
						<li class="list-group-item">
							<label><input type="radio" name="from" value="{{ $item->group_id }}">
								{{ $item->group->name }}, {{ $item->group->year_create }} год поступления
							</label>
						</li>
						@endforeach
					</ul>
				</div>
				<div class="modal-footer">
					<input type="submit" value="Выбрать" class="btn btn-outline-success">
					<button type="button" data-dismiss="modal" class="btn btn-light">Отмена</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="add">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/plans" method="post" class="self-reload">@csrf
				<input type="hidden" name="group_id" value="{{@$_GET['group']}}">
				<div class="modal-header">
					<h5 class="modal-title">Добавить в план</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12 form-group">
							<label class="label-sm">Дисциплина</label>
							<select name="subject_id" class="form-control form-control-sm" required>
								<option value="">Выберите дисциплину</option>
								@foreach($subjects as $subject)
								<option value="{{ $subject->id }}">{{ $subject->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-sm-12 form-group">
							<label class="label-sm">Цикл</label>
							<select name="cikl_id" class="form-control form-control-sm" required>
								<option value="">Выберите цикл</option>
								@foreach($cikls as $cikl)
								<option value="{{ $cikl->id }}">{{ $cikl->name }}</option>
								@endforeach
							</select>
						</div>
						<label class="col-sm-4">
							<input type="hidden" name="is_exam" value="">
							<input type="checkbox" name="is_exam" value="1">
							Экзамен
						</label>
						<label class="col-sm-4">
							<input type="hidden" name="is_zachet" value="">
							<input type="checkbox" name="is_zachet" value="1">
							Зачет
						</label>
						<label class="col-sm-4">
							<input type="hidden" name="is_project" value="">
							<input type="checkbox" name="is_project" value="1">
							Курсовая
						</label>
						<div class="col-sm-6">
							<label class="label-sm">Семестр</label>
							<select name="semestr" class="form-control form-control-sm" required>
								@for($s = 1; $s <= 8; $s++)
								<option>{{ $s }}</option>
								@endfor
							</select>
						</div>
						<div class="col-sm-6">
							<label class="label-sm">Кол-во недель</label>
							<input type="number" name="weeks" class="form-control form-control-sm total">
						</div>
					</div>
					<div class="text-center">Распределение часов</div>
					<div class="row">
						<div class="col-sm-6">
							<label class="label-sm">Всего</label>
							<input type="number" name="total" class="form-control form-control-sm total" disabled>
						</div>
						<div class="col-sm-6">
							<label class="label-sm">Теоретических</label>
							<input type="number" name="theory" class="form-control form-control-sm theory">
						</div>
						<div class="col-sm-6">
							<label class="label-sm">Практических</label>
							<input type="number" name="practice" class="form-control form-control-sm practice">
						</div>
						<div class="col-sm-6">
							<label class="label-sm">Лабораторных</label>
							<input type="number" name="lab" class="form-control form-control-sm lab">
						</div>
						<div class="col-sm-6">
							<label class="label-sm">Кол-во контрольных</label>
							<input type="number" name="controls" class="form-control form-control-sm">
						</div>
						<div class="col-sm-6 consul">
							<label class="label-sm">Консультация</label>
							<input type="number" class="form-control form-control-sm" 
							name="consul" disabled>
						</div>
						<div class="col-sm-6 exam">
							<label class="label-sm">Экзамен</label>
							<input type="number" class="form-control form-control-sm" 
							name="exam" disabled >
						</div>
						<div class="col-sm-6 project">
							<label class="label-sm">Курсовая</label>
							<input type="number" class="form-control form-control-sm kurs" name="project" disabled>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" value="Сохранить" class="btn btn-outline-success">
					<button type="button" data-dismiss="modal" class="btn btn-light">Отмена</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endif
@endsection
@section('scripts')
<script type="text/javascript" src="/public/js/plan.js"></script>
@endsection