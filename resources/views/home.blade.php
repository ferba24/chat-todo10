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
			<div class="card" style="height:520px;">
                <div class="card-header">
					<ul class="nav nav-pills nav-stacked" id="myTab">
						<li><a href="#home" data-toggle="tab"  class="active">Users &nbsp;
							<span class="badge badge-pill badge-dark">
								<div id="users-count">0</div>
							</span>
						</a></li>
						<li><a href="#menu1" data-toggle="tab" >Rooms &nbsp;<span class="badge badge-pill badge-dark">
						@if(isset($count_rooms))
							{{ $count_rooms }}
						@else
							0
						@endif
						</span></a></li>
					</ul>
				</div>			
				<div class="tab-content">
					<div id="home" class="tab-pane active">			
						<div id="search-wrapper">
							<input type="text" class="form form-control remove-rounded" name="search" id="search" placeholder="Search user ..."/>
							<i class="fa fa-search"></i>
						</div>
						<div class="container">
							<div class="row" style="background-color: #eee; padding-top: 10px;">
								<div class="col-md-12">
									<div class="checkbox">
										<label><input type="checkbox" checked="true">&nbsp;Admins</label>&nbsp;
										<label><input type="checkbox" checked="true">&nbsp;Mods</label>&nbsp;
										<label><input type="checkbox" checked="true">&nbsp;Others</label>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body" style="overflow-y: auto; background-color: white;">							
							<ul style="list-style: none;" id="users-list">
								<div id="users"></div>						
							</ul>								
						</div>
					</div>
					<div id="menu1" class="tab-pane fade">
						<div id="search-wrapperRooms">
							<input type="text" class="form form-control remove-rounded" name="searchRooms" id="searchRooms" placeholder="Search room ..."/>
							<i class="fa fa-search"></i>
						</div>
						<div class="card-body" style="overflow-y: auto; background-color: white;">	
						@if($rooms)
							<ul style="list-style: none;" id="rooms-list">
							@foreach($rooms as $room)
								@if($room->select == '1')
								<li style="padding-bottom: 10px;">			
									<div id="user-content-me2">
										<div class="row">
											<div class="col-md-4">
									@if($room->room_photo)
												<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
													<img src="{{ asset('room/' . $room->room_photo) }}" alt="root" class="avatar-u1-o js-croppedAvatar cropImage" draggable="false" style="left: -9px; top: 0px; touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); width: 115px;">
												</span>
									@else
												<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
													<span class="avatar-u1-m">{{ strtoupper(substr($room->room_name,0,1)) }}</span> 
												</span>
									@endif
											</div>
											<div class="col-md-8">
												{{ $room->room_name }}<br/>
												<small>{{ $room->room_description }}</small>
											</div>
										</div>
									</div>
								</li>	
								@else
								<li style="padding-bottom: 10px;">
									<div id="user-content">
										<div class="row">
											<div class="col-md-4">
									@if($room->room_photo)
												<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
													<img src="{{ asset('room/' . $room->room_photo) }}" alt="root" class="avatar-u1-o js-croppedAvatar cropImage" draggable="false" style="left: -9px; top: 0px; touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); width: 115px;">
												</span>
									@else
												<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
													<span class="avatar-u1-m">{{ strtoupper(substr($room->room_name,0,1)) }}</span> 
												</span>
									@endif
											</div>
											<div class="col-md-8">
												{{ $room->room_name }}<br/>
												<small>{{ $room->room_description }}</small><br/>
												
												<small><a href="{{ route('room.change', $room->id) }}" style="color: white">Change</a></small>
											</div>	
										</div>
									</div>
								</li>
								@endif
							@endforeach
							</ul>
						@endif
						</div> <!-- .card-body -->
					</div> <!-- #menu1 -->
				</div><!-- .tab-content -->
			</div><!-- .card -->
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