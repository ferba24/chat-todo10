<template>
<div class="card-body messages-content" style="overflow-y: auto;" id="scroll-messages-content">
    <div class="message_block" v-for="message in filterMessages" :key="message.id">
        <div class="report">
            <a href="#"><i class="fas fa-flag"></i></a>
        </div>
        <p class="msg">[{{ message.user | get_username }}]</p>
        <div class="date" v-if="is_mod">
            <a href="#">{{ message.date }}</a> :
        </div>
        <div class="date" v-if="!is_mod">
            {{ message.date }} :
        </div>
        <span v-html="message.message"></span>
    </div>
</div>
    
</template>

<script>
export default {
    props: ['messages', 'current_room', 'login_user_roles'],
    data() {
        return{
            is_mod: false
        }
    },
    filters: {
        get_username: function(value){
            let parse = JSON.parse(value);
            return parse.username;
        },
    },
    watch: {
        login_user_roles: function(value){
            this.checkIsMod();
        }
    },
    mounted() {

    },
    methods: {
        checkIsMod(){
            if(this.login_user_roles.includes(3) || this.login_user_roles.includes(4)){
                this.is_mod = true;
            }
        }
    },
    updated() {
        var objDiv = document.getElementById("scroll-messages-content");
        objDiv.scrollTop = objDiv.scrollHeight;
    },
    computed: {
        filterMessages: function(){
            let me = this;
			//Se filtra dependiendo del room en el que esté
            let filtered = me.messages.filter(
                m => m.room == me.current_room
            );
			return filtered;
		}
    }
};
</script>