@extends('layouts.app')
@section('title', 'Форум')
@section('content')
<div class="d-flex justify-content-between">
	<h3>Форум</h3>
	<button data-toggle="modal" data-target="#new" class="btn btn-sm btn-outline-success">Создать тему</button>
</div>
<hr>
<div class="modal fade" id="new">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/forum" method="post" class="self-reload">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Новая тема</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-sm-12">
							<label class="label-sm">Название</label>
							<input type="text" name="name" autocomplete="off" class="form-control form-control-sm" required>
						</div>
						<div class="form-group col-sm-12">
							<label class="label-sm">Описание</label>
							<textarea name="description" class="form-control form-control-sm" required rows="5"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer"><input type="submit" class="btn btn-success" value="Сохранить"></div>
			</form>
		</div>
	</div>
</div>
<ul class="list-group">
	@forelse($topics as $topic)
	<li class="list-group-item">
		<div class="d-flex justify-content-between align-items-start">
			<h4>
				<a class="text-decoration-none text-dark" href="/forum/{{$topic->id}}">{{ $topic->name }}
					@if($topic->unread)
					<span class="badge badge-primary">{{$topic->unread}}</span>
					@endif
				</a>
			</h4>
			@if($topic->user_id == \Auth::user()->id || \Auth::user()->role == 'admin')
			<a class="btn btn-sm btn-outline-primary" href="/forum/{{$topic->id}}/edit">Редактировать</a>
			@endif
		</div>
		<p class="text-secondary">{{ $topic->description }}</p>
		<hr>
		<div class="d-flex justify-content-between">
			<small class="d-flex align-items-center">
				<img src="/public/img/icons/user.svg" height="15" class="muted-img mr-1">
				Создал {{ $topic->user->name }} {{ $topic->date }}
			</small>
			<small class="d-flex align-items-center">
				<img src="/public/img/icons/message.svg" height="15" class="muted-img mr-1">
				{{ $topic->messages()->count() }}
			</small>
			@if(count($topic->messages))
			<small class="d-flex align-items-center">
				<img src="/public/img/icons/time.svg" height="15" class="muted-img mr-1">
				{{$topic->lastMessage->user->username}} 
				{{ $topic->lastMessage->created_at->format('d.m.Y H:i') }}
			</small>
			@endif
		</div>
	</li>
	@empty
	<div class="alert alert-info">Тем пока нет. Начните вы!</div>
	@endforelse  
</ul>
@endsection