@extends('layouts.app')
@section('title', 'Редактор изменений')
@section('content')
<?php
$year = @$_GET['year'] ? $_GET['year'] : date('Y');
?>
<h3>Редактор изменений</h3>
<hr>
<form>
    <div class="row">
        <div class="form-group col-sm-3">
            <label>Группа</label>
            <select name="group" class="form-control form-control-sm" required>
                <option value="">Группа</option>
                @foreach($groups as $g)
                <option value="{{ $g->id }}" {{ $g->id == @$_GET['group'] ? 'selected' : '' }}>{{ $g->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-3">
            <label>Дата</label>
            <input type="date" name="date" value="{{ @$_GET['date'] }}" class="form-control form-control-sm" required>
        </div>
        <div class="form-group col-sm-3">
            <label>&nbsp;</label>
            <input type="submit" value="Показать" class="btn btn-sm btn-info d-block">
        </div>
    </div>
</form>
@if(!empty($_GET))
@verbatim
<div id="app">
    <div class="text-right mb-1">
        <button class="btn btn-sm btn-outline-primary" @click="save">Сохранить</button>
    </div>
    <div class="alert alert-warning" v-if="warning" @click="warning=''">
        <div v-html="warning"></div>
    </div>
    <div class="alert alert-success" v-if="success" @click="success=false">
        <div>Сохранено</div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-6 overflow-auto">
            <ul class="list-group">
                <li :class="{'text-muted': dis.denied, 'bg-light': active.id == dis.id}" class="list-group-item drag" v-for="dis in list" :key="dis.id" @mousedown="dragstart(dis)">
                    {{ dis.subject.name }} {{dis.subgroup ? dis.subgroup + ' подгруппа' : ''}}
                    <br><i>{{ dis.teacher.shortName }}</i>
                    <span class="span-badge text-muted">{{ dis.given }} / {{ dis.hours }}</span>
                </li>
            </ul>
        </div>
        <div class="col-sm-6">
            <table class="table table-bordered table-sm drag">
                <tr class="table-active">
                    <td class="th-num text-center">№</td>
                    <td class="text-center">{{ days[day.day -1 ] }}</td>
                    <td class="th-num text-center">Каб.</td>
                </tr>
                <template v-for="(num, n) in schedule">
                    <tr>
                        <td class="text-center">{{ n + 1 }}</td>
                        <td :class="{accept: checkAccept(n)}" @mouseup="receive(n)">
                            <template v-for="(dis, i) in num">
                                <span @mousedown="dragtable(i, n)">
                                {{dis.subject.name}} {{dis.subgroup ? dis.subgroup + ' подгруппа' : ''}}</span>
                                <i data-toggle="modal" data-target="#teachers" @click="allowTeacher(n, i)">
                                {{dis.teacher.shortName}}</i>
                            </template>
                        </td>
                        <td class="cab-td text-center"><div>
                            <span v-for="(dis, i) in num" data-toggle="modal" data-target="#cab" @click="allowCab(n, i)">
                            {{ !!dis.cab ? dis.cab.num : '' }}</span>
                        </div></td>
                    </tr>
                </template>
            </table>
        </div>
    </div>    
    <div class="card p-1 helper" v-if="active.id" ref="helper">
        {{ active.subject.name }} 
        {{active.subgroup ? active.subgroup + ' подгруппа' : ''}}
        <i>{{ active.teacher.shortName }}</i>
    </div>
    <div class="modal fade" id="cab" ref="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Выбор кабинета</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" data-dismiss="modal">
                        <li class="list-group-item text-muted" @click="setCab({})">*не выбрано*</li>
                        <li v-for="cab in allowCabs" class="list-group-item" @click="setCab(cab)">{{cab.num}} ({{cab.name}})</li>
                    </ul>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="teachers">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Выбор преподавателя</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" data-dismiss="modal">
                        <li class="list-group-item text-muted" @click="setTeacher({})">*не выбрано*</li>
                        <li v-for="teacher in allowTeachers" class="list-group-item" @click="setTeacher(teacher)">
                        {{teacher.fullName}}</li>
                    </ul>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>
@endverbatim
@endsection
@section('scripts')
<script>
    const app = new Vue({
        el: '#app',
        data: {
            days: ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница'],
            schedule: [],
            list: [],
            active: {},
            day: {},
            waitCab: {},
            waitTeacher: {},
            allowCabs: [],
            allowTeachers: [],
            loading: false,
            warning: '',
            success: false
        },
        methods: {
            dragstart: function(dis) {
                this.active = dis
                this.active.cab = {}
                this.active.lesson_id = dis.id
            },
            receive: function(num) {
                if(this.checkAccept(num)) {
                    var active = this.active
                    axios.post('/changes/receive/' + (num + 1) + location.search, this.active)
                    .then(response => {
                        if(response.data) {
                            this.warning = response.data
                        } else {
                            this.schedule[num].push(active)
                            this.$forceUpdate()                            
                        }
                    })                    
                }
            },
            dragtable: function(index, num) {
                this.active = this.schedule[num][index]
                this.schedule[num].splice(index, 1)
            },
            checkAccept: function(num) {
                if(!this.active.id || this.schedule[num].length > 1) {
                    return false 
                }
                else {
                    return (
                        !this.schedule[num].length ||(
                            this.schedule[num][0].subgroup && this.active.subgroup && 
                            this.active.subgroup != this.schedule[num][0].subgroup
                            )
                        )
                }
            },
            save: function() {
                var data = []
                this.schedule.forEach((num, n) => {
                    num.forEach(item => {
                        data.push({
                            num: n + 1,
                            cab_id: !!item.cab.id ? item.cab.id : null,
                            teacher_id: !!item.teacher.id ? item.teacher.id : null,
                            id: item.lesson_id
                        })
                    })
                })
                axios.post('/changes'+location.search, {data: data})
                .then(response => {
                    this.success = true
                    setInterval(() => this.success = false, 2000)
                })
                .catch(error => console.log(error))
            },
            allowCab: function(num, i) {
                this.waitCab = {n: num, i: i}
                axios.get('/changes/allowcab/' + (num + 1) + location.search)
                .then(response => this.allowCabs = response.data)
            },
            allowTeacher: function(num, i) {
                this.waitTeacher = {n: num, i: i}
                axios.get('/changes/allowteacher/' + (num + 1) + location.search)
                .then(response => this.allowTeachers = response.data)
            },
            setCab: function(cab) {
                this.schedule[this.waitCab.n][this.waitCab.i].cab = cab
                this.waitCab = {}
                this.$forceUpdate()
            },
            setTeacher: function(teacher) {
                this.schedule[this.waitTeacher.n][this.waitTeacher.i].teacher = teacher
                this.waitTeacher = {}
                this.$forceUpdate()
            }
        },
        created() {
            for(n = 0; n < 7; n++) {
                this.schedule[n] = []
            }
            this.list = <?=json_encode($list)?>;
            this.day = <?=json_encode($day)?>;
            var schedule = <?=json_encode($schedule)?>; 
            schedule.forEach(s => {
                if(s) this.schedule[s.num-1].push(s)
            }) 
            document.addEventListener('mouseup', () => {
                this.active = {}
            })
            document.addEventListener('mousemove', (e) => {
                if(this.active.id) {
                    this.$refs.helper.style.top = e.clientY - 5 + 'px'
                    this.$refs.helper.style.left = e.clientX + 5 + 'px'
                }
            })
        }
    })
</script>
@endif
@endsection