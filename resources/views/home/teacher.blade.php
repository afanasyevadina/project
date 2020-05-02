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
                <div class="card-header">Личный кабинет преподавателя</div>

                <div class="card-body">
                    <p>{{ Menu::greeting($teacher->fullName, 'teacher') }}</p>
                    {{ Menu::now() }}
                </div>
            </div>
        </div>
    </div>
</div>
<ul class="list-group">
    <li class="list-group-item d-flex justify-content-around align-items-center session-progress">
        <div>
            <h4 class="text-primary">Закрытие сессии</h4>
            <p class="text-info">Выставлены оценки по {{$progress}} предметам из {{$subjects->count()}}</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" height="220" width="220">
            <circle cx="50%" cy="50%" r="100" fill="transparent" stroke="#ddd" stroke-width="10"/>
            <circle class="percentage" cx="50%" cy="50%" r="100" fill="transparent" stroke="green" stroke-width="10" stroke-dasharray="0 1000"/>
            <text x="50%" y="50%" text-anchor="middle" alignment-baseline="middle"></text>
        </svg>
    </li>
</ul>
<table class="table">
    <tr>
        <th>Предмет</th>
        <th>Группа</th>
        <th>Выставлено оценок</th>
        <th></th>
    </tr>
    @foreach($subjects as $subject)
    <tr>
        <td>{{$subject->subject->name}}</td>
        <td>{{$subject->group->name}}</td>
        <td>{{$subject->results()->where('itog', '>', 2)->count()}} / {{$subject->results()->count()}}</td>
        <td>
            @if($subject->results()->where('itog', '>', 2)->count() == $subject->results()->count())
            <span class="ready"></span>
            @endif
        </td>
    </tr>
    @endforeach
</table>
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