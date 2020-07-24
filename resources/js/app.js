/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('rooms-component', require('./components/RoomsComponent.vue').default);
Vue.component('login-user-component', require('./components/LoginUserComponent.vue').default);
Vue.component('private-component', require('./components/PrivateComponent.vue').default);
Vue.component('sidebar-component', require('./components/SidebarComponent.vue').default);
Vue.component('groupformchat-component', require('./components/GroupFormChatComponent.vue').default);
Vue.component('chatmessages-component', require('./components/ChatMessagesComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.prototype.$backendURL = "http://chat2.com-devel";

const app = new Vue({
    el: '#app-vue',
    data: {
        messages: [],
        current_room: 0,
        login_user: 0,
    },
    created() {
        //Escucha los mensajes de Pusher
        window.Echo.private('chat').listen('MessageSent', (e) => {
            console.log('echo hello!');
            this.messages.push({
                    message: e.message,
                    user: e.user,
                    room: e.room,
                    date: e.date
            });
        });
        //Revisa si el usuario está logeado
        axios.get(this.$backendURL + '/api/checkLogin').then(response => {
            if (response.data && response.data != '') {
                //TEST
                this.fetchMessages();
                
                this.login_user = response.data;

                this.checkRoomId();
            } else {
                $(document).ready(function() {
                    $("#showModalLogin").modal("show");
                });
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
        current_room: function (value) {
            /*axios.post(this.$backendURL + '/chat/create', message).then(response => {
                console.log(response.data);
            });*/
        }
    }
});