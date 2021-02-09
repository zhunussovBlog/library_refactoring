<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="This is an official website of Suleyman Demirel University's (SDU) library">
    
    <title>Library SDU</title>
</head>
<body>
<div id="app">
    <app></app>
</div>
<script src="{{ mix('js/user.js') }}"></script>
</body>
</html>
