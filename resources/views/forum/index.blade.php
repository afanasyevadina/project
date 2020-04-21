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
		<h4>
			<a class="text-decoration-none" href="/forum/{{$topic->id}}">{{ $topic->name }}</a>
		</h4>
		<p>{{ $topic->description }}</p>
		<hr>
		<div class="row text-muted">
			<small class="col-sm-4">
				Создано пользователем {{ $topic->user->name }} {{ $topic->date }}
			</small>
			<small class="col-sm-4">{{ $topic->messages()->count() }} сообщений</small>
			@if(count($topic->messages))
			<small class="col-sm-4">
				Последнее сообщение от {{$topic->lastMessage->user->name}} 
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