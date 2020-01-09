@extends('layouts.app')
@section('content')
<div class="text-right">
    <a href="changes/upload" class="btn btn-sm btn-outline-success">Загрузить</a>
</div>
<hr>
<form>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Дата</label>
                <input type="date" name="date" class="form-control form-control-sm" value="{{ @$_GET['date'] }}">
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
    <div class="row">
        <div class="col-md-4" v-for="group in schedule">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>{{ group.name }}</th>
                        <th>Каб.</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="num in 7">
                        <td>{{ num }}</td>
                        <td>{{ !!group.lessons[num] ? group.lessons[num].subject : '' }}</td>
                        <td>{{ !!group.lessons[num] ? group.lessons[num].cab : '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endverbatim
<script type="text/javascript" src="/public/js/app.js"></script>
<script>
    const app = new Vue({
        el: '#app',
        data: {
            schedule: [],
            loading: false
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