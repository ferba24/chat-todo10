<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="{{ asset('img/chat.png') }}">
	
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	
	<link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet"/>
	<link href="{{ asset('fontawesome/css/solid.min.css') }}" rel="stylesheet"/>	
	<link href="{{ asset('textrich/src/richtext.min.css') }}" rel="stylesheet" >
	<link href="{{ asset('css/bootstrap-toggle.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/messages.css') }}" rel="stylesheet">
</head>
<body style="background-color: white">
    
	<div id="app-vue">
		@yield('content')
	</div>
    
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-toggle.min.js') }}"></script>
	<script src="{{ asset('textrich/src/jquery.richtext.min.js') }}"></script>
	<script src="{{ asset('js/socket.io.min.js') }}"></script>
	<script src="{{ asset('js/ion.sound.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>

 	@yield('script')
 	
</body>
</html>
