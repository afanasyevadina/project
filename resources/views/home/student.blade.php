@extends('layouts.app')
<?php
use App\Menu;
?>
@section('title', 'Домашняя страница')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Личный кабинет студента</div>

                <div class="card-body">
                    <p>Welcome, {{ $student->name }}!</p>
                    {{ Menu::now() }}
                </div>
            </div>
            <br>
            @verbatim
            <div class="card">
                <div class="card-header">Расписание на сегодня</div>
                <div class="card-body" id="app">
                    <div v-if="loading">
                        <div class="loader"></div>
                    </div>
                    <table v-else-if="schedule" class="table table-bordered table-sm">
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
            </div>
            @endverbatim
        </div>
    </div>
</div>
<hr>
<canvas id="myChart" width="400" height="150"></canvas>
@endsection
@section('scripts')
<script src="public/js/Chart.bundle.min.js"></script>
<script>
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
            @foreach ($subjects as $subject)
            '{{ $subject->subject->name }}',
            @endforeach
            ],
            datasets: [{
                label: 'Средний текущий',
                data: [
                @foreach ($subjects as $subject)
                '{{ $student->avgRating($subject->subject_id, $subject->semestr) }}',
                @endforeach
                ],
                backgroundColor: [
                @foreach ($subjects as $subject)
                'rgba(139,195,74,0.5)',
                @endforeach
                ],
            },
            {
                label: 'Итоговый балл',
                data: [
                @foreach ($subjects as $subject)
                '{{ @$results[$subject->subject_id] }}',
                @endforeach
                ],
                backgroundColor: [
                @foreach ($subjects as $subject)
                'rgba(39,95,174,0.5)',
                @endforeach
                ],
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        steps:5,
                        stepValue:1,
                        max:5
                    },
                    gridLines: {
                        display: false,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Средний балл',
                        fontSize: 16,
                        padding: 15,
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: false,
                    },
                    barPercentage: 0.7,
                    gridLines: {
                        lineWidth: 3,
                    }
                }]
            },
            legend: {
                position: 'right',
                labels: {
                    fontSize: 16
                },
            }
        }
    });

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
            day: '',
            schedule: null,
            loading: false,
            ready: false
        },
        methods: {
            unique(arr, field) {
                return !!arr ? arr.map(v => v[field]).filter((v, i, a) => a.indexOf(v) === i) : []
            }
        },
        created() {
            this.day = this.days[<?=@date('N')?>]
            this.loading = true
            axios.get('/api/changes/group?group=' + <?=$student->group_id?>)
            .then(response => {
                this.schedule = response.data
                this.loading = false
                this.ready = true
            })     
        }
    })
</script>
@endsection
