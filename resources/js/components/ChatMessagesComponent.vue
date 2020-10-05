<template>
<div class="card-body messages-content" style="overflow-y: auto;" id="scroll-messages-content">
    <div class="message_block" v-for="message in filterMessages" :key="message.id">
        <p class="msg">[{{ message.user | get_username }}]</p>
        <div class="date" v-if="is_mod">
            <a href="#">{{ message.date | date_format }}</a> :
        </div>
        <div class="date" v-if="!is_mod">
            {{ message.date | date_format }} :
        </div>
        <span v-html="message.message"></span>
        <div class="report">
            <a href="#"><i class="fas fa-flag"></i></a>
        </div>
    </div>
</div>
    
</template>

<script>
export default {
    props: ['messages', 'current_room', 'login_user_roles'],
    data() {
        return{
            
        }
    },
    filters: {
        get_username: function(value){
            let parse = JSON.parse(value);
            return parse.username;
        },
        date_format: function(value){
            let date = new Date(value);
            return date.getHours()+':'+(date.getMinutes()<10?'0':'') + date.getMinutes();
        }
    },
    watch: {
        
    },
    mounted() {

    },
    methods: {
        
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