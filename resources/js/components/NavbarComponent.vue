<template>
<nav id="card-box-navbar" class="navbar navbar-expand-md navbar-light bg-white shadow-lg navbar-custom pr-0 pl-0" >
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto d-none d-sm-none d-md-block">
                <li class="dropdown" id="user-content-me3">	
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="text-decoration: none;">
                        <span class="avatar avatar--xxs avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
                        <span class="avatar-u1-s">
                            {{ user.username | capitalize }}
                        </span> 
                    </span>
                        <span class="font-weight-bold" style="padding-left: 5px">{{ user.username }}</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0);" class="nav-link" data-toggle="modal" data-target="#showModalRooms"><i class="fas fa-home"></i> ROOMS</a></li>
                        <li><a href="javascript:void(0);" class="nav-link" v-on:click="logout"><i class="fas fa-sign-out-alt"></i> LOGOUT</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav mr-auto d-block d-sm-block d-md-none">
                <li><a href="javascript:void(0);" class="nav-link" data-toggle="modal" data-target="#showModalRooms"><i class="fas fa-home"></i> ROOMS</a></li>
                <li><a href="javascript:void(0);" class="nav-link" v-on:click="logout"><i class="fas fa-sign-out-alt"></i> LOGOUT</a></li>
            </ul>
        </div>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto primary-menu">
            <!-- Authentication Links -->
            <li class="nav-item rooms-list mx-2 mx-md-0">
                <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#showModalRooms">
                    <i class="fas fa-home"></i><span class="ml-md-2">ROOMS LIST</span>
                </a>
            </li>
            <li class="nav-item private-msg mx-2 mx-md-0">
                <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#showModalPrivate">
                    <i class="far fa-comment-dots"></i><span class="ml-md-2">PRIVATE MSG</span>
                </a>
            </li>
            <li class="nav-item pr-0 mr-0 sounds mx-2 mx-md-0">
                <a class="nav-link">
                    <i class="fas fa-music"></i><span class="ml-md-2">SOUNDS</span>
                    <div id="toggleSound">
                        <input type="checkbox" checked id="toggleSound_input" data-toggle="toggle"/>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</nav>
</template>

<script>
export default {
    props: ['login_user', 'sound_active'],
    data(){
		return{
            user: {},
		}
    },
    methods: {
        getCurrentUser(){
            let me = this;
            axios.get(me.$backendURL + '/api/user/getCurrent')
            .then((response) => {
                me.user = JSON.parse(response.data);
            }).catch(function (error) {
                console.log('Error in NavbarController.vue: ' + error);
            });
        },
        changeSoundOption(){
            this.$emit('sound_activesent',{
                sound: (this.sound_active)?false:true
            });
        },
        logout(){
            window.location.href = this.$backendURL + "/home/logout";
        }
    },
    filters: {
		capitalize: function (value){
			if(!value) return ''
			return value.toString().substring(0,1).toUpperCase();

		}
	},
    watch: {
        login_user: function(value){
            if(value != 0){
                this.getCurrentUser();
            }else{
                this.user = {};
            }
        }
    },
    mounted(){
        $('#toggleSound').on('touch.bs.toggle click.bs.toggle', this.changeSoundOption);
    }
}
</script>