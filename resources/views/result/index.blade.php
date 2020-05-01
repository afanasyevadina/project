@extends('layouts.app')
@section('title', 'Аттестация')
@section('content')
<h3>Аттестация</h3>
<hr>
<form class="mb-3">
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
			<select name="sem" class="form-control form-control-sm">
				<option value="">Семестр</option>
				@for($k = 1; $k <= 8; $k++)
				<option value="{{ $k }}" {{ $k == @$_GET['sem'] ? 'selected' : '' }}>{{ $k }}</option>
				@endfor
			</select>
		</div>
		<div class="col-sm-2 form-group">
			<label>&nbsp;</label><input type="submit" class="btn btn-sm btn-info d-block" value="Показать">
		</div>		
	</div>
</form>
@if($dis)
{{ $dis->appends(Request::except('page'))->links() }}
<table class="table table-hover">
	<thead>
		<th>Группа</th>
		<th>Предмет</th>
		<th class="text-center">Учебный год</th>
		<th class="text-center">Семестр</th>
		<th>Преподаватель</th>
		<th></th>
	</thead>
	<tbody>
		@foreach($dis as $key => $d)
		<tr>
			<td>{{ $d->group->codes[$d->kurs] }}</td>
			<td>{{ $d->subject->name }}</td>
			<td class="text-center">{{ $d->year.'-'.($d->year + 1) }}</td>
			<td class="text-center">{{ $d->semestr }}</td>
			<td>{{ $d->teacher->shortName }}</td>
			<td class="text-right">
				<a href="/results/{{$d->id}}/edit" class="btn btn-sm btn-outline-info">
				Перейти
				</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
{{ $dis->appends(Request::except('page'))->links() }}
@endif
@endsection