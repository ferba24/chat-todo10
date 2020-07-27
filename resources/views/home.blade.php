@extends('layouts.app')

@section('content')
<div class="container-fluid fill">
    <div class="row justify-content-center fill">
        <div class="col-md-9" style="margin-bottom: 20px">
            <div id="card-box-messages" class="card">
                <div class="card-header">
					<!-- ARREGLAR CON UN COMPONENTE DE VUE -->
					@if($rooms)
					<ul class="nav nav-pills nav-stacked">
						@foreach($rooms as $room)
							@if($room->room_id == 1)
						<li class="nav-item"><a href="#" class="@if($sessionRoom == $room->room_id) active @endif">{{ $room->room_name }}&nbsp;&nbsp;&nbsp;</a>
								@if($room->id != 1)
							<span class="badge" id="badge" style="cursor: pointer" title="Exit room" onclick="exitRoom({{ $room->id }})"><i class="fas fa-times"></i></span>
								@endif
						</li>
							@else
						<li class="nav-item"><a class="@if($sessionRoom == $room->room_id) active @endif" href="{{ route('room.change', $room->id) }}">{{ $room->room_name }}&nbsp;&nbsp;&nbsp;</a> 
								@if($room->id != 1)
							<span class="badge" id="badge" style="cursor: pointer" title="Exit room" onclick="exitRoom({{ $room->id }})"><i class="fas fa-times"></i></span>
								@endif
						</li>
							@endif
						@endforeach	
					</ul>
					@endif
				</div>
				<div class="alert alert-success text-center" role="alert" style="padding: 5px;">
					<small>This is a custom notice for this room. Terms and condictions link? Rules link? Whatever</small>
				</div>
				<chatmessages-component :messages="messages"></chatmessages-component>
			</div>
			<div id="card-box-form">
				<groupformchat-component v-on:messagesent="addMessage"></groupformchat-component>
			</div>
        </div>
        <div class="col-md-3">
			<sidebar-component :login_user="login_user"></sidebar-component>
		</div><!-- .col-md-3 -->
	</div><!-- .row.justify-content-center -->
</div><!-- .container-fluid -->
<rooms-component :login_user="login_user"></rooms-component>
<login-user-component v-on:login_usersent="setLoginUser"></login-user-component>
<!-- <private-component></private-component> -->
@endsection