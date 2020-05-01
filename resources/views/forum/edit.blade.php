@extends('layouts.app')
@section('title', $topic->name.' | Редактирование')
@section('content')
<div class="alert alert-success col-sm-6 fixed-alert" id="saved" hidden>
	Сохранено
</div>
<h3>{{ $topic->name }}</h3>
<hr>
<form action="/forum/{{$topic->id}}" method="post" class="self-reload" data-alert="#saved">@csrf
	<div class="card">
		<div class="card-body">
			<div class="form-group">
				<label>Название</label>
				<input type="text" name="name" class="form-control" value="{{$topic->name}}" autocomplete="off">
			</div>
			<div class="form-group">
				<label>Описание</label>
				<textarea name="description" rows="3" class="form-control">{{$topic->description}}</textarea>
			</div>
		</div>
	</div>
	<h5 class="my-3">У кого есть доступ к этой теме?</h5>
	<ul class="list-group" >
		@foreach($users as $role => $list)
		<li class="list-group-item">
			<p>{{@$roles[$role]}}:</p>
			<div class="d-flex mb-2">
				<label class="d-block mr-4">
					<input type="radio" name="access[{{$role}}]" value="all" data-el=".{{$role}}-block" 
					{{@in_array('0', $perm[$role]) ? 'checked' : ''}}> Все
				</label>
				<label class="d-block mr-4">
					<input type="radio" name="access[{{$role}}]" value="none" data-el=".{{$role}}-block" 
					{{ !@$perm[$role] ? 'checked' : ''}}> Никто
				</label>
				<label class="d-block mr-4">
					<input type="radio" name="access[{{$role}}]" value="select" data-el=".{{$role}}-block" 
					{{ !@in_array('0', $perm[$role]) && @$perm[$role] ? 'checked' : ''}}> Выбрать
				</label>
			</div>
			<div class="{{$role}}-block" {{@in_array('0', $perm[$role]) || !@$perm[$role] ? 'hidden' : ''}}>
				<input type="text" class="form-control form-control-sm" 
					autocomplete="off" data-search=".{{$role}}-block label" placeholder="Поиск...">
				<div class="row overflow-auto mt-2" style="max-height: 300px">
					@foreach($list as $user)
					<label class="col-md-4 col-sm-6 label-sm d-block pb-2 d-flex">
						<input type="{{$user->id==\Auth::user()->id?'hidden':'checkbox'}}" 
						name="permission[{{$role}}][]" value="{{$user->id}}"
						{{@in_array($user->id, $perm[$role]) ? 'checked' : ''}} 
						style="margin-top: 5px">
						<div class="ml-2" >
							@if(in_array($user->role, ['teacher', 'student']))
							<span>
								{{$user->person->surname.' '.$user->person->name}}
								{{$user->role=='student'?'('.$user->person->group->name.')':''}}
							</span>
							<small class="d-block text-muted">{{'@'.$user->name}}</small>
							@else
							{{$user->name}}
							@endif
							@if($user->id==\Auth::user()->id)
							<small class="d-block text-success">Создатель темы</small>
							@endif
						</div>
					</label>
					@endforeach
				</div>
			</div>
		</li>
		@endforeach
	</ul>
	<button class="btn btn-success" style="position: fixed;bottom: 10px;right: 20px;z-index: 999">Сохранить</button>
</form>
@endsection
@section('scripts')
<script type="text/javascript">
document.querySelectorAll('[name^="access"]').forEach(radio => radio.onchange = function() {
	var block = document.querySelector(radio.dataset.el)
	block.hidden = radio.value != 'select'
	if(radio.value == 'none') {
		block.querySelectorAll('[type="checkbox"]').forEach(cb => cb.checked = false)
	}
})
</script>
@endsection