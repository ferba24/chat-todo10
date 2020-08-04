<template>
<div class="card">
    <div id="sidebar-header" class="card-header">
        <ul class="nav nav-pills nav-stacked" id="myTab">
            <li><a href="#users" data-toggle="tab"  class="active">Users &nbsp;<span class="badge badge-pill badge-dark"><div id="users-count">{{ users_count }}</div></span></a></li>
            <li><a href="#rooms" data-toggle="tab" >Rooms &nbsp;<span class="badge badge-pill badge-dark">{{ rooms_count }}</span></a></li>
        </ul>
    </div>			
    <div class="tab-content">
        <div id="users" class="tab-pane active">			
            <div id="search-wrapper">
                <input type="text" class="form form-control remove-rounded" name="search" id="search" placeholder="Search user ..." v-model="term_user"/>
                <i class="fa fa-search"></i>
            </div>
            <div class="container">
                <div class="row" style="background-color: #eee; padding-top: 10px;">
                    <div class="col-md-12">
                        <div class="row checkbox">
                            <label class="col-md-4 text-center"><input type="checkbox" checked="true"> Admins</label>
                            <label class="col-md-4 text-center"><input type="checkbox" checked="true"> Mods</label>
                            <label class="col-md-4 text-center"><input type="checkbox" checked="true"> Others</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y: auto; background-color: white;">
                <ul style="list-style: none;" id="users-list">
                    <li v-for="user in filterUsers" :key="user.id" style="padding-bottom: 5px;">
                        <div id="user-content">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
                                        <span class="avatar-u1-m">{{ user.name | capitalize }}</span> 
                                    </span>
                                </div>
                                <div class="col-md-9">
                                    {{ user.name }}<br>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>								
            </div>
        </div>
        <div id="rooms" class="tab-pane fade">
            <div id="search-wrapper-rooms">
                <input type="text" class="form form-control remove-rounded" placeholder="Search room ..." v-model="term_room"/>
                <i class="fa fa-search"></i>
            </div>
            <div id="sidebar-block" class="card-body" style="overflow-y: auto;">	
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td class="text-center">Name</td>
                            <td class="text-center">Users</td>
                            <td class="text-center">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="room in filterRooms" :key="room.id">
                            <td>{{ room.room_name }}</td>
                            <td class="text-center">{{ room.count_room }}</td>
                            <td class="text-center"><a class="btn btn-success btn-sm active" @click="selectedRoom(`${room.id}`)"  role="button"><i class="fas fa-door-open"></i> Enter</a></td>
                        </tr>
                    </tbody>	
                </table>
            </div> <!-- .card-body -->
        </div> <!-- #menu1 -->
    </div><!-- .tab-content -->
</div><!-- .card -->
</template>
<script>
export default {
    props: ['login_user', 'current_room', 'rooms'],
    data(){
        return{
            users_count: 0,
            rooms_count: 0,
            arrayUsers: [],
            arrayRooms: [],
            term_room: "",
            term_user: "",
        }
    },
    filters: {
		capitalize: function (value){
			if(!value) return ''
			return value.toString().substring(0,1).toUpperCase();
        }
    },
    methods:{
        getRooms() {
			let me = this;
			axios.get(me.$backendURL + '/api/room/getRooms')
			.then((rooms) => {
                me.arrayRooms = rooms.data;
                me.rooms_count = me.arrayRooms.length;
                me.updateCurrentUsersByRooms();
			}).catch(function (error) {
				console.log('Error in SidebarComponent.vue in getRooms: ' + error);
            });
		},
        selectedRoom(id) {
			//location.href = this.$backendURL + '/room/selected/' + id;
        },
        changeTab(e){
            $('#myTab a[href="' + $(e.target).attr('href') + '"]').tab('show');
        },
        echoJoin(){
            Echo.join('online')
                .here(users => {
                    this.users_count = users.length;
                    this.arrayUsers = users;
                }).joining(user => {
                    this.arrayUsers.push(user);
                }).leaving(user => {
                    this.arrayUsers = this.arrayUsers.filter(u => (u.user_id !== user.user_id))
                });
        },
        // Copiar esta función en RoomsComponent.vue revisando que el arrayUsers esté disponible
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
                            var result = me.arrayUsers.find( user => user.user_id === d.user_id );
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
                    console.log('Error in SidebarComponent.vue in watch.current_room: ' + error);
                });
            });
        }
    },
    mounted(){
        if(this.login_user != 0){
            this.echoJoin();

            this.getRooms();
        }

        $('a[data-toggle="tab"]').on('show.bs.tab', this.changeTab(this));

        //Obtener tamaños y establecer el tamaño del bloque del sidebar
        let sizeNet = 35
            + document.getElementById('sidebar-header').getBoundingClientRect().height
            + document.getElementById('card-box-navbar').getBoundingClientRect().height;
        
        document.getElementById('sidebar-block').style = "max-height: calc( 100vh - " + sizeNet + "px );overflow-y: auto;";
    },
    computed:{
        filterRooms: function(){
            let filtered = this.arrayRooms;
            //Se filtra por el término buscado
			if(this.term_room != ""){
                filtered = filtered.filter(
                    m => m.room_name.toLowerCase().indexOf(this.term_room) > -1
                );
            }
			return filtered;
        },
        filterUsers: function(){
            let filtered = this.arrayUsers;
            //Se filtra por el término buscado
			if(this.term_user != ""){
                filtered = filtered.filter(
                    m => m.name.toLowerCase().indexOf(this.term_user) > -1
                );
            }
			return filtered;
        }
    },
    watch: {
        login_user: function (value) {
            if (value != 0) {
                this.echoJoin();

                this.getRooms();
            }else{
                this.arrayRooms = [];
            }
        },
        arrayUsers: function (value){
            this.users_count = value.length;
            this.updateCurrentUsersByRooms();
        },
        current_room: function (value){
            this.updateCurrentUsersByRooms();
        }
    }
}
</script>

<style scoped>
table td{
    font-size: 12px;
    line-height: 18px;
    padding: 3px 5px;
}
#sidebar-block{
    padding-top: 1px;
}
.row.checkbox{
    font-size: 12px;
}
#user-content{
    cursor:pointer;
}
</style>