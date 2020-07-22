<template>
<div class="card-body messages-content" style="overflow-y: auto;" id="scroll-messages-content">
    <div v-for="message in messages" :key="message.id">
        <p>{{ message.user }}</p>
        <p>{{ message.message }}</p>
        <p>{{ message.room }}</p>
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