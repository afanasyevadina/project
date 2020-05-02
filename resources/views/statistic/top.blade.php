@extends('layouts.app')
@section('title', 'Топ - 100')
@section('content')
<h3>Топ - 100</h3>
<hr>
<form>
    <div class="row">
        <div class="form-group col-sm-3">
            <label>Группа</label>
            <select name="group" class="form-control form-control-sm">
                <option value="">Все</option>
                @foreach($groups as $g)
                <option value="{{ $g->id }}" {{ $g->id == @$_GET['group'] ? 'selected' : '' }}>{{ $g->name }}</option>
                @endforeach
            </select>
        </div>  
        <div class="form-group col-sm-3">
            <label>Учебный год</label>
            <select name="year" class="form-control form-control-sm" required>
                @for($i = date('Y') - 4; $i <= date('Y'); $i ++)
                <option value="{{ $i }}" {{ $i == $year ? 'selected' : ''}}>{{ $i }}-{{ $i + 1 }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group col-sm-3">
            <label>Семестр</label>
            <select name="semestr" class="form-control form-control-sm" required>
                <option {{ 1 == $sem ? 'selected' : ''}}>1</option>
                <option {{ 2 == $sem ? 'selected' : ''}}>2</option>
            </select>
        </div>
        <div class="col-sm-2 form-group">
            <label>&nbsp;</label><input type="submit" value="Показать" class="btn btn-sm btn-info d-block">
        </div>
    </div>
</form>
<table class="table table-striped">
@forelse($top as $key => $item)
<tr>
    <td class="th-num">{{$key+1}}</td>
    <td>{{$item['student']->surname.' '.$item['student']->name}}</td>
    <td>{{$item['student']->group->name}}</td>
    <td>{{$item['avg']}}</td>
</tr>
@empty
<div class="alert alert-info">Не найдено.</div>
@endforelse
</table>
@endsection