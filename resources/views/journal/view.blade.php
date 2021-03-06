@extends('layouts.app')
@section('title', 'Журнал | '.$plan->subject->name)
@section('content')
<div class="alert alert-success col-sm-6" id="saved" hidden style="position: fixed;z-index: 999;top: 60px;right: 15px;">
	Сохранено
</div>
<h3>{{ $plan->subject->name }}</h3>
<hr>
<div class="d-flex justify-content-between">
	<div>
		<p>Преподаватель: {{ $plan->teacher->fullName }}</p>
		<p>Учебный год: {{ ($plan->year).'-'.($plan->year + 1) }}</p>
		<p>Семестр: {{ $plan->semestr % 2 ? 1 : 2 }}</p>
		<p>{{ $plan->kurs }} курс, группа {{ $plan->group->codes[$plan->kurs] }}</p>
	</div>
	<div>
		<a href="/journal/{{ $plan->id }}/refresh" class="btn btn-sm btn-outline-secondary self-reload">Обновить</a>
		<button id="save" class="btn btn-sm btn-outline-primary">Сохранить</button>
	</div>
</div>
<div class="table-responsive">
	<table class="table table-bordered table-sm">
		<thead>
			<tr>
				<th>№</th>
				<th>ФИО студента</th>
				@foreach($plan->lessons as $l)
				<th style="min-width: 32px"><small>{{ $l->date ? date('d.m', strtotime($l->date)) : '' }}</small></th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach($students as $key => $s)
			<tr>
				<td>{{ $key + 1 }}</td>
				<td class="text-nowrap">{{ $s->shortName }}</td>
				@foreach($plan->lessons as $l)
				<td {{ isset($l->list[$s->id]) ? 'data-id='.$l->list[$s->id]->id : '' }} 
					{{ isset($l->list[$s->id]) && $l->date ? 'contenteditable=true' : '' }}
					class="text-center {{ isset($l->list[$s->id]) ? '' : 'table-active' }}">
					{{ @$l->list[$s->id]->value }}{{ @$l->list[$s->id]->miss ? 'н' : '' }}
				</td>
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	document.querySelectorAll('[contenteditable]').forEach(el => el.onkeydown = function(event) {
		if([37,38,39,40].includes(event.keyCode)) {
			event.preventDefault()
			var tr, td
			switch(event.keyCode) {
				case 40:
				tr = event.path[1].nextElementSibling
				if(tr) {
					td = tr.cells[event.path[0].cellIndex]
					if(td) td.focus()
				}
				break;
				case 38:
				tr = event.path[1].previousElementSibling
				if(tr) {
					td = tr.cells[event.path[0].cellIndex]
					if(td) td.focus()
				}
				break;
				case 39:
				tr = event.path[1]
				if(tr) {
					td = tr.cells[event.path[0].cellIndex + 1]
					if(td) td.focus()
				}
				break;
				case 37:
				tr = event.path[1]
				if(tr) {
					td = tr.cells[event.path[0].cellIndex - 1]
					if(td) td.focus()
				}
				break;
			}
		}
	})
	document.getElementById('save').onclick = function() {
		var table = document.querySelectorAll('td[data-id]')
		var data = []
		for(var i = 0; i< table.length; i++) {
			data.push({
				id: table[i].dataset.id,
				value: table[i].innerHTML
			})
		}
		axios.post('/journal/<?=$plan->id?>', data)
		.then(response => {
			document.getElementById('saved').hidden = false
			setTimeout(() => document.getElementById('saved').hidden = true, 3000)
		})
	}
</script>
@endsection