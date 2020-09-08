@extends('layouts.app')

@section('content')
<div class="container-fluid fill">
    <div class="row justify-content-center fill vh100-55px">
        <div id="chatGroup" class="col-md-9 pr-0 pl-0">
            <div id="card-box-messages" class="card border-0">
                <div class="card-header">
					<tabsroom-component :rooms="rooms" :current_room="current_room" v-on:current_roomsent="changeCurrentRoom" v-on:rooms_sent="deleteRoomFromUser"></tabsroom-component>
				</div>
				<!--<div class="alert alert-success text-center" role="alert" style="padding: 5px;">
					<small>This is a custom notice for this room. Terms and condictions link? Rules link? Whatever</small>
				</div>-->
				<chatmessages-component :messages="messages" :current_room="current_room" :login_user_roles="login_user_roles"></chatmessages-component>
			</div>
			<div id="card-box-form">
				<groupformchat-component v-on:messagesent="addMessage"></groupformchat-component>
			</div>
			
			<div id="slide_block" class="slide_block" onclick="widthAllChat();"></div>
		</div>
        <div class="col-md-3 pr-0 pl-0">
			<sidebar-component :login_user="login_user" :current_room="current_room" :rooms="rooms" v-on:current_roomsent="setRoomUser" v-on:connected_userssent="setConnectedUsers"></sidebar-component>
		</div><!-- .col-md-3 -->
	</div><!-- .row.justify-content-center -->
</div><!-- .container-fluid -->
<rooms-component :login_user="login_user" :current_room="current_room" v-on:current_roomsent="setRoomUser" :connected_users="connected_users"></rooms-component>
<login-user-component v-on:login_usersent="setLoginUser"></login-user-component>
<!-- <private-component></private-component> -->
@endsection
@section('script')
<script>
	function widthAllChat(){
		if(document.getElementById('chatGroup').classList.contains('col-md-9')){
			document.getElementById('chatGroup').classList.remove("col-md-9");
			document.getElementById('chatGroup').classList.add("col-md-12");

			document.getElementById('sidebarGroup').style.display="none";
		}else{
			document.getElementById('chatGroup').classList.remove("col-md-12");
			document.getElementById('chatGroup').classList.add("col-md-9");

			document.getElementById('sidebarGroup').style.display="block";
		}
	}
</script>
@endsection