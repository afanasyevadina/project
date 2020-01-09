@extends('layouts.app')
@section('content')
<h3>График учебного процесса</h3>
<hr>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/graphic" method="post">
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
						<input type="number" name="year" class="form-control">
					</div>
					<div class="form-group">
						<label>1 семестр</label>
						<div class="row">
							<div class="col-sm-6">
								<input type="date" name="start1" class="form-control">
							</div>
							<div class="col-sm-6">
								<input type="date" name="end1" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>2 семестр</label>
						<div class="row">
							<div class="col-sm-6">
								<input type="date" name="start2" class="form-control">
							</div>
							<div class="col-sm-6">
								<input type="date" name="end2" class="form-control">
							</div>
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
	<thead>
		<tr>
			<th>Учебный год</th>
			<th class="text-center" colspan="2">1 семестр</th>
			<th class="text-center" colspan="2">2 семестр</th>
			<th class="text-right">
				<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Добавить новый</button>
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach($graphic as $g)
		<tr>
			<td>{{ $g->year }}</td>
			<td class="text-center">{{ date('d.m.Y', strtotime($g->start1)) }}</td>
			<td class="text-center">{{ date('d.m.Y', strtotime($g->end1)) }}</td>
			<td class="text-center">{{ date('d.m.Y', strtotime($g->start2)) }}</td>
			<td class="text-center">{{ date('d.m.Y', strtotime($g->end2)) }}</td>
			<td class="text-right">
				<button data-toggle="modal" data-target="#{{ $g->id }}" class="btn btn-sm btn-outline-success">Редактировать</button>
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
							<div class="form-group">
								<label>1 семестр</label>
								<div class="row">
									<div class="col-sm-6">
										<input type="date" name="start1" class="form-control" value="{{ $g->start1 }}">
									</div>
									<div class="col-sm-6">
										<input type="date" name="end1" class="form-control" value="{{ $g->end1 }}">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>2 семестр</label>
								<div class="row">
									<div class="col-sm-6">
										<input type="date" name="start2" class="form-control" value="{{ $g->start2 }}">
									</div>
									<div class="col-sm-6">
										<input type="date" name="end2" class="form-control" value="{{ $g->end2 }}">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="submit" class="btn btn-success" value="Сохранить">
							<a href="/graphic/{{ $g->id }}/delete" class="btn btn-light">Удалить</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		@endforeach            
	</tbody>
</table>
@endsection