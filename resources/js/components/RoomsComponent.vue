<template>
<div class="modal fade" id="showModalRooms" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Rooms H</h5>
				<small>Choose a room to start chatting</small>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<input type="text" class="form-control" v-model="term" placeholder="Search room" />
							<small id="searchx" class="form-text text-muted">Find your preferred room in this field.</small>
						</div>
					</div>
					<div class="col-md-1 hidden-md hidden-sm">
						<span style="margin-left: -15px; font-size: 10px;"><b>EMPTY</b></span>
						<span style="margin-left: -15px; font-size: 10px;"><b>ROOMS</b></span>
					</div>
					<div class="col-md-2 hidden-md hidden-sm">
						<input type="checkbox" id="selectedx" data-toggle="toggle"/>
					</div>
				</div>
				<div class="row" style="height: 300px; overflow-y: auto;">
					<div class="col-md-12 p-0">
						<table class="table table-bordered table-striped" id="searchy">
							<thead>
								<tr>
									<td class="text-center">Room Name</td>
									<td class="text-center">Users</td>
									<td class="text-center">Action</td>
								</tr>
							</thead>
							<tbody>
								<tr v-for="room in filterRooms" :key="room.id">
									<td>							
										<div class="row">
											<div class="col-md-4 p-0" v-if="room.room_photo == null">
												<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
													<span class="avatar-u1-m">
														{{ room.room_name | capitalize }} 
													</span> 
												</span>
											</div>
											<div class="col-md-4 p-0" v-if="room.room_photo !== null">
												<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
													<img :src="'/room/'+room.room_photo" :alt="room.room_name | capitalize" class="avatar-u1-o js-croppedAvatar cropImage" draggable="false" style="left: -9px; top: 0px; touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); width: 115px;">
												</span>									
											</div>
											<div class="col-md-8 p-0">
												{{ room.room_name }}
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 p-0">
												<small>{{ room.room_description }}</small>
											</div>
										</div>
									</td>
									<td class="text-center" style="width:90px;">{{ room.count_room }}</td>
									<td class="text-center justify-content-center" style="width:90px;">
										<a class="btn btn-success btn-block btn-sm active" @click="selectedRoom(`${room.id}`)"  role="button"><i class="fas fa-door-open"></i>Enter</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-right">
						<button data-dismiss="modal" type="button" class="btn btn-default">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script>
export default {
	props: ['login_user'],
	data(){
		return{
			arrayRooms: [],
			empty: false,
			term: "",
		}
	},
	methods:{
		getRooms() {
			let me = this;
			let user_id = document.getElementById('user_id').value;
			axios.get(this.$backendURL + '/room/getRoom')
			.then((rooms) => {
				me.arrayRooms = rooms.data;
			}).catch(function (error) {
				console.log('Error in RoomsController.vue: ' + error);
			});
		},
		selectedRoom(id) {
			location.href = this.$backendURL + '/room/selected/' + id;
		},
		emptyRooms(){
			this.empty = (this.empty)?false:true;
		}
	},
	filters: {
		capitalize: function (value){
			if(!value) return ''
			return value.toString().substring(0,1).toUpperCase();

		}
	},
	computed: {
		filterRooms: function(){
			let filtered = this.arrayRooms;
			//Se filtra por rooms vacíos
			if(this.empty){
				filtered = this.arrayRooms.filter(
                    m => m.count_room <= 0
                );
			}
			//Se filtra por el término buscado
			if(this.term != ""){
                filtered = filtered.filter(
                    m => m.room_name.toLowerCase().indexOf(this.term) > -1
                );
            }
			return filtered;
		}
	},
	mounted(){
		//Cada vez que se abre el modal se recarga la lista de rooms
		if(this.login_user != 0){
			$('#showModalRooms').on('show.bs.modal', this.getRooms);
		}
		//Cada vez que cambia el filtro de rooms vacíos
		$(document).on('touch.bs.toggle click.bs.toggle', 'div[data-toggle^=toggle]', this.emptyRooms);
	},
	watch: {
		login_user: function (value) {
            if (value != 0) {
                $('#showModalRooms').on('show.bs.modal', this.getRooms);
            }
        },
	}
}
</script>

<style scoped>
table>thead>tr td{
	padding-top: 5px;
	padding-bottom: 5px;
}
table>tbody>tr td {
	padding: 3px 8px !important;
}
.row{
	margin-left: 0px;
	margin-right: 0px;
}
.avatar.avatar--m {
    width: 40px;
    height: 40px;
    font-size: 30px;
}
small{
	font-size: 9px !important;
}
@media (min-width:768px) {
	.modal-dialog {
		max-width:600px;
		margin:30px auto
	}
}
</style>