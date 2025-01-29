<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="data/styles/style.css">
	<title>Авторизация</title>
</head>

<body>
	<div class="container menu">
		<div class="row menu">
			<div class="col-12">
				<hr>
				<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
						<div class="navbar-nav">
							<?php if ($authorised) : ?>
								<a class="nav-item nav-link active" href="?page=3">Главная<span class="sr-only">(current)</span></a>
								<a class="nav-item nav-link active" href="?page=4" ?>Выйти</a>
							<?php endif; ?>
							<?php if (!isset($authorised) or !$authorised) : ?>
								<a class="nav-item nav-link active" href="?page=2">Регистрация</a>
								<a class="nav-item nav-link active" href="?page=1">Авторизация</a>
							<?php endif; ?>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</div>
	<div class="container aditional_data">
		<div class="row main">
			<div class="col-12">
				<?php include $content_view; ?>
			</div>
			<div>
			</div>
			<div class="container footer">
				<div class="row footer">
					<div class="col-12">
						<hr>
						<h3>CopyBook</h3>
						<p>&#169 2021. Все права защищены</p>
					</div>
					<div>
						<div>
</body>

</html>