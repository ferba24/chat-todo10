@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9" style="margin-bottom: 20px">
            <div class="card" style="height:350px;">
                <div class="card-header">
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
                <div class="card-body" style="overflow-y: auto;" id="scroll">
					<div class="mesgs">
						<div class="msg_history">
							<div id="messages" style=" margin-top: -15px;"></div>
						</div>
					</div>
                </div>
            </div>
			<br/>
			<form>
				<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
				<div class="row">
					<div class="col-md-10">
						<textarea class="content" name="text" id="text" placeholder="Messages" autofocus></textarea>
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-primary form-control" name="sendMessage" id="sendMessage" onclick="messagesAdd(this)">Send</button>
					</div>
				</div>
			</form>
        </div>
        <div class="col-md-3">
			<sidebar-component></sidebar-component>
		</div><!-- .col-md-3 -->
	</div><!-- .row.justify-content-center -->
</div><!-- .container-fluid -->
<rooms-component></rooms-component>
<rooms-change-component></rooms-change-component>
<login-user-component></login-user-component>
<private-component></private-component>
@endsection

@section('script')
	@if(!$sessionRoom)
		@if($xen_user)
			<script src="{{ asset('js/chat-empty.js') }}"></script>
		@else
			<script src="{{ asset('js/chat-login.js') }}"></script>
		@endif
	@else
		@if($xen_user)
			<script type="text/javascript">
				var user_id = "{{ session('user') }}";
				var url = "{{ env('MIX_APP_URL') }}";
			</script>
			<script src="{{ asset('js/chat.js') }}"></script>
		@else
			<script src="{{ asset('js/chat-login.js') }}"></script>
		@endif
	@endif
@endsection