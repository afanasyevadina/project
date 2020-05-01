@extends('layouts.app')
@section('title', 'КТП | '.$subject->name)
@section('content')
<?php
$num = $theory = $practice = 0;
?>
<div class="d-flex justify-content-between">
	<h3>Календарно-тематический план</h3>
	<a href="/ktp/{{ $group->id }}/{{ $subject->id }}/{{$kurs}}/export?teacher={{$teacher->id}}" class="btn btn-outline-primary">Экспорт в Word</a>
</div>
<hr>
<p>Преподаватель: {{ $teacher->fullName }}</p>
<p>Учебный год: {{ ($group->year_create + $kurs - 1).'-'.($group->year_create + $kurs) }}</p>
<p>Для специальности {{ $group->specialization->code }} «{{ $group->specialization->name }}»</p>
<p>{{ $kurs }} курс, группа {{ $group->codes[$kurs] }}</p>
<br>
<table class="table table-borderless">
	<tbody>
		<tr>
			<td>Общее количество часов на предмет</td>
			<td>{{ @$plans[1]->totalMain ?? @$plans[2]->totalMain }}
			</td>
			<td>в т.ч.теор.</td>
			<td>{{ @$plans[1]->theoryMain ?? @$plans[2]->theoryMain }}</td>
			<td>лаб.прак.</td>
			<td>{{ @$plans[1]->practiceMain ?? @$plans[2]->practiceMain }}</td>
		</tr>
		<tr>
			<td>Планируется на текущий учебный год</td>
			<td>{{ @$plans[1]->total + @$plans[2]->total }}</td>
			<td>в т.ч.теор.</td>
			<td>{{ @$plans[1]->theory + @$plans[2]->theory }}</td>
			<td>лаб.прак.</td>
			<td>{{ @$plans[1]->lab + @$plans[2]->lab + @$plans[1]->practice + @$plans[2]->practice }}</td>
		</tr>
		<tr>
			<td>Планируется на 1 семестр</td>
			<td>{{ @$plans[1]->total }}</td>
			<td>в т.ч.теор.</td>
			<td>{{ @$plans[1]->theory }}</td>
			<td>лаб.прак.</td>
			<td>{{ @$plans[1]->lab + @$plans[1]->practice }}</td>
		</tr>
		<tr>
			<td>Планируется на 2 семестр</td>
			<td>{{ @$plans[2]->total }}</td>
			<td>в т.ч.теор.</td>
			<td>{{ @$plans[2]->theory }}</td>
			<td>лаб.прак.</td>
			<td>{{ @$plans[2]->lab + @$plans[2]->practice }}</td>
		</tr>
		<tr>
			<td>На конец 1 семестра</td>
			<td colspan="5">
				{{ @$plans[1]->is_exam ? 'экзамен' : ''}}
				{{ @$plans[1]->is_zachet ? 'зачёт' : ''}}
			</td>
		</tr>
		<tr>
			<td>На конец 2 семестра</td>
			<td colspan="5">
				{{ @$plans[2]->is_exam ? 'экзамен' : ''}}
				{{ @$plans[2]->is_zachet ? 'зачёт' : ''}}
			</td>
		</tr>
	</tbody>
</table>
<br>
<table class="table table-sm table-bordered">
	<thead>
		<tr>
			<th class="text-center" rowspan="2">№</th>
			<th class="text-center" rowspan="2">Наименование разделов и тем</th>
			<th class="text-center" colspan="2">Кол-во часов</th>
			<th class="text-center" rowspan="2">Календарные сроки</th>
			<th class="text-center" rowspan="2">Тип и вид занятия</th>
		</tr>
		<tr>
			<th class="text-center">Теория</th>
			<th class="text-center">Практика</th>
		</tr>
	</thead>
	<tbody>
		@foreach($parts as $part)
		<tr class="font-weight-bold">
			<td></td>
			<td colspan="5">{{ $part['part']->name }}</td>
		</tr>
		@foreach($part['lessons'] as $l)
		<?php $theory += $l->total - $l->practice; $practice += $l->practice; ?>
		<tr>
			<td class="text-center">{{ ++$num }}</td>
			<td>{{ $l->topic }}</td>
			<td class="text-center">{{ $l->total - $l->practice ? $l->total - $l->practice : '' }}</td>
			<td class="text-center">{{ $l->practice }}</td>
			<td class="text-center">{{ $l->date ? date('d.m.Y', strtotime($l->date)) : '' }}</td>
			<td>{{ $l->practice ? 'Лабораторно-практическое занятие' : 'Изучение нового материала' }}</td>
		</tr>
		@endforeach
		@endforeach
		<tr>
			<td></td>
			<td>Итого:</td>
			<td class="text-center">{{ $theory }}</td>
			<td class="text-center">{{ $practice }}</td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>
<br>
@endsection