<template>
<form>
    <!--<input type="hidden" name="_token" value="{{ csrf_token() }}"/>-->
    <div class="row">
        <div class="col-md-10">
            <textarea class="content" name="text" id="text" placeholder="Messages" autofocus></textarea>
        </div>
        <div class="col-md-2 justify-content-center align-self-center">
            <button type="button" class="btn btn-primary form-control" name="sendMessage" id="sendMessage" @click="sendMessage">Send</button>
            {{ newMessage }}
        </div>
    </div>
</form>
</template>
<script>
export default{
    data(){
        return {
            newMessage: '',
            room: -1,
            user: 0,
        }
    },
    methods: {
        sendMessage() {
            this.user = document.getElementById('user_id').value;
            if(this.room != 0 && this.user != 0){
                this.$emit('messagesent', {
                    room: this.room,
                    user: this.user,
                    message: this.newMessage
                });
                this.newMessage = '';
                tinymce.get('text').setContent('');
            }else{
                console.log("not sent message");
            }
        }
    },
    mounted(){
        let me = this;
        tinymce.init({
			menubar: false,
			selector:'#text',
			height: 50,
			toolbar: 'bold italic underline',
			setup: function (ed) {
				// Se puso el setup para evitar el enter en el chat
				ed.on('keydown',function(e) {
					if(e.keyCode == 13){
						me.sendMessage();
						e.preventDefault();
					}
                });
                ed.on("keyup", function(){
                    me.newMessage = tinyMCE.activeEditor.getContent();
                });
			}
		});
    }
}
</script>