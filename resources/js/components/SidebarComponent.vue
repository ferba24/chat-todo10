<template>
<div class="card border-0">
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
                <div class="row checkbox">
                    <label class="col-md-4 text-center"><input type="checkbox" v-model="show_admins"> Admins</label>
                    <label class="col-md-4 text-center"><input type="checkbox" v-model="show_mods"> Mods</label>
                    <label class="col-md-4 text-center"><input type="checkbox" v-model="show_others"> Others</label>
                </div>
            </div>
            <div class="card-body" style="overflow-y: auto; background-color: white;">
                <ul style="list-style: none;" id="users-list">
                    <li v-for="user in filterUsers" :key="user.id" style="padding-bottom: 5px;">
                        <div id="user-content">
                            <div class="row">
                                <div class="col-md-2 text-center pr-0 pl-0">
                                    <span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
                                        <span class="avatar-u1-m">{{ user.name | capitalize }}</span> 
                                    </span>
                                </div>
                                <div class="col-md-10 pr-0 pl-0">
                                    {{ user.name }}
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
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            show_admins: true,
            show_mods: true,
            show_others: true,
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
			let me = this;
			axios.post(me.$backendURL + '/api/room/select', {
				_token: this.csrf,
				room_id: id,
			}).then((response) => {
				if(response.data.success){
					this.$emit('current_roomsent', {
						room_id: parseInt(response.data.room_id)
					});
				}else{
					console.dir(response.data.error);
				}
			}).catch(function (error) {
				console.log('Error SidebarComponent.vue in selectedRoom(): ' + error);
			});
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
        // Copiar esta función en RoomsComponent.vue si hay algún cambio
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
            let filtered_tu = [], filtered_sa = [], filtered_sm = [], filtered_so = [];
            if(this.show_admins && this.show_mods){
                filtered_sa = this.arrayUsers.filter(
                    m => m.role.includes(3) || m.role.includes(4)
                );
            }else{
                if(this.show_admins){
                    filtered_sa = this.arrayUsers.filter(
                        m => m.role.includes(3)
                    );
                }
                if(this.show_mods){
                    filtered_sm = this.arrayUsers.filter(
                        m => m.role.includes(4)
                    );
                }
            }
            if(this.show_others){
                filtered_so = this.arrayUsers.filter(
                    m => m.role.length <= 0
                );
            }
            filtered_tu = filtered_sa.concat(filtered_sm);
            filtered_tu = filtered_tu.concat(filtered_so);


            //Se filtra por el término buscado
            if(this.term_user != ""){
                filtered_tu = filtered_tu.filter(
                    m => m.name.toLowerCase().indexOf(this.term_user) > -1
                );
            }
			return filtered_tu;
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
            let me = this;
            me.users_count = value.length;
            me.updateCurrentUsersByRooms();
            me.$emit('connected_userssent', {
                users: me.arrayUsers
            });
        },
        current_room: function (value){
            this.updateCurrentUsersByRooms();
        },
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
    background-color: #eee; 
    padding-top: 5px;
    padding-bottom: 5px;
}
.row.checkbox label{
    margin-bottom: 0px !important;
}
.row.checkbox label input{
    vertical-align: middle;
}
#user-content{
    cursor:pointer;
}
</style>