@extends('layouts.app')
@section('title', 'Календарно-тематические планы')
@section('content')
<h3>Календарно-тематические планы</h3>
<hr>
<form>
	<div class="row">
		<div class="form-group col-sm-3">
			<label>Группа</label>
			<select name="group" class="form-control form-control-sm">
				<option value="">Группа</option>
				@foreach($groups as $g)
				<option value="{{ $g->id }}" {{ $g->id == @$_GET['group'] ? 'selected' : '' }}>{{ $g->name }}</option>
				@endforeach
			</select>
		</div>		
		<div class="form-group col-sm-3">
			<label>Курс</label>
			<select name="kurs" class="form-control form-control-sm">
				<option value="">Курс</option>
				@for($k = 1; $k <= 4; $k++)
				<option value="{{ $k }}" {{ $k == @$_GET['kurs'] ? 'selected' : '' }}>{{ $k }}</option>
				@endfor
			</select>
		</div>		
		<div class="form-group col-sm-4">
			<label>Дисциплина</label>
			<select name="subject" class="form-control form-control-sm">
				<option value="">Дисциплина</option>
				@foreach($subjects as $s)
				<option value="{{ $s->id }}" {{ $s->id == @$_GET['subject'] ? 'selected' : '' }}>{{ $s->name }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-sm-2">
			<label>&nbsp;</label><input type="submit" class="btn btn-sm btn-info d-block" value="Показать">
		</div>		
	</div>
</form>
@if($programs)
<hr>
{{ $programs->appends(Request::except('page'))->links() }}
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Группа</th>
			<th>Предмет</th>
			<th>Учебный год</th>
			<th>Преподаватель</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($programs as $p)
			<tr>
				<td>{{ @$p->group->codes[$p->kurs] }}</td>
				<td>{{ $p->subject->name }}</td>
				<td>{{ $p->year.'-'.($p->year + 1) }}</td>
				<td>{{ $p->teacher->shortName }}</td>
				<td class="text-right">
					<a href="/ktp/{{$p->group_id}}/{{$p->subject_id}}/{{$p->kurs}}?subgroup={{$p->subgroup}}&cikl={{$p->cikl_id}}&teacher={{$p->teacher_id}}" 
						class="btn btn-sm btn-outline-info">
						Перейти
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
{{ $programs->appends(Request::except('page'))->links() }}
@endif
@endsection