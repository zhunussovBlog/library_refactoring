<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="This is an official website of Suleyman Demirel University's (SDU) library">

	<!-- bootstrap --> 

	<link rel="stylesheet" href="/bootstrap/bootstrap.4.3.1.css.bootstrap.min.css">
	<script src="/bootstrap/jquery-3.3.1.slim.min.js"></script>
	<script src="/bootstrap/ajax.libs.popper.js.1.14.7.umd.popper.min.js"></script>
	<script src="/bootstrap/bootstrap.4.3.1.js.bootstrap.min.js"></script>

	<!-- /bootstrap -->

	<!-- ask us -->

	<script src="https://sdu-kz.libanswers.com/load_chat.php?hash=e250e6e469c178c6e24700298be9a087"></script>

	<!-- /ask us -->

	<title>Library SDU</title>
</head>
<body>
	<div id="app">
		<app></app>
	</div>
	<script src="{{ mix('js/user.js') }}"></script>
</body>
</html>
