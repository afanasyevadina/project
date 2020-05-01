@extends('layouts.app')
@section('title', 'Журналы')
@section('content')
<h3>Журналы</h3>
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
			<select name="sem" class="form-control form-control-sm">
				<option value="">Семестр</option>
				@for($k = 1; $k <= 8; $k++)
				<option value="{{ $k }}" {{ $k == @$_GET['sem'] ? 'selected' : '' }}>{{ $k }}</option>
				@endfor
			</select>
		</div>
		<div class="col-sm-2">
			<label>&nbsp;</label><input type="submit" class="btn btn-sm btn-info d-block" value="Показать">
		</div>		
	</div>
</form>
@if($journals)
<hr>
{{ $journals->appends(Request::except('page'))->links() }}
<table class="table table-hover">
	<thead>
		<tr>
			<th>Группа</th>
			<th>Предмет</th>
			<th class="text-center">Учебный год</th>
			<th class="text-center">Семестр</th>
			<th>Преподаватель</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($journals as $key => $j)
		<tr>
			<td>{{ $j->group->codes[$j->kurs] }}</td>
			<td>{{ $j->subject->name }}</td>
			<td class="text-center">{{ $j->year.'-'.($j->year + 1) }}</td>
			<td class="text-center">{{ $j->semestr }}</td>
			<td>{{ $j->teacher->shortName }}</td>
			<td class="text-right">
				<a href="/journal/{{$j->id}}" class="btn btn-sm btn-outline-info">
				Перейти
				</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
{{ $journals->appends(Request::except('page'))->links() }}
@endif
@endsection