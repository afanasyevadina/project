@extends('layouts.app')
@section('title', 'Изменения в расписании')
@section('content')
<div class="d-flex justify-content-between">
    <h3>Изменения в расписании</h3>
    <div>
        <a href="changes/group" class="btn btn-sm btn-outline-secondary">Расписание группы &raquo;</a>
        <a href="changes/teacher" class="btn btn-sm btn-outline-secondary">Расписание преподавателя &raquo;</a>
    </div>
</div>
<hr>
<form>
    <div class="row">
        <div class="col-sm-3 form-group">
            <label>Дата</label>
            <input type="date" name="date" class="form-control form-control-sm" value="{{ @$_GET['date'] }}">
        </div>
        <div class="col-sm-4 form-group">
            <label>Отделение</label>
            <select name="department" class="form-control form-control-sm">
                <option value="">Отделение</option>
                @foreach($departments as $dep)
                <option value="{{ $dep->id }}" {{ $dep->id == @$_GET['department'] ? 'selected' : ''}}>{{ $dep->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3 form-group">
            <label>Язык обучения</label>
            <select name="lang" class="form-control form-control-sm">
                <option value="">Язык обучения</option>
                @foreach($langs as $lang)
                <option value="{{ $lang->id }}" {{ $lang->id == @$_GET['lang'] ? 'selected' : ''}}>{{ $lang->name }}</option>
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
    <div class="row">
        <div class="col-md-4" v-for="group in schedule">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th class="text-center">№</th>
                        <th class="text-center">{{ group.name }}</th>
                        <th class="text-center">Каб.</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="num in 7">
                        <td>{{ num }}</td>
                        <td>
                            <template v-for="subject in unique(group.lessons[num], 'subject')">
                                <span class="d-block">{{ subject }}</span>
                            </template>
                            <i class="d-block text-right">
                                {{ unique(group.lessons[num], 'teacher').join(' / ') }}
                            </i>
                        </td>
                        <td class="text-center">
                            <template v-for="cab in unique(group.lessons[num], 'cab')">
                                <span class="d-block text-center">{{ cab }}</span>
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
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
                axios.get('api/changes' + location.search)
                .then(response => {
                    this.schedule = response.data
                    this.loading = false
                })      
            }    
        }
    })
</script>
@endsection