<?php 
use App\Menu;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>@yield('title', 'Название пока такое')</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/public/css/custom.css">
	<script type="text/javascript" src="/public/js/jquery.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-fixed-top">
		@auth
		<button class="navbar-toggler d-block" aria-expanded="false" aria-label="Toggle navigation" id="menu-toggle">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a href="/" class="navbar-brand ml-2">Информационная система КИТ</a>
		<div class="nav-item dropdown ml-auto mr-2">
			<a class="nav-link navbar-text d-flex align-items-center dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img src="/public/img/icons/user.svg" height="15" class="white-img muted-img mr-1">
				{{ \Auth::user()->name }}&nbsp;
			</a>
			<div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="navbarDropdown">
				<form action="/logout" method="post">@csrf
					<input type="submit" value="Выход" class="logout-button navbar-text dropdown-item">
				</form>
				<a href="/password/change" class="navbar-text dropdown-item">Сменить пароль</a>
			</div>
		</div>
		@endauth
		@guest
		<a href="/login" class="navbar-text mr-2 ml-auto">Войти</a>
		@endguest
	</nav>
	<div class="d-flex h-100vh" id="wrapper">
		@auth
		<div class="sidebar" id="navbar">
			<ul class="navbar-nav">
				@foreach(Menu::menu(Route::currentRouteName()) as $key => $item)
				@if(isset($item['children']))
				<li data-toggle="collapse" data-target=".menu-{{ $key }}">
					<span>{{ $item['label'] }}</span>
				</li>
				@foreach($item['children'] as $subItem)
				<li class="collapse pl-2 menu-{{ $key }} {{ $subItem['class'] }} {{ $item['class'] }}">
					<a href="/{{ $subItem['path'] }}" class="d-flex justify-content-between">{{ $subItem['label'] }}
						@if(isset($subItem['badge']))
						<span class="badge badge-primary p-1">{{$subItem['badge']}}</span>
						@endif
					</a>
				</li>
				@endforeach
				@else
				<li class="{{ $item['class'] }}">
					<a href="/{{ $item['path'] }}" class="d-flex justify-content-between">{{ $item['label'] }}
						@if(isset($item['badge']))
						<span class="badge badge-primary p-1">{{$item['badge']}}</span>
						@endif
					</a>
				</li>
				@endif
				@endforeach
			</ul>
		</div>
		@endauth
		<div class="container-fluid mt-4">
			<div class="clear-fix"></div>		
			@yield('content')
		</div>
	</div>
	<script type="text/javascript" src="/public/js/app.js"></script>
	<script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/public/js/search.js"></script>
	<script type="text/javascript" src="/public/js/self-reload.js"></script>
	@yield('scripts')
	<script type="text/javascript" src="/public/js/menu.js"></script>
</body>
</html>