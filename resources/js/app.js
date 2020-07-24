require('./bootstrap');

window.Vue = require('vue');

Vue.component('rooms-component', require('./components/RoomsComponent.vue').default);
Vue.component('login-user-component', require('./components/LoginUserComponent.vue').default);
Vue.component('private-component', require('./components/PrivateComponent.vue').default);
Vue.component('sidebar-component', require('./components/SidebarComponent.vue').default);
Vue.component('groupformchat-component', require('./components/GroupFormChatComponent.vue').default);
Vue.component('chatmessages-component', require('./components/ChatMessagesComponent.vue').default);
Vue.component('navbar-component', require('./components/NavbarComponent.vue').default);

Vue.prototype.$backendURL = "http://chat2.com-devel";

const app = new Vue({
    el: '#app-vue',
    data: {
        messages: [],
        current_room: 0,
        login_user: 0,
        sound_active: true,
    },
    mounted() {
        //Escucha los mensajes de Pusher
        window.Echo.private('chat').listen('MessageSent', (e) => {
            this.messages.push({
                    message: e.message,
                    user: e.user,
                    room: e.room,
                    date: e.date
            });
            this.sounds();
        });
    },
    created() {
        //Revisa si el usuario está logeado
        axios.get(this.$backendURL + '/api/checkLogin').then(response => {
            if (response.data && response.data != '') {
                //TEST
                this.fetchMessages();
                
                this.login_user = response.data;

                this.checkRoomId();
            } else {
                $("#showModalLogin").modal("show");
            }
        });
    },
    methods: {
        //PRUEBA
        fetchMessages() {
            axios.get(this.$backendURL + '/chat/getMessages').then(response => {
                this.messages = response.data;
            });
        },
        //Añade un mensaje al chat grupal
        addMessage(message) {
            this.messages.push(message);
            axios.post(this.$backendURL + '/chat/create', message).then(response => {
                console.log(response.data);
            });
        },
        //Cambia estatus de activo o no el sonido
        setSoundActive(obj) {
            this.sound_active = obj.sound;
        },
        checkRoomId() {
            axios.get(this.$backendURL + '/api/checkRoom').then(response => {
                if (response.data && response.data != '') {
                    this.current_room = response.data;
                } else {
                    this.current_room = 1;
                }
            });
        },
        //Establece el ID del usuario logeado
        setLoginUser(user) {
            this.login_user = user.user_id;
        },
        sounds() {
            let me = this;
            //Reproduce el audio cuando llega un mensaje
            /*console.log('this.sound_active: ' + (me.sound_active));
            if (me.sound_active) {
                let audio = new Audio(me.$backendURL + "/js/sounds/bell_ring.mp3");
                audio.play();
            }*/
        }
    },
    watch: {
        login_user: function (value) {
            if (value == 0) {
                $("#showModalLogin").modal("show");
            } else {
                this.checkRoomId();

                $("#showModalRooms").modal("show");
            }
        },
        messages: function (value) {

        },
        current_room: function (value) {
            /*axios.post(this.$backendURL + '/chat/create', message).then(response => {
                console.log(response.data);
            });*/
        }
    }
});