@extends('layouts.app')
@section('title', 'Редактор расписания')
@section('content')
<?php
$year = @$_GET['year'] ? $_GET['year'] : date('Y');
?>
<h3>Редактор расписания</h3>
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
            <label>Учебный год</label>
            <select name="year" class="form-control form-control-sm" required>
                @for($i = date('Y') - 4; $i <= date('Y'); $i ++)
                <option value="{{ $i }}" {{ $i == $year ? 'selected' : ''}}>{{ $i }}-{{ $i + 1 }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group col-sm-3">
            <label>Семестр</label>
            <select name="semestr" class="form-control form-control-sm" required>
                <option {{ 1 == @$_GET['semestr'] ? 'selected' : ''}}>1</option>
                <option {{ 2 == @$_GET['semestr'] ? 'selected' : ''}}>2</option>
            </select>
        </div>
        <div class="col-sm-2 form-group">
            <label>&nbsp;</label><input type="submit" value="Показать" class="btn btn-sm btn-info d-block">
        </div>
    </div>
</form>
@if(!empty($_GET))
@verbatim
<div id="app">
    <div class="text-right mb-1">
        <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#reset">
        Сброс</button>
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
                <li :class="{'text-muted': dis.denied, 'bg-light': active.id == dis.id}" class="list-group-item drag" v-for="dis in filteredList" :key="dis.id" @mousedown="dragstart(dis)">
                    {{ dis.subject.name }} {{dis.subgroup ? dis.subgroup + ' подгруппа' : ''}}
                    <br><i>{{ dis.teacher.shortName }}</i>
                    <span class="span-badge text-muted">{{ dis.given }} / {{ dis.hours }}</span>
                </li>
            </ul>
        </div>
        <div class="col-sm-6 overflow-auto">
            <table class="table table-bordered table-sm drag">
                <template v-for="(day, d) in schedule">
                    <tr class="table-active">
                        <td></td>
                        <td class="th-num text-center">№</td>
                        <td class="text-center">{{ days[d] }}</td>
                        <td class="th-num text-center">Каб.</td>
                    </tr>
                    <template v-for="(num, n) in day">
                        <template v-if="num.divide">
                            <tr>
                                <td class="text-muted text-center" rowspan="2" @click="divide(d, n)">/</td>
                                <td class="text-center" rowspan="2">{{ n + 1 }}</td>
                                <td :class="{accept: checkAccept(d,n,1)}" @mouseup="receive(d, n, 1)">
                                    <span v-for="(dis, i) in num[1]" @mousedown="dragtable(i, d, n, 1)">
                                        {{dis.subject.name}} {{dis.subgroup ? dis.subgroup + ' подгруппа' : ''}}
                                        <br><i>{{dis.teacher.shortName}}</i>
                                    </span>
                                </td>
                                <td class="cab-td text-center"><div>
                                    <span v-for="(dis, i) in num[1]" v-for="dis in num[1]" data-toggle="modal" data-target="#cab" @click="allowCab(d, n, 1, i)">
                                    {{ !!dis.cab ? dis.cab.num : '' }}</span>
                                </div></td>
                            </tr>
                            <tr>
                                <td :class="{accept: checkAccept(d,n,2)}" @mouseup="receive(d, n, 2)">
                                    <span v-for="(dis, i) in num[2]" @mousedown="dragtable(i, d, n, 2)">
                                        {{dis.subject.name}} {{dis.subgroup ? dis.subgroup + ' подгруппа' : ''}}
                                        <br><i>{{dis.teacher.shortName}}</i>
                                    </span>
                                </td>
                                <td class="cab-td text-center"><div>
                                    <span v-for="(dis, i) in num[2]" v-for="dis in num[2]" data-toggle="modal" data-target="#cab" @click="allowCab(d, n, 2, i)">
                                    {{ !!dis.cab ? dis.cab.num : '' }}</span>
                                </div></td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr>
                                <td class="text-muted text-center" @click="divide(d, n)">/</td>
                                <td class="text-center">{{ n + 1 }}</td>
                                <td :class="{accept: checkAccept(d,n,0)}" @mouseup="receive(d, n, 0)">
                                    <span v-for="(dis, i) in num[0]" @mousedown="dragtable(i, d, n, 0)">
                                        {{dis.subject.name}} {{dis.subgroup ? dis.subgroup + ' подгруппа' : ''}}
                                        <br><i>{{dis.teacher.shortName}}</i>
                                    </span>
                                </td>
                                <td class="cab-td text-center"><div>
                                    <span v-for="(dis, i) in num[0]" data-toggle="modal" data-target="#cab" @click="allowCab(d, n, 0, i)">
                                    {{ !!dis.cab ? dis.cab.num : '' }}</span>
                                </div></td>
                            </tr>
                        </template>
                    </template>
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
                    <ul class="list-group cabs" data-dismiss="modal">
                        <li class="list-group-item text-muted p-2" @click="setCab({})">*не выбрано*</li>
                        <li v-for="cab in allowCabs" class="list-group-item p-2" @click="setCab(cab)">
                            {{cab.num}} <small> ({{cab.name}}, {{cab.corpus.name}})</small>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>
@endverbatim
@endif
<div class="modal fade" id="reset">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Подтверждение</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">Вы реально собираетесь снести расписание?
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" href="/schedule/reset?<?=$_SERVER['QUERY_STRING']?>">
                    Да</a>
                    <button class="btn btn-light" data-dismiss="modal">Нет</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
            waitCab: {},
            allowCabs: [],
            loading: false,
            warning: '',
            success: false,
        },
        computed: {
            filteredList: function() {
                return this.list.filter(val => val.hours > val.given)
            }
        },
        methods: {
            dragstart: function(dis) {
                this.active = JSON.parse(JSON.stringify(dis))
                this.active.cab = {}
                this.active.plan_id = dis.id
            },
            receive: function(day, num, week) {
                if(this.checkAccept(day, num, week)) {
                    var active = this.active
                    axios.post(
                        '/schedule/receive/' + (day + 1) + '/' + (num + 1) + '/' + week + location.search, 
                        this.active
                    )
                    .then(response => {
                        if(response.data) {
                            this.warning = response.data
                        } else {
                            this.schedule[day][num][week].push(active)
                            this.list.find(val => val.id == active.plan_id).given ++
                            this.$forceUpdate()
                            this.setGiven()
                        }
                    })                    
                }
            },
            dragtable: function(index, day, num, week) {
                this.active = this.schedule[day][num][week][index]
                this.schedule[day][num][week].splice(index, 1)
            },
            checkAccept: function(day, num, week) {
                if(!this.active.id || this.schedule[day][num][week].length > 1) return false 
                    else return (
                        !this.schedule[day][num][week].length ||(
                            this.schedule[day][num][week][0].subgroup && this.active.subgroup && 
                            this.active.subgroup != this.schedule[day][num][week][0].subgroup
                            )
                        )
                },
            divide: function(day, num) {
                this.schedule[day][num].divide = !this.schedule[day][num].divide
                this.$forceUpdate()
            },
            save: function() {
                var data = []
                this.schedule.forEach((day, d) => {
                    day.forEach((num, n) => {
                        if(num.divide) {
                            num[1].forEach(l => data.push({
                                plan_id: l.plan_id,
                                schedule_id: l.schedule_id,
                                subgroup: l.subgroup,
                                cab_id: !!l.cab.id ? l.cab.id : null,
                                day: d + 1,
                                num: n + 1,
                                week: 1,
                            }))
                            num[2].forEach(l => data.push({
                                plan_id: l.plan_id,
                                schedule_id: l.schedule_id,
                                subgroup: l.subgroup,
                                cab_id: !!l.cab.id ? l.cab.id : null,
                                day: d + 1,
                                num: n + 1,
                                week: 2,
                            }))
                        } else {
                            num[0].forEach(l => data.push({
                                plan_id: l.plan_id,
                                schedule_id: l.schedule_id,
                                subgroup: l.subgroup,
                                cab_id: !!l.cab.id ? l.cab.id : null,
                                day: d + 1,
                                num: n + 1,
                                week: 0,
                            }))
                        }
                    })
                })
                axios.post('/schedule'+location.search, {data: data})
                .then(response => {
                    this.success = true
                    setInterval(() => this.success = false, 2000)
                })
                .catch(error => console.log(error))
            },
            allowCab: function(day, num, week, i) {
                this.waitCab = {d: day, n: num, w: week, i: i}
                axios.get('/schedule/allowcab/' + (day + 1) + '/' + (num + 1) + '/' + week + location.search)
                .then(response => this.allowCabs = response.data)
            },
            setCab: function(cab) {
                this.schedule[this.waitCab.d][this.waitCab.n][this.waitCab.w][this.waitCab.i].cab = cab
                this.waitCab = {}
                this.$forceUpdate()
            },
            setGiven: function() {
                this.list.forEach(dis => dis.given = 0)
                this.schedule.forEach((day, d) => {
                    day.forEach((num, n) => {
                        if(num.divide) {
                            num[1].forEach(l => this.list.find(val => val.id == l.plan_id).given += 0.5)
                            num[2].forEach(l => this.list.find(val => val.id == l.plan_id).given += 0.5)
                        } else {
                            num[0].forEach(l => this.list.find(val => val.id == l.plan_id).given ++)
                        }
                    })
                })
            }
        },
        created() {
            for(d = 0; d < 5; d++) {
                this.schedule[d] = [];
                for(n = 0; n < 7; n++) {
                    this.schedule[d][n] = {divide: false, 0: [], 1: [], 2: []}
                }
            }
            this.list = <?=json_encode($list)?>;
            var schedule = <?=json_encode($schedule)?>; 
            schedule.forEach(s => {
                if(s.week) this.schedule[s.day-1][s.num-1].divide = true
                    s.schedule_id = s.id
                this.schedule[s.day-1][s.num-1][s.week].push(s)
            }) 
            this.setGiven()
            document.addEventListener('mouseup', () => {
                this.active = {}
                this.setGiven()
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
@endsection