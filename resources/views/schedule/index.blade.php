@extends('layouts.app')
@section('content')
<?php
$year = @$_GET['year'] ? $_GET['year'] : date('Y');
?>
<div class="text-right">
    <a href="schedule/upload" class="btn btn-sm btn-outline-success">Загрузить</a>
</div>
<hr>
<form>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Учебный год</label>
                <select name="year" class="form-control form-control-sm">
                    @for($i = date('Y') - 3; $i <= date('Y'); $i ++)
                    <option value="{{ $i }}" {{ $i == $year ? 'selected' : ''}}>{{ $i }}-{{ $i + 1 }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Семестр</label>
                <select name="semestr" class="form-control form-control-sm">
                    <option {{ 1 == @$_GET['semestr'] ? 'selected' : ''}}>1</option>
                    <option {{ 2 == @$_GET['semestr'] ? 'selected' : ''}}>2</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Курс</label>
                <select name="kurs" class="form-control form-control-sm">
                    <option value="">Курс</option>
                    @for($i = 1; $i <= 4; $i ++)
                    <option value="{{ $i }}" {{ $i == @$_GET['kurs'] ? 'selected' : ''}}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Отделение</label>
                <select name="department" class="form-control form-control-sm">
                    <option value="">Отделение</option>
                    @foreach($departments as $dep)
                    <option value="{{ $dep->id }}" {{ $dep->id == @$_GET['department'] ? 'selected' : ''}}>{{ $dep->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Язык обучения</label>
                <select name="lang" class="form-control form-control-sm">
                    <option value="">Язык обучения</option>
                    @foreach($langs as $lang)
                    <option value="{{ $lang->id }}" {{ $lang->id == @$_GET['lang'] ? 'selected' : ''}}>{{ $lang->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <input type="submit" value="Показать" class="btn btn-sm btn-outline-primary">
</form>
<hr>
@verbatim
<div id="app">
    <div v-if="loading">
        <div class="loader"></div>
    </div>
    <div v-for="(day, d) in schedule">
        <h4 class="text-center">{{ days[d] }}</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th class="th-num">№</th>
                        <template v-for="group in day">
                            <th class="th-name">{{ group.name }}</th>
                            <th class="th-cab">Каб.</th>
                        </template>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="num in 6">
                        <td>{{ num }}</td>
                        <template v-for="group in day">
                            <td>{{ !!group.lessons[num] ? group.lessons[num].subject : '' }}</td>
                            <td>{{ !!group.lessons[num] ? group.lessons[num].cab : '' }}</td>
                        </template>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
    </div>
</div>
@endverbatim
<script type="text/javascript" src="/public/js/app.js"></script>
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
        created() {
            if(location.search) {
                this.loading = true
                axios.get('api/schedule' + location.search)
                .then(response => {
                    this.schedule = response.data
                    this.loading = false
                }) 
            }          
        }
    })
</script>
@endsection