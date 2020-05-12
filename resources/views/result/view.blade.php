@extends('layouts.app')
@section('title', 'Зачетная книжка | '.$student->fullName)
@section('content')
<h3>{{ $student->fullName }}</h3>
<hr>
<ul class="nav nav-tabs mb-2">
	@foreach($zachetka as $sem => $page)
	<li>
		<a data-toggle="tab" href="#sem{{$sem}}" 
		class="{{$sem == @array_keys($zachetka)[0] ? 'active' : ''}}">{{$sem}} семестр</a>
	</li>
	@endforeach
</ul>

<div class="tab-content">
	@foreach($zachetka as $sem => $page)
	<?php 
	$avgResult = round(collect($page)->avg('itog'), 2);
	$minResult = collect($page)->min('itog');
	?>
	<div id="sem{{$sem}}" class="tab-pane fade {{$sem == @array_keys($zachetka)[0] ? 'in active show' : ''}}">
		<div class="alert alert-{{$minResult == 5 ? 'success' : ($minResult == 4 ? 'info' : 'warning')}}">
			Средний балл: 
			{{$avgResult}}
		</div>
		<table class="table table-bordered table-sm">
			<thead>
				<tr>
					<th>№</th>
					<th>Дисциплина</th>
					<th class="text-center">Текущая</th>
					<th class="text-center">ПА</th>
					<th class="text-center">Зачёт</th>
					<th class="text-center">КР</th>
					<th class="text-center">Экзамен</th>
					<th class="text-center">Итоговая</th>
					<th>ФИО преподавателя</th>
				</tr>
			</thead>
			<tbody>
				@foreach($page as $key => $r)
				<tr>
					<td>{{ $key + 1 }}</td>
					<td>{{ $r->plan->subject->name }}</td>
					<td class="text-center">{{ $student->avgRating($r->plan->subject_id, $sem) }}</td>
					<td class="text-center">{{ $r->plan->cikl_id == 6 ? '' : $r->att }}</td>
					<td class="text-center">{{ $r->zachet }}</td>
					<td class="text-center">{{ $r->project }}</td>
					<td class="text-center">{{ $r->exam }}</td>
					<td class="text-center">{{ $r->itog }}</td>
					<td>{{ $r->plan->teacher->fullName }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	@endforeach
</div>
@endsection