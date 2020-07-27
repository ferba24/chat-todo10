<template>
<div class="card-body messages-content" style="overflow-y: auto;" id="scroll-messages-content">
    <div v-for="message in messages" :key="message.id">
        <p class="msg">[{{ message.user | get_username }}] {{ message.date | date_format }}: <span v-html="message.message"></span></p>
    </div>
</div>
    
</template>

<script>
export default {
    props: ['messages'],
    data(){
        return{
            size: 0,
        }
    },
    filters:{
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
        /*messages: function(val){
            if(this.messages.length != this.size){
                var objDiv = document.getElementById("scroll-messages-content");
                objDiv.scrollTop = objDiv.scrollHeight + 101;
                this.size = this.messages.length;
            }
        }*/
    },
    mounted(){
        this.size = this.messages.length;
    },
    updated(){
        var objDiv = document.getElementById("scroll-messages-content");
        objDiv.scrollTop = objDiv.scrollHeight;
    }
};
</script>

<style scoped>
#scroll-messages-content .msg{
    display: flex;
}
p{
    margin: 0px !important;
}
.msg>span{
    margin-left: 5px;
}
</style>