@extends('layouts.app')
@section('title', 'Моя динамика')
@section('content')
<h3>Моя динамика</h3>
@for($s = 1; $s <= $student->group->kurs * 2; $s++)
<hr>
<h4 class="text-center text-muted mb-3">{{$s}} семестр</h4>
<canvas id="myChart{{$s}}" width="400" height="150"></canvas>
@endfor
@endsection
@section('scripts')
<script src="/public/js/Chart.bundle.min.js"></script>
<script>
    var ctx, myChart
    @for($s = 1; $s <= $student->group->kurs * 2; $s++)
    <?php $subjects = $student->subjects($s); ?>
    ctx = document.getElementById('myChart{{$s}}');
    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
            @foreach ($subjects as $subject)
            '{{ $subject->subject->short_name ?? $subject->subject->name }}',
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
                '{{ @$results[$s][$subject->subject_id] }}',
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
            layout: {
                padding: {
                    left: 50,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: false,
                    },
                    gridLines: {
                        lineWidth: 1
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false,
                    },
                    ticks: {
                        beginAtZero: true,
                        steps:5,
                        stepValue:1,
                        max:5
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Средний балл',
                        fontSize: 16,
                        padding: 15,
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
    @endfor
</script>
@endsection
