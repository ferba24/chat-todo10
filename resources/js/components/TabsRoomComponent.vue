<template>
<ul class="nav nav-pills nav-stacked">
    <li class="nav-item"><a href="javascript:void(0)" @click="changeRoom(1)" :class="{'active': (current_room == 1)}">General&nbsp;&nbsp;&nbsp;</a></li>

    <li v-for="room in rooms" :key="room.id" class="nav-item">
        <a :class="{'active': (current_room == room.id)}" href="javascript:void(0)" @click="changeRoom(`${room.id}`)">
        {{ room.room_name }} &nbsp;&nbsp;&nbsp;
        <span class="badge badge-light" id="badge" style="cursor: pointer" title="Exit room" @click="exitRoom(`${room.id}`)"><i class="fas fa-times"></i></span>
        </a>
    </li>

</ul>
</template>

<script>
export default {
    props: ['rooms', 'current_room'],
    data(){
		return{
			csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
		}
	},
    methods: {
        changeRoom(id){
            let me = this;
			axios.post(me.$backendURL + '/api/room/select', {
				_token: me.csrf,
				room_id: id,
			}).then((response) => {
				if(response.data.success){
					me.$emit('current_roomsent', {
                        room_id: parseInt(id)
                    });
				}else{
					console.dir(response.data.error);
				}
			}).catch(function (error) {
				console.log('Error TabsRoomComponent.vue in selectedRoom(): ' + error);
			});
        },
        exitRoom(id){
            let me = this;
            axios.post(me.$backendURL + '/api/room/exitRoom', {
				_token: me.csrf,
				room_id: id,
			}).then((response) => {
				if(response.data.success){
					me.$emit('rooms_sent', {
						room_id: parseInt(id)
					});
				}else{
					console.dir(response.data.error);
				}
			}).catch(function (error) {
				console.log('Error TabRoomController.vue: ' + error);
			});
        }
    }
}
</script>