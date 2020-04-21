@extends('layouts.app')
@section('title', 'График учебного процесса')
@section('content')
<div class="d-flex justify-content-between">
	<h3>График учебного процесса</h3>
	<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Добавить новый</button>
</div>
<hr>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/graphic" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">График учебного процесса</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Учебный год</label>
						<input type="number" name="year" class="form-control form-control-sm">
					</div>
					<h5 class="text-center">1 семестр</h5>
					<div class="row">
						<div class="form-group col-sm-6">
							<label>Начало</label>
							<input type="date" name="start1" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-6">
							<label>Окончание</label>
							<input type="date" name="end1" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-6">
							<label>Количество недель</label>
							<input type="number" name="weeks1" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-6">
							<label>Теор. обучение</label>
							<input type="number" name="teor1" class="form-control form-control-sm">
						</div>
					</div>
					<hr>
					<h5 class="text-center">2 семестр</h5>
					<div class="row">
						<div class="form-group col-sm-6">
							<label>Начало</label>
							<input type="date" name="start2" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-6">
							<label>Окончание</label>
							<input type="date" name="end2" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-6">
							<label>Количество недель</label>
							<input type="number" name="weeks2" class="form-control form-control-sm">
						</div>
						<div class="form-group col-sm-6">
							<label>Теор. обучение</label>
							<input type="number" name="teor2" class="form-control form-control-sm">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-success" value="Сохранить">
				</div>
			</form>
		</div>
	</div>
</div>
<table class="table table-bordered">
	<thead class="table-active">
		<tr>
			<th rowspan="2" class="text-center font-weight-normal">Учебный год</th>
			<th class="text-center font-weight-normal" colspan="3">1 семестр</th>
			<th class="text-center font-weight-normal" colspan="3">2 семестр</th>
			<th rowspan="2" class="text-center font-weight-normal">Группы</th>
			<th rowspan="2"></th>
		</tr>
		<tr>
			<th class="text-center font-weight-normal">Дата начала</th>
			<th class="text-center font-weight-normal">Дата окончания</th>
			<th class="text-center font-weight-normal">Количество недель</th>
			<th class="text-center font-weight-normal">Дата начала</th>
			<th class="text-center font-weight-normal">Дата окончания</th>
			<th class="text-center font-weight-normal">Количество недель</th>
		</tr>
	</thead>
	<tbody>
		@foreach($graphic as $g)
		<tr>
			<td>{{ $g->year }}</td>
			<td class="text-center">{{ date('d.m.Y', strtotime($g->start1)) }}</td>
			<td class="text-center">{{ date('d.m.Y', strtotime($g->end1)) }}</td>
			<td class="text-center">{{ $g->weeks1 }} / {{ $g->teor1 }}</td>
			<td class="text-center">{{ date('d.m.Y', strtotime($g->start2)) }}</td>
			<td class="text-center">{{ date('d.m.Y', strtotime($g->end2)) }}</td>
			<td class="text-center">{{ $g->weeks2 }} / {{ $g->teor2 }}</td>
			<td class="text-center">{{ implode(', ', $g->groups()->pluck('name')->toArray()) }}</td>
			<td class="text-right">
				<button data-toggle="modal" data-target="#{{ $g->id }}" class="btn btn-sm btn-outline-primary">Редактировать</button>
			</td>
		</tr>
		<div class="modal fade" id="{{ $g->id }}">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="/graphic/{{ $g->id }}" method="post">
						@csrf
						<input type="hidden" name="year" value="{{ $g->year }}">
						<div class="modal-header">
							<h5 class="modal-title">{{ $g->year }}</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<h5 class="text-center">1 семестр</h5>
							<div class="row">
								<div class="form-group col-sm-6">
									<label>Начало</label>
									<input type="date" name="start1" class="form-control form-control-sm" value="{{ $g->start1 }}">
								</div>
								<div class="form-group col-sm-6">
									<label>Окончание</label>
									<input type="date" name="end1" class="form-control form-control-sm" value="{{ $g->end1 }}">
								</div>
								<div class="form-group col-sm-6">
									<label>Количество недель</label>
									<input type="number" name="weeks1" class="form-control form-control-sm" value="{{ $g->weeks1 }}">
								</div>
								<div class="form-group col-sm-6">
									<label>Теор. обучение</label>
									<input type="number" name="teor1" class="form-control form-control-sm" value="{{ $g->teor1 }}">
								</div>
							</div>
							<hr>
							<h5 class="text-center">2 семестр</h5>
							<div class="row">
								<div class="form-group col-sm-6">
									<label>Начало</label>
									<input type="date" name="start2" class="form-control form-control-sm" value="{{ $g->start2 }}">
								</div>
								<div class="form-group col-sm-6">
									<label>Окончание</label>
									<input type="date" name="end2" class="form-control form-control-sm" value="{{ $g->end2 }}">
								</div>
								<div class="form-group col-sm-6">
									<label>Количество недель</label>
									<input type="number" name="weeks2" class="form-control form-control-sm" value="{{ $g->weeks2 }}">
								</div>
								<div class="form-group col-sm-6">
									<label>Теор. обучение</label>
									<input type="number" name="teor2" class="form-control form-control-sm" value="{{ $g->teor2 }}">
								</div>
							</div>
							<hr>
							<div class="form-group row">
								@foreach($groups as $group)
								<div class="col-sm-4"><label>
									<input type="checkbox" name="groups[]" value="{{$group->id}}" {{in_array($group->id, $g->groups()->pluck('group_id')->toArray()) ? 'checked' : (@in_array($group->id, $used[$g->year]) ? 'disabled' : '')}}>
									{{$group->name}}
								</label></div>
								@endforeach
							</div>
						</div>
						<div class="modal-footer">
							<input type="submit" class="btn btn-success" value="Сохранить">
							<a href="/graphic/{{ $g->id }}/delete" class="btn btn-light self-reload">Удалить</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		@endforeach            
	</tbody>
</table>
<script type="text/javascript">
	document.querySelectorAll('[name="start1"]').forEach(el => el.onchange = function() {
		let start = this.value
		let end = this.closest('.modal').querySelector('[name="end1"]').value
		if(start && end) {
			let weeks = Math.ceil((newDate(end.getTime()) - new Date(start.getTime())) / (1000*3600*24*7))
			this.closest('.modal').querySelector('[name="weeks1"]').value = weeks
		}
	})
	document.querySelectorAll('[name="start2"]').forEach(el => el.onchange = function() {
		let start = this.value
		let end = this.closest('.modal').querySelector('[name="end2"]').value
		if(start && end) {
			let weeks = Math.ceil((newDate(end.getTime()) - new Date(start.getTime())) / (1000*3600*24*7))
			this.closest('.modal').querySelector('[name="weeks2"]').value = weeks
		}
	})
	document.querySelectorAll('[name="end1"]').forEach(el => el.onchange = function() {
		let end = this.value
		let start = this.closest('.modal').querySelector('[name="start1"]').value
		if(start && end) {
			let weeks = Math.ceil((newDate(end.getTime()) - new Date(start.getTime())) / (1000*3600*24*7))
			this.closest('.modal').querySelector('[name="weeks1"]').value = weeks
		}
	})
	document.querySelectorAll('[name="end2"]').forEach(el => el.onchange = function() {
		let end = this.value
		let start = this.closest('.modal').querySelector('[name="start2"]').value
		if(start && end) {
			let weeks = Math.ceil((newDate(end.getTime()) - new Date(start.getTime())) / (1000*3600*24*7))
			this.closest('.modal').querySelector('[name="weeks2"]').value = weeks
		}
	})
	document.querySelectorAll('[name="weeks1"]').forEach(el => el.oninput = function() {
		let weeks = this.value
		let start = this.closest('.modal').querySelector('[name="start1"]').value
		if(start && weeks) {
			let end = new Date(new Date(start).getTime() + weeks * 1000*3600*24*7)
			this.closest('.modal').querySelector('[name="end1"]').value = end.toISOString().split('T')[0]
		}
	})
	document.querySelectorAll('[name="weeks2"]').forEach(el => el.oninput = function() {
		let weeks = this.value
		let start = this.closest('.modal').querySelector('[name="start2"]').value
		if(start && weeks) {
			let end = new Date(new Date(start).getTime() + weeks * 1000*3600*24*7)
			this.closest('.modal').querySelector('[name="end2"]').value = end.toISOString().split('T')[0]
		}
	})
</script>
@endsection