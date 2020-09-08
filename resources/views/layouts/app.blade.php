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
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">

    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet"> 
	
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	
	<link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet"/>
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/messages.css') }}" rel="stylesheet">
	<script src="{{asset('js/tinymce.min.js?apiKey=r72gi40ebpxjpvsf9huxa66nnm5ykzsz4390dhb5wvea5yg4') }}"></script>
</head>
<body>
    <div id="app-vue" class="fill">
		<navbar-component :login_user="login_user" :sound_active="sound_active" v-on:sound_activesent="setSoundActive"></navbar-component>
		
        @yield('content')
		
    @include('private')
    </div>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
	
	@yield('script')
	
	<script src="{{ asset('js/highlight.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap4-toggle.min.js') }}"></script>
</body>
</html>
