@extends('layouts.app')
<?php
use App\Menu;
?>
@section('title', 'Домашняя страница')
@section('content')
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Личный кабинет администратора</div>

                <div class="card-body">
                    <p>{{ Menu::greeting(\Auth::user()->name) }}</p>

                    {{ Menu::now() }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    @can('manager')
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/plans" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/plan.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Учебные планы</p>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/graphic" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/graphic.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">График учебного процесса</p>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/rup" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/rup.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Годовой план</p>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/rp" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/rp.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Рабочая программа</p>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/ktp" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/ktp.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">КТП</p>
            </a>
        </div>
    </div>
    @endcan
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/doc/form3" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/form.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Генерация Формы 3</p>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/schedule/edit" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/schedule.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Редактор расписания</p>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/exams/edit" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/exams.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">График экзаменов</p>
            </a>
        </div>
    </div>
    @can('manager')
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/journal" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/journal.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Журналы успеваемости</p>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/results" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/results.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Итоговые оценки</p>
            </a>
        </div>
    </div>
    @endcan
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/doc/form2" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/form.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Генерация Формы 2</p>
            </a>
        </div>
    </div>
    @can('manager')
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/students" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/students.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Студенты</p>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/teachers" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/teachers.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Преподаватели</p>
            </a>
        </div>
    </div>
    @endcan
    @can('admin')
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/admin/users" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/user.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Пользователи</p>
            </a>
        </div>
    </div>
    @endcan
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/forum" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/forum.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Форум</p>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
        <div class="card">
            <a href="/statistic/top" class="card-body text-center hover-none text-dark">
                <img src="/public/img/icons/top.svg" height="100" class="img-muted">
                <p class="mb-0 mt-2">Топ - 100</p>
            </a>
        </div>
    </div>
</div>
@endsection
