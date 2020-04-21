@extends('layouts.app')
@section('title', 'РП | '.$subject->name)
@section('content')
<?php
$num = 0;
?>
<div class="alert alert-success col-sm-6" id="saved" hidden style="position: fixed;z-index: 999;top: 60px;right: 15px;">
	Сохранено
</div>
<div class="d-flex justify-content-between">
	<h3>Рабочая учебная программа</h3>
	<a href="/rp/{{ $group->id }}/{{ $subject->id }}/export" class="btn btn-outline-primary">Экспорт в Word</a>
</div>
<hr>
<p>Преподаватель: {{ $teacher }}</p>
@verbatim
<div id="app">
	<p>Для специальности {{ group.specialization.code }} «{{ group.specialization.name }}»</p>
	<h6 class="text-center">Распределение учебного времени</h6>
	<table class="table table-bordered table-sm">
		<thead>
			<tr>
				<th class="text-center font-weight-normal" rowspan="3">курс</th>
				<th class="text-center font-weight-normal" rowspan="3">всего часов</th>
				<th class="text-center font-weight-normal" colspan="8">из них</th>
			</tr>
			<tr>
				<th class="text-center font-weight-normal" colspan="2">теоретических занятий</th>
				<th class="text-center font-weight-normal" colspan="2">лабораторные работы</th>
				<th class="text-center font-weight-normal" colspan="2">практические занятия</th>
				<th class="text-center font-weight-normal" colspan="2">курсовых работ</th>
			</tr>
			<tr>
				<th class="text-center font-weight-normal">Сем.№ 1</th>
				<th class="text-center font-weight-normal">Сем.№ 2</th>
				<th class="text-center font-weight-normal">Сем.№ 1</th>
				<th class="text-center font-weight-normal">Сем.№ 2</th>
				<th class="text-center font-weight-normal">Сем.№ 1</th>
				<th class="text-center font-weight-normal">Сем.№ 2</th>
				<th class="text-center font-weight-normal">Сем.№ 1</th>
				<th class="text-center font-weight-normal">Сем.№ 2</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="plan in yearPlans" :key="yearPlans.kurs">
				<td class="text-center">{{ roman[plan.kurs] }}</td>
				<td class="text-center">{{ plan.total }}</td>
				<td class="text-center">{{ !!plan[1] ? plan[1].theory : '' }}</td>
				<td class="text-center">{{ !!plan[2] ? plan[2].theory : '' }}</td>
				<td class="text-center">{{ !!plan[1] ? plan[1].lab : '' }}</td>
				<td class="text-center">{{ !!plan[2] ? plan[2].lab : '' }}</td>
				<td class="text-center">{{ !!plan[1] ? plan[1].practice : '' }}</td>
				<td class="text-center">{{ !!plan[2] ? plan[2].practice : '' }}</td>
				<td class="text-center">{{ !!plan[1] ? plan[1].project : '' }}</td>
				<td class="text-center">{{ !!plan[2] ? plan[2].project : '' }}</td>
			</tr>
		</tbody>
	</table>
	<br>
	<h6 class="text-center">Предмет изучается в группах</h6>
	<table class="table table-bordered table-sm">
		<thead>
			<tr>
				<th class="text-center font-weight-normal">учебный год</th>
				<th class="text-center font-weight-normal">номер курса</th>
				<th class="text-center font-weight-normal">шифр группы</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="plan in yearPlans" :key="yearPlans.kurs">
				<td class="text-center">{{ plan.year }}-{{ plan.year + 1 }}</td>
				<td class="text-center">{{ roman[plan.kurs] }}</td>
				<td class="text-center">{{ group.codes[plan.kurs] }}</td>
			</tr>
		</tbody>
	</table>
	<br>
	<h6 class="text-center">ТЕМАТИЧЕСКИЙ ПЛАН</h6>
	<button class="btn btn-success" style="position: fixed;bottom: 10px;right: 20px" @click="save">Сохранить</button>
	<table class="table table-bordered table-sm">
		<thead>
			<tr>
				<th rowspan="2" class="text-center">№</th>
				<th rowspan="2" class="text-center">Наименование разделов и тем</th>
				<th colspan="2" class="text-center">Количество часов</th>
				<th rowspan="2" class="text-center th-num">
					<button :disabled="!unplaced.length" class="btn btn-sm btn-light" @click="addPart">New part</button>
				</th>
			</tr>
			<tr>
				<th class="text-center th-num">Всего</th>
				<th class="text-center th-num">лпз</th>
			</tr>
		</thead>
		<tbody>
			<template v-for="(part, pK) in parts">
				<tr class="table-active">
					<td></td>
					<td class="td-input"><textarea v-model="part.name" autocomplete="off"></textarea></td>
					<td colspan="2" class="text-center">
						<button :disabled="!unplaced.length" class="btn btn-sm btn-light" @click="addLesson(pK)">Add lesson</button>
					</td>
					<td class="text-center">						
						<button class="btn btn-sm btn-light" @click="deletePart(pK)">Delete</button>
					</td>
				</tr>
				<tr v-for="(lesson, lK) in part.lessons" :key="lesson.id">
					<td>{{ lesson.order }}</td>
					<td class="td-input"><textarea v-model="lesson.topic" autocomplete="off"></textarea></td>
					<td class="td-input">
						<input type="number" v-model="lesson.total" :max="total - givenTotal + lesson.total">
					</td>
					<td class="td-input">
						<input type="number" v-model="lesson.practice">
					</td>
					<td class="text-center">
						<button class="btn btn-sm btn-light" @click="deleteLesson(pK, lK)">Delete</button>
					</td>
				</tr>
			</template>
			<tr>
				<td></td>
				<td>Итого</td>
				<td>{{ givenTotal }}</td>
				<td>{{ givenLabPrac }}</td>
			</tr>
		</tbody>
	</table>
</div>
@endverbatim
<script type="text/javascript" src="/public/js/app.js"></script>
<script type="text/javascript">
	var app = new Vue({
		el: '#app',
		data: {
			parts: [],
			deleted: [],
			unplaced: [],
			total: 0,
			labPrac: 0,
			yearPlans: [],
			group: {},
			subject: {},
			roman: {1: 'I', 2: 'II', 3: 'III', 4: 'IV'}
		},
		computed: {
			givenTotal: function() {
				return this.parts.reduce(function(t, part) {
					return part.lessons.reduce(function(v, l) { 
						return l.total ? v + parseInt(l.total, 10)  : v
					}, t)
				}, 0)
			},
			givenLabPrac: function() {
				return this.parts.reduce(function(t, part) {
					return part.lessons.reduce(function(v, l) { 
						return l.practice ? v + parseInt(l.practice, 10)  : v
					}, t)
				}, 0)
			}
		},
		created() {
			var plans = <?=json_encode($plans)?>;
			this.group = <?=json_encode($group)?>;
			this.subject = <?=json_encode($subject)?>;
			var years = []
			var tempParts = []
			plans.forEach(plan => {
				this.total += plan.total
				this.labPrac += plan.lab
				this.labPrac += plan.practice
				this.labPrac += plan.project
				var kurs = Math.ceil(plan.semestr / 2)
				if(!(!!years[kurs])) {
					years[kurs] = {
						year: plan.year,
						kurs: kurs,
						total: 0
					}
				}
				years[kurs][plan.semestr % 2 ? 1 : 2] = {
					theory: plan.theory,
					lab: plan.lab,
					practice: plan.practice,
					project: plan.project
				}
				years[kurs].total += plan.total
				this.yearPlans = years.filter(year => !!year.year)
				plan.lessons.forEach(lesson => {
					if(lesson.part_id) {
						if(!(!!tempParts[lesson.part_id])) {
							tempParts[lesson.part_id] = {
								name: lesson.part.name,
								id: lesson.part_id,
								lessons: []
							}
						}
						tempParts[lesson.part_id].lessons.push(lesson)
					}
					else {
						lesson.topic = null
						lesson.practice = null
						this.unplaced.push(lesson)
					}
				})					
			})
			this.parts = tempParts.filter(part => !!part.id)
		},
		methods: {
			addPart: function() {
				this.parts.push({
					name: '',
					lessons: []
				})
			},
			addLesson: function(key) {
				this.parts[key].lessons.push(this.unplaced.shift())
				this.order()
			},
			deletePart: function(key) {
				if(!!this.parts[key].id) this.deleted.push(this.parts[key].id)
				this.parts.splice(key, 1)
			},
			deleteLesson: function(part, key) {
				this.parts[part].lessons[key].topic = null
				this.parts[part].lessons[key].practice = null
				this.unplaced.unshift(this.parts[part].lessons[key])
				this.parts[part].lessons.splice(key, 1)
				this.order()
			},
			save: function() {
				axios.post('/rp/' + this.group.id + '/' + this.subject.id, {
					parts: this.parts,
					deleted: this.deleted
				})
				.then(response => {
					document.getElementById('saved').hidden = false
					setTimeout(() => document.getElementById('saved').hidden = true, 3000)
				})
			},
			order: function() {
				var order = 0
				this.parts.forEach(part => part.lessons.forEach(l => {l.order = ++order}))
			}
		},
		watch: {
			givenLabPrac: function() {
				var hours = []
				this.yearPlans.forEach(year => {
					if(!!year[1]) hours.push({
						t: year[1].theory + year[1].practice + year[1].lab + year[1].project, 
						p: year[1].practice + year[1].lab + year[1].project
					})
					if(!!year[2]) hours.push({
						t: year[2].theory + year[2].practice + year[2].lab + year[2].project, 
						p: year[2].practice + year[2].lab + year[2].project
					})
				})
				var index = 0
				this.parts.forEach(part => part.lessons.forEach(lesson => {
					if(!hours[index].t) {
						index++
					}
					hours[index].t -= lesson.total
					hours[index].p -= lesson.practice					
					if(hours[index].p < 0) lesson.practice = null
				}))
			}
		}
	})
</script>
@endsection