@extends('layouts.app')
@section('title', 'Расписание группы')
@section('content')
<h3>Расписание группы</h3><hr>
<form>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label>Дата</label>
            <input type="date" name="date" class="form-control form-control-sm" value="{{ @$_GET['date'] ?? date('Y-m-d') }}" required>
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
<br>
@verbatim
<div id="app">
    <div v-if="loading">
        <div class="loader"></div>
    </div>
    <table v-else-if="ready" class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center th-num">№</th>
                <th class="text-center">{{ day }}</th>
                <th class="text-center th-cab">Каб.</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="num in 7">
                <td>{{ num }}</td>
                <td>
                    <template v-for="subject in unique(schedule[num], 'subject')">
                        <span class="d-block">{{ subject }}</span>
                    </template>
                    <i class="d-block text-right">
                        {{ unique(schedule[num], 'teacher').join(' / ') }}
                    </i>
                </td>
                <td class="text-center">
                    <template v-for="cab in unique(schedule[num], 'cab')">
                        <span class="d-block text-center">{{ cab }}</span>
                    </template>
                </td>
            </tr>
        </tbody>
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
                5: 'Пятница',
                6: 'Суббота',
                7: 'Воскресенье'
            },
            day: '',
            schedule: [],
            loading: false,
            ready: false
        },
        methods: {
            unique(arr, field) {
                return !!arr ? arr.map(v => v[field]).filter((v, i, a) => a.indexOf(v) === i) : []
            }
        },
        created() {
            if(location.search) {
                this.day = this.days[<?=@date('N', strtotime($_GET['date']))?>]
                this.loading = true
                axios.get('/api/changes/group' + location.search)
                .then(response => {
                    this.schedule = response.data
                    this.loading = false
                    this.ready = true
                })                 
            }          
        }
    })
</script>
@endsection