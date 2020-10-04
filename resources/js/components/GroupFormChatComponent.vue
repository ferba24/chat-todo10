<template>
    <div class="row mr-0 ml-0">
        <div class="col-md-11 pr-0 pl-0">
            <textarea class="content" name="text" id="text" placeholder="Messages" autofocus></textarea>
        </div>
        <div class="col-md-1 justify-content-center align-self-end pr-1 pl-1">
            <button type="button" class="btn btn-primary form-control" name="sendMessage" id="sendMessage" @click="sendMessage">Send</button>
        </div>
    </div>
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
            this.newMessage = tinyMCE.activeEditor.getContent();
            if(this.current_room != 0 && this.login_user != 0 && this.newMessage != ""){
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
            plugins: 'textcolor',
            toolbar: 'bold italic underline forecolor',
			setup: function (ed) {
                ed.on('load', function(e) {
                    //Ocultar el copyright de tinymce
                    //document.getElementById('mceu_9-body').style.display="none";

                    //Obtener tamaños y establecer el tamaño del chat
                    let sizeNet = document.getElementById('card-box-navbar').getBoundingClientRect().height
                        + document.getElementById('card-box-form').getBoundingClientRect().height;
                    if(sizeNet >= 200){
                        document.getElementById('card-box-messages').style = "max-height: calc( 100vh - 200px ); height: 100%;";
                    }else{
                        document.getElementById('card-box-messages').style = "max-height: calc( 100vh - " + sizeNet + "px ); height: 100%;";
                    }

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
                /*ed.on("keyup", function(){
                    me.newMessage = tinyMCE.activeEditor.getContent();
                });
                ed.on('click', function(e) {
                    me.newMessage = tinyMCE.activeEditor.getContent();
                });*/
			}
		});
    }
}
</script>