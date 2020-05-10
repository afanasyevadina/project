@extends('layouts.app')
@section('titel', 'Текущие оценки')
@section('content')
<h3>Текущие оценки</h3>
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
		<div class="col-sm-12"><input type="submit" class="btn btn-sm btn-outline-primary" value="Показать"></div>		
	</div>
</form>
@if($group)
<hr>
<table class="table table-sm table-bordered">
	<thead>
		<th>№</th>
		<th>ФИО</th>
		@foreach($subjects as $subject)
		<th><small>{{ $subject->subject->name }}</small></th>
		@endforeach
	</thead>
	<tbody>
		@foreach($group->students as $key => $student)
		<tr>
			<td>{{ $key + 1 }}</td>
			<td>{{ $student->shortName }}</td>
			@foreach($subjects as $subject)
			<td class="text-center">{{ $student->avgRating($subject->subject_id, $_GET['semestr']) }}</td>
			@endforeach
		</tr>
		@endforeach
	</tbody>
</table>
@endif
@endsection