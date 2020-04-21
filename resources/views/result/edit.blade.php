@extends('layouts.app')
@section('title', 'Аттестация | '.$plan->subject->name)
@section('content')
<div class="alert alert-success col-sm-6 fixed-alert" id="saved" hidden>
	Сохранено
</div>
<h3>{{ $plan->subject->name }}</h3>
<hr>
<form action="/results" method="post" class="self-reload" data-alert="#saved">@csrf
	<div class="d-flex justify-content-between">
		<div>
			<p>Преподаватель: {{ $plan->teacher->fullName }}</p>
			<p>Учебный год: {{ ($plan->year).'-'.($plan->year + 1) }}</p>
			<p>Семестр: {{ $plan->semestr % 2 ? 1 : 2 }}</p>
			<p>{{ $plan->kurs }} курс, группа {{ $plan->group->codes[$plan->kurs] }}</p>
		</div>
		<div>
			<input type="submit" class="btn btn-sm btn-outline-primary" value="Сохранить">
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-bordered table-sm" style="width: auto;">
			<thead>
				<tr>
					<th>№</th>
					<th>ФИО студента</th>
					<th class="text-center">Текущий балл</th>
					<th class="text-center" style="width: 150px">Промежуточная аттестация</th>
					@if($plan->is_zachet)
					<th style="width: 150px">Зачёт</th>
					@endif
					@if($plan->is_project)
					<th class="text-center" style="width: 150px">Курсовой проект</th>
					@endif
					@if($plan->is_exam)
					<th class="text-center" style="width: 150px">Экзамен</th>
					@endif
					<th class="text-center" style="width: 150px">Итоговая</th>
				</tr>
			</thead>
			<tbody>
				@foreach($results as $key => $r)
				<tr>
					<td>{{ $key + 1 }}</td>
					<td>{{ $r->student->fullName }}</td>
					<td class="text-center">{{ $r->student->avgRating($plan->subject_id, $plan->semestr) }}</td>
					<td>
						<input type="number" name="results[{{$r->id}}][att]" class="form-control" min="0" max="5" value="{{$r->att}}">
					</td>
					@if($plan->is_zachet)
					<td>
						<input type="number" name="results[{{$r->id}}][zachet]" class="form-control" min="0" max="5" value="{{$r->zachet}}">
					</td>
					@endif
					@if($plan->is_project)
					<td>
						<input type="number" name="results[{{$r->id}}][project]" class="form-control" min="0" max="5" value="{{$r->project}}">
					</td>
					@endif
					@if($plan->is_exam)
					<td>
						<input type="number" name="results[{{$r->id}}][exam]" class="form-control" min="0" max="5" value="{{$r->exam}}">
					</td>
					@endif
					<td>
						<input type="number" name="results[{{$r->id}}][itog]" class="form-control" min="0" max="5" value="{{$r->itog}}">
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</form>
@endsection