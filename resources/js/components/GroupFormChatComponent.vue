<template>
<form>
    <!--<input type="hidden" name="_token" value="{{ csrf_token() }}"/>-->
    <div class="row">
        <div class="col-md-10">
            <textarea class="content" name="text" id="text" placeholder="Messages" autofocus></textarea>
        </div>
        <div class="col-md-2 justify-content-center align-self-center">
            <button type="button" class="btn btn-primary form-control" name="sendMessage" id="sendMessage" @click="sendMessage">Send</button>
        </div>
    </div>
</form>
</template>
<script>
export default{
    data(){
        return {
            newMessage: '',
        }
    },
    methods: {
        sendMessage() {
            if(this.current_room != 0 && this.login_user != 0){
                this.$emit('messagesent', {
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
			toolbar: 'bold italic underline',
			setup: function (ed) {
                ed.on('load', function(e) {
                    //Obtener tamaños y establecer el tamaño del chat
                    let sizeNet = document.getElementById('card-box-navbar').getBoundingClientRect().height
                        + document.getElementById('card-box-form').getBoundingClientRect().height
                        + 20; //20 es para hacer un fix correcto
                    document.getElementById('card-box-messages').style = "max-height: calc( 100vh - " + sizeNet + "px );";

                    //Borrar estas líneas, ya que es de prueba
                    var objDiv = document.getElementById("scroll-messages-content");
                    objDiv.scrollTop = objDiv.scrollHeight;
                    /** */
                });
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