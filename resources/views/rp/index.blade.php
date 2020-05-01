@extends('layouts.app')
@section('title', 'Рабочие учебные программы')
@section('content')
<h3>Рабочие учебные программы</h3>
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
		<div class="form-group col-sm-6">
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
<table class="table table-hover">
	<thead>
		<th>Группа</th>
		<th>Предмет</th>
		<th></th>
	</thead>
	<tbody>
		@foreach($programs as $p)
		<tr>
			<td>{{$p->group->name}}</td>
			<td>{{$p->subject->name}}</td>
			<td class="text-right">
				<a href="/rp/{{$p->group_id}}/{{$p->subject_id}}?cikl={{$p->cikl_id}}" class="btn btn-sm btn-outline-info">
				Перейти
				</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
{{ $programs->appends(Request::except('page'))->links() }}
@endif
@endsection