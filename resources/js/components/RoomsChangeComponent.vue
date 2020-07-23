<template>
<!-- DELETE COMPONENT -->
<div class="modal fade" id="showModalRoom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
			<div class="modal-header">
        		<h5 class="modal-title" id="exampleModalLabel">Rooms 1</h5>
				<small>Choose a room to start chatting</small>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<input type="text" class="form-control" id="searchxt" aria-describedby="search" placeholder="Search room" />			
							<small class="form-text text-muted">Find your preferred room in this field.</small>
						</div>
					</div>
					<div class="col-md-1 d-none d-sm-block">
						<small style="margin-left: -15px"><b>EMPTY</b></small>
						<small style="margin-left: -15px;"><b>ROOMS</b></small>
					</div>
					<div class="col-md-2 d-none d-sm-block">
						<input type="checkbox" id="selected" data-toggle="toggle"/>
					</div>
				</div>
				<div class="row" style="height: 300px; overflow-y: auto;">
					<div class="col-md-12">
						<table class="table table-bordered table-striped" id="searchxt">
							<thead>
								<tr>
									<td class="text-center">Room Name</td>
									<td class="text-center">Users</td>
									<td class="text-center">Action</td>
								</tr>
							</thead>
							<tbody>
								<tr v-for="room in arrayRooms" :key="room.id">
									<td >	
										<div class="row">
										<div class="col-md-4" v-if="room.room_photo == null">
										
											<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
												<span class="avatar-u1-m">
													{{ room.room_name.substring(0,1).toUpperCase() }} 
												</span> 
											</span>
											
										</div>
										<div class="col-md-4" v-if="room.room_photo !== null">
										
											<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
												<img :src="`/chat/public/room/${ room.room_photo }`" alt="root" class="avatar-u1-o js-croppedAvatar cropImage" draggable="false" style="left: -9px; top: 0px; touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); width: 115px;">
											</span>									
										</div>
										<div class="col-md-8">
										{{ room.room_name }} <br/>
										<small>{{ room.room_description }}</small>
										</div>
										</div>
									</td>
									<td class="text-center"><small>{{ room.count_room }}</small></td>
									<td class="text-center justify-content-center">
										<a class="btn btn-success btn-block btn-sm active" @click="selectedRoom(`${room.id}`)" role="button">
											<i class="fas fa-door-open"></i>
											Enter
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-right" data-dismiss="modal">
						<a href="#" class="btn btn-default">Close</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script>
export default {
	data(){
		return{
			arrayRooms: [], // Este array contendrá las tareas de nuestra bd
		}
	},
	methods:{
		getRooms: function() {
			let me = this;
			let url = this.$backendURL + '/room/getRoom' //Ruta que hemos creado para que nos devuelva todas las tareas
			axios.get(url).then(function (response) {
				//creamos un array y guardamos el contenido que nos devuelve el response
				me.arrayRooms = response.data;
			})
			.catch(function (error) {
				// handle error
				console.log(error);
			});
		},
		selectedRoom: function(id) {
			
			location.href = this.$backendURL + '/room/selected/' + id;
		}
	},
	mounted() {
		this.getRooms();
	}
}
</script>