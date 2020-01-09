<?php $route = Route::currentRouteName(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Название придумаю</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/public/css/custom.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-fixed-top">
		<a class="navbar-brand" href="/">is.KIT</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor01">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item {{ $route == 'groups' ? 'active' : ''}}">
					<a class="nav-link" href="/groups">Группы</a>
				</li>
				<li class="nav-item {{ $route == 'graphic' ? 'active' : ''}}">
					<a class="nav-link" href="/graphic">График учебного процесса</a>
				</li>
				<li class="nav-item {{ $route == 'schedule' ? 'active' : ''}}">
					<a class="nav-link" href="/schedule">Основное расписание</a>
				</li>
				<li class="nav-item {{ $route == 'changes' ? 'active' : ''}}">
					<a class="nav-link" href="/changes">Изменения в расписании</a>
				</li>
				<li class="nav-item {{ $route == 'subjects' ? 'active' : ''}}">
					<a class="nav-link" href="/subjects">Дисциплины</a>
				</li>
				<li class="nav-item {{ $route == 'teachers' ? 'active' : ''}}">
					<a class="nav-link" href="/teachers">Преподаватели</a>
				</li>
				<li class="nav-item {{ $route == 'plans' ? 'active' : ''}}">
					<a class="nav-link" href="/plans">Учебные планы</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="container mt-4">
		@yield('content')
	</div>
	<script type="text/javascript" src="/public/js/jquery.js"></script>
	<script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
</body>
</html>