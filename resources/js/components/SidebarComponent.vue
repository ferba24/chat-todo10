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
export default{
    data(){
        return{
            users_count: 0,
            rooms_count: 0,
            arrayUsers: [],
            arrayRooms: [],
            term_room: "",
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
			axios.get(this.$backendURL + '/room/getRoom')
			.then((rooms) => {
                me.arrayRooms = rooms.data;
                me.rooms_count = me.arrayRooms.length;
			}).catch(function (error) {
				console.log('Error in RoomsController.vue: ' + error);
            });
		},
        selectedRoom(id) {
			location.href = this.$backendURL + '/room/selected/' + id;
        },
        changeTab(e){
            $('#myTab a[href="' + $(e.target).attr('href') + '"]').tab('show');
        }
    },
    mounted(){
        this.getRooms();

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
</style>