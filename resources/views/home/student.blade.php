@extends('layouts.app')
<?php
use App\Menu;
?>
@section('title', 'Домашняя страница')
@section('content')
<div class="container mb-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Личный кабинет студента</div>

                <div class="card-body">
                    <p>{{ Menu::greeting($student->name) }}</p>
                    {{ Menu::now() }}
                </div>
            </div>
            <br>
        </div>
    </div>
</div>
<ul class="list-group">
    <li class="list-group-item d-flex justify-content-around align-items-center session-progress flex-wrap">
        <div>
            <h4 class="text-primary">Закрытие сессии</h4>
            <p class="text-info">Сдано предметов: {{$progress}} из {{$subjects->count()}}</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" height="220" width="220">
            <circle cx="50%" cy="50%" r="100" fill="transparent" stroke="#aaa" stroke-width="10"/>
            <circle class="percentage" cx="50%" cy="50%" r="100" fill="transparent" stroke="green" stroke-width="10" stroke-dasharray="0 1000"/>
            <text x="50%" y="50%" text-anchor="middle" alignment-baseline="middle"></text>
        </svg>
    </li>
</ul>
<div class="table-responsive">
    <table class="table">
        <tr>
            <th>Предмет</th>
            <th>Преподаватель</th>
            <th>Средний текущий</th>
            <th>Аттестация</th>
            <th>Итог</th>
            <th></th>
        </tr>
        @foreach($subjects as $subject)
        <tr class="{{$subject->itog == 5 ? 'table-success' : ''}}">
            <td>{{$subject->plan->subject->name}}</td>
            <td>{{$subject->plan->teacher->fullName}}</td>
            <td>{{$student->avgRating($subject->plan->subject->id, $subject->plan->semestr)}}</td>
            <td>{{$subject->att}}</td>
            <td>{{$subject->itog}}</td>
            <td>
                @if($subject->itog)
                <span class="ready"></span>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    var progress = {{$subjects->count() ? $progress/$subjects->count() : 0}};
    var circle = document.querySelector('.session-progress circle.percentage')
    var text = document.querySelector('.session-progress text')
    var value = 0
    var interval = setInterval(() => {
        value = value + 1 > progress*100 ? Math.round(progress*100) : value + 1
        text.innerHTML = value + '%'
        if(value >= progress*100) clearInterval(interval)
    }, 10)
    circle.style.strokeDasharray = circle.getTotalLength()*progress + ' 1000'
</script>
@endsection
