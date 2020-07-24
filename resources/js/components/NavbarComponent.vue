<template>
<nav id="card-box-navbar" class="navbar navbar-expand-md navbar-light bg-white shadow-lg navbar-custom" >
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">	
                <li  class="dropdown" id="user-content-me3">	
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="text-decoration: none;">
                        <span class="avatar avatar--xxs avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
                        <span class="avatar-u1-s">
                            {{ user.username | capitalize }}
                        </span> 
                    </span>
                        <small style="padding-left: 5px">{{ user.username }}</small>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="nav-link" data-toggle="modal" data-target="#showModalRooms"><small>ROOMS</small></a></li>
                        <li><a href="<!-- LOGOUT ROUTE -->" class="nav-link"><small>LOGOUT</small></a></li>
                    </ul>
                </li>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item">
                    <a class="nav-link" href="<!-- URL CHAT -->" style="color: white">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#showModalRooms" style="color: white">
                        <small>ROOMS LIST</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#showModalPrivate" style="color: white">
                        <i class="far fa-comment-dots"></i>
                        <small>PRIVATE MSG</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: white">
                        <i class="fas fa-music"></i>
                        <small>SOUNDS</small>
                    </a>
                </li>
                <li class="nav-item">
                    <div id="toggleSound">
                        <input type="checkbox" checked id="toggleSound_input" data-toggle="toggle"/>
                    </div>
                    {{ sound_active }}
                </li>
            </ul>
        </div>
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