@extends('layouts.app')
@section('title', 'Расписание группы')
@section('content')
<?php
$year = @$_GET['year'] ? $_GET['year'] : date('Y');
?>
<h3>Расписание группы</h3>
<hr>
<form>
    <div class="row">
        <div class="col-sm-3 form-group">
            <label>Учебный год</label>
            <select name="year" class="form-control form-control-sm">
                @for($i = date('Y') - 3; $i <= date('Y'); $i ++)
                <option value="{{ $i }}" {{ $i == $year ? 'selected' : ''}}>{{ $i }}-{{ $i + 1 }}</option>
                @endfor
            </select>
        </div>
        <div class="col-sm-3 form-group">
            <label>Семестр</label>
            <select name="semestr" class="form-control form-control-sm">
                <option {{ 1 == @$_GET['semestr'] ? 'selected' : ''}}>1</option>
                <option {{ 2 == @$_GET['semestr'] ? 'selected' : ''}}>2</option>
            </select>
        </div>
        <div class="col-sm-4 form-group">
            <label>Группа</label>
            <select name="group" class="form-control form-control-sm" required>
                <option value="">Группа</option>
                @foreach($groups as $group)
                <option value="{{ $group->id }}" {{ $group->id == @$_GET['group'] ? 'selected' : ''}}>{{ $group->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-2 form-group">
            <label>&nbsp;</label><input type="submit" value="Показать" class="btn btn-sm btn-info d-block">
        </div>
    </div>
</form>
<hr>
@verbatim
<div id="app">
    <div v-if="loading">
        <div class="loader"></div>
    </div>
    <table class="table table-bordered table-sm">
        <template v-for="(day, d) in schedule">
            <thead>
                <tr>
                    <th class="text-center th-num">№</th>
                    <th class="text-center th-name">{{ days[d] }}</th>
                    <th class="text-center th-cab">Каб.</th>
                </tr>
            </thead>
            <template v-for="(num, n) in day">
                <template v-if="!!num[1] || !!num[2]">
                    <tr>
                        <td rowspan="2">{{ n }}</td>
                        <td>
                            <template v-for="subject in unique(num[1], 'subject')">
                                <span class="d-block">{{ subject }}</span>
                            </template>
                            <i class="d-block text-right">{{unique(num[1], 'teacher').join(' / ') }}</i>
                        </td>
                        <td>
                            <template v-for="cab in unique(num[1], 'cab')">
                                <span class="d-block text-center">{{ cab }}</span>
                            </template>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <template v-for="subject in unique(num[2], 'subject')">
                                <span class="d-block">{{ subject }}</span>
                            </template>
                            <i class="d-block text-right">{{unique(num[2], 'teacher').join(' / ') }}</i>
                        </td>
                        <td>
                            <template v-for="cab in unique(num[2], 'cab')">
                                <span class="d-block text-center">{{ cab }}</span>
                            </template>
                        </td>
                    </tr>
                </template>
                <template v-else>
                    <tr>
                        <td>{{ n }}</td>
                        <td>
                            <template v-for="subject in unique(num[0], 'subject')">
                                <span class="d-block">{{ subject }}</span>
                            </template>
                            <i class="d-block text-right">{{unique(num[0], 'teacher').join(' / ') }}</i>
                        </td>
                        <td>
                            <template v-for="cab in unique(num[0], 'cab')">
                                <span class="d-block text-center">{{ cab }}</span>
                            </template>
                        </td>
                    </tr>
                </template>
            </template>
        </template>
    </table>
</div>
@endverbatim
@endsection
@section('scripts')
<script>
    const app = new Vue({
        el: '#app',
        data: {
            days: {
                1: 'Понедельник',
                2: 'Вторник',
                3: 'Среда',
                4: 'Четверг',
                5: 'Пятница'
            },
            schedule: [],
            loading: false
        },
        methods: {
            unique(arr, field) {
                return !!arr ? arr.map(v => v[field]).filter((v, i, a) => a.indexOf(v) === i) : []
            }
        },
        created() {
            if(location.search) {
                this.loading = true
                axios.get('/api/schedule/group' + location.search)
                .then(response => {
                    this.schedule = response.data
                    this.loading = false
                    for(var d = 1; d <=5; d++) {
                        if(!!!this.schedule[d]) this.schedule[d] = {}
                            for(var n = 1; n <= 6; n++) {
                                if(!!!this.schedule[d][n]) this.schedule[d][n] = {}
                            }
                    }
                })                 
            }          
        }
    })
</script>
@endsection