<template>
<div class="modal fade" id="showModalRooms" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Rooms</h5>
				<span>Choose a room to start chatting</span>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<input type="text" class="form-control" v-model="term" placeholder="Search room" />
							<span id="searchx" class="form-text text-muted">Find your preferred room in this field.</span>
						</div>
					</div>
					<div class="col-md-1 hidden-md hidden-sm pl-0 pr-0" style="line-height: 14px;">
						<span style="font-size: 12px;">EMPTY ROOMS</span>
					</div>
					<div class="col-md-2 hidden-md hidden-sm" id="toggleRooms" style="height: 40px;">
						<input type="checkbox" id="toggleRooms_input" data-toggle="toggle"/>
					</div>
				</div>
				<div class="row" style="height: 300px; overflow-y: auto;">
					<div class="col-md-12 p-0">
						<table class="table table-bordered table-striped" id="searchy">
							<thead>
								<tr>
									<td class="text-center" style="font-size:11px;">Room Name</td>
									<td class="text-center" style="font-size:11px;">Users</td>
									<td class="text-center" style="font-size:11px;">Action</td>
								</tr>
							</thead>
							<tbody>
								<tr v-if="filterRooms.length <= 0">
									<td>Loading...</td>
								</tr>
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
												<span id="smallText">{{ room.room_description }}</span>
											</div>
										</div>
									</td>
									<td class="text-center" style="width:90px;">{{ room.count_room }}</td>
									<td class="text-center justify-content-center" style="width:90px;">
										<a class="btn btn-success btn-block btn-sm active" @click="selectedRoom(`${room.id}`)"  role="button" href="javascript:void(0)"><i class="fas fa-door-open"></i> Enter</a>
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
	props: ['login_user', 'current_room', 'connected_users'],
	data(){
		return{
			arrayRooms: [],
			empty: false,
			term: "",
			csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
		}
	},
	methods:{
		getRooms() {
			let me = this;
			if(me.login_user != 0){
				axios.get(me.$backendURL + '/api/room/getRooms')
				.then((rooms) => {
					me.arrayRooms = rooms.data;
					me.updateCurrentUsersByRooms();
				}).catch(function (error) {
					console.log('Error RoomsController.vue in getRooms(): ' + error);
				});
			}
		},
		selectedRoom(id) {
			let me = this;
			axios.post(me.$backendURL + '/api/room/select', {
				_token: this.csrf,
				room_id: id,
			}).then((response) => {
				if(response.data.success){
					this.$emit('current_roomsent', {
						room_id: parseInt(response.data.room_id)
					});
					$('#showModalRooms').modal('hide');
				}else{
					console.dir(response.data.error);
				}
			}).catch(function (error) {
				console.log('Error RoomsController.vue in selectedRoom(): ' + error);
			});
		},
		emptyRooms(){
			this.empty = (this.empty)?false:true;
		},
		// Copiar esta función en SidebarComponent.vue si hay algún cambio
        updateCurrentUsersByRooms(){
            let me = this;
            let tmp = me.arrayRooms;
            //Revisamos los usuarios conectados por room
            me.arrayRooms.forEach(e => {
                axios.get(me.$backendURL + '/api/room/getRoomsByUser/' + e.id)
                .then((roomsByUser) => {
                    if(roomsByUser.data.length == 0){
                        e.count_room = 0;
                    }else{
                        //Revisar si los usuarios están conectados
                        var count = 0;
                        roomsByUser.data.forEach( d => {
                            var result = me.connected_users.find( user => user.user_id === d.user_id );
                            if(result != undefined){
                                count++;
                            }
                        });
                        e.count_room = count;
                    }
                    me.arrayRooms = me.arrayRooms.sort(function(a, b){
                        if (a.count_room < b.count_room) {
                            return 1;
                        }
                        if (a.count_room > b.count_room) {
                            return -1;
                        }
                        return 0;
                    });
                }).catch(function (error) {
                    console.log('Error in RoomsComponent.vue in watch.current_room: ' + error);
                });
            });
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
				filtered = this.arrayRooms;
			}else{
				filtered = this.arrayRooms.filter(
                    m => m.count_room >= 1
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
		$('#showModalRooms').on('show.bs.modal', this.getRooms);
		//Cada vez que cambia el filtro de rooms vacíos
		$('#toggleRooms').on('touch.bs.toggle click.bs.toggle', this.emptyRooms);
	},
	watch:{
		login_user: function(value){
			if(value != 0){
				this.getRooms();
			}
		},
		connected_users: function(value){
			this.updateCurrentUsersByRooms();
		}
	}
}
</script>

<style scoped>
.modal-header span, #searchx, #smallText{
	font-size: 12px;
}
.btn-success {
    background-color: #51ce86 !important;
    border: 1px solid #51ce86 !important;
	color: #fff !important;
	min-height: 0px !important;
}
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