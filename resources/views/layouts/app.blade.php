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
	<!--<link href="{{ asset('textrich/src/richtext.min.css') }}" rel="stylesheet" >-->
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/messages.css') }}" rel="stylesheet">
	<script src="{{asset('tinymce.min.js?apiKey=r72gi40ebpxjpvsf9huxa66nnm5ykzsz4390dhb5wvea5yg4') }}"></script>
	<script>
		/*tinymce.init({
			menubar: false,
			selector:'#text',
			height: 50,
			toolbar: 'bold italic underline',
			setup: function (ed) {
				// Se puso el setup para evitar el enter en el chat
				ed.on('keydown',function(e) {
					if(e.keyCode == 13){
						alert("ENTER PRESSED");
						e.preventDefault();
					}
				});
			}
		});*/
		tinymce.execCommand('mceFocus',false,'text');
		tinymce.init({
			selector:'#text2',
			setup: function (ed) {
				ed.on('keydown',function(e) {
					if(e.keyCode == 13){
						alert("ENTER PRESSED");
						e.preventDefault();
					}
				});
			}
		});
	</script>
</head>
<body>
    <div id="app-vue" class="fill">
		<input type="hidden" name="user_id" id="user_id" value="{{ session('user') }}"/>		
		<nav id="card-box-navbar" class="navbar navbar-expand-md navbar-light bg-white shadow-lg navbar-custom" >
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
					@if(isset($xen_user) && $xen_user)
                    <ul class="navbar-nav mr-auto">	
                        <li  class="dropdown" id="user-content-me3">	
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="text-decoration: none;">
								<span class="avatar avatar--xxs avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
								<span class="avatar-u1-s">
									{{ strtoupper(substr($xen_user->username,0,1)) }}
								</span> 
							</span>
								<small style="padding-left: 5px">{{ strtoupper($xen_user->username) }}</small>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#" class="nav-link" data-toggle="modal" data-target="#showModalRooms"><small>ROOMS</small></a></li>
								<li><a href="{{ route('home.logout') }}" class="nav-link"><small>LOGOUT</small></a></li>
							</ul>
                        </li>
                    </ul>
					@endif
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
						<li class="nav-item">
							<a class="nav-link" href="{{ env('URL_SYSTEM') }}" style="color: white">
								<i class="fas fa-home"></i>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#" data-toggle="modal" data-target="#showModal" style="color: white">
								<small>ROOMS LIST</small>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#" data-toggle="modal" data-target="#showModalPrivate" style="color: white">
								<i class="far fa-comment-dots"></i>
								<small>PRIVATE MSG</small>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" style="color: white">
								<i class="fas fa-music"></i>
								<small>SOUNDS</small>
							</a>
						</li>
						<li class="nav-item">
							<input type="checkbox" name="toggle-event" id="toggle-event" checked data-toggle="toggle"/>
						</li>
                    </ul>
                </div>
            </div>
        </nav>
        
        @yield('content')
		
		<div class="modal fade" id="showModalRoomAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Rooms 2</h5>
						<small>Rooms to users in the chat.<small>
					</div>
					<div class="modal-body">
						<iframe src="{{ route('room.index') }}" style="width: 100%; height: 400px;" frameborder="0" ></iframe>
					</div>
					<div class="row">
						<div class="col-md-12 text-right">
							<a href="" class="btn btn-default" data-dismiss="modal">Close</a>
						</div>
					</div>
				</div>
			</div>
		</div>
    @include('private')
    </div>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
	<!--<script src="{{ asset('textrich/src/jquery.richtext.min.js') }}"></script>	-->
	<!--<script src="{{ asset('js/socket.io.min.js') }}"></script>-->
	<script src="{{ asset('js/ion.sound.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>
	
	@yield('script')
	
	<script src="{{ asset('js/highlight.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap4-toggle.min.js') }}"></script>
	
	<script type="text/javascript">

		$(document).on('touch.bs.toggle click.bs.toggle', 'div[data-toggle^=toggle]', function (e) {
				var $checkbox = $(this).find('input[type=checkbox]');
				if(!$(this).hasClass('off')) {
					if($checkbox[0].attributes.id.value == 'selected') {
						 $.each($("#searchxt tbody tr"), function() {
							 if($(this).find("td:nth-child(2)").text() != '0') {
								$(this).hide();
							 } else {
								$(this).show();
							 }
						});
					}
					/*if($checkbox[0].attributes.id.value == 'selectedx') {
						$.each($("#searchy tbody tr"), function() {
							 if($(this).find("td:nth-child(2)").text() != '0') {
								$(this).hide();
							 } else {
								$(this).show();
							 }
						});
					}*/
				} else {
					
					if($checkbox[0].attributes.id.value == 'selected') {
						 $.each($("#searchxt tbody tr"), function() {
							$(this).show();
						});
					}
					
					/*if($checkbox[0].attributes.id.value == 'selectedx') {
						$.each($("#searchy tbody tr"), function() {
							$(this).show();
						});
					}*/
				}
			});
	</script>
 	
</body>
</html>
