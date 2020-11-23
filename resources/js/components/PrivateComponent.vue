<template>
	<div class="chat-private">
        <div class="row pt-3 align-items-end">
            <div class="chat-main" v-for="chat in chats_private" :key="chat.user_id">
                <div :class="'col-md-12 chat-header rounded-top bg-primary text-white hide-chat-box-' + chat.user_id" @click="hide_chat(chat.user_id)">
                    <div class="row">
                        <div class="col-md-6 username pl-2">
                            <h6 class="m-0">{{ chat.name }}</h6>
                        </div>
                        <div class="col-md-6 options text-right pr-2">
							<a href="javascript:void(0);" @click="close_chat(chat.user_id)">
                            	<i class="far fa-times-circle"></i>
							</a>
                        </div>
                    </div>
                </div>
                <div class="chat-content">
                    <div class="col-md-12 chats border">
                        <ul class="p-0 m-0" style="overflow-y:auto; width:100%; height:100%;" :id="'messages-ul-'+chat.user_id">
                            <li class="pl-2 pr-2 bg-primary rounded text-white text-center send-msg mb-1" v-for="message in chat.messages" :key="message.id">
                                {{ message.text }}
                            </li>
                            <!--<li class="pl-2 pr-2 bg-primary rounded text-white text-center send-msg mb-1">
                                hiii
                            </li>
                            <li class="p-1 rounded mb-1">
                                <div class="receive-msg">
                                    <img src="http://nicesnippets.com/demo/image1.jpg">
                                    <div class="receive-msg-desc  text-center mt-1 ml-1 pl-2 pr-2">
                                        <p class="pl-2 pr-2 rounded">hello</p>
                                    </div>
                                </div>
                            </li>
                            <li class="pl-2 pr-2 bg-primary rounded text-white text-center send-msg mb-1">
                                how are you ???
                            </li>
                            <li class="p-1 rounded mb-1">
                                <div class="receive-msg">
                                    <div class="receive-msg-img">
                                        <img src="http://nicesnippets.com/demo/image1.jpg">
                                    </div>
                                    <div class="receive-msg-desc rounded text-center mt-1 ml-1 pl-2 pr-2">
                                        <p class="mb-0 mt-1 pl-2 pr-2 rounded-top rounded-right">I'm fine !!!</p>
                                        <p class="mb-0 mt-1 pl-2 pr-2 rounded-bottom rounded-right">Where are you ?</p>
                                    </div>
                                </div>
                            </li>
                            <li class="pl-2 pr-2 bg-primary text-white text-center send-msg mb-1 rounded-top rounded-left">
                                at california
                            </li>
                            <li class="pl-2 pr-2 bg-primary text-white text-center send-msg mb-1 rounded-bottom rounded-left">
                                and where are you ?
                            </li>
                            <li class="p-1 rounded  mb-1">
                                <div class="receive-msg">
                                    <img src="http://nicesnippets.com/demo/image1.jpg">
                                    <div class="receive-msg-desc rounded text-center mt-1 ml-1 pl-2 pr-2">
                                        <p class="pl-2 pr-2 rounded">now i'm at new york city</p>
                                    </div>
                                </div>
                            </li>
                            <li class="pl-2 pr-2 bg-primary rounded text-white text-center send-msg mb-1">
                                Ok
                            </li>-->
                        </ul>
                    </div>
                    <div class="col-md-12 message-box border pl-2 pr-2 border-top-0">
                        <div class="form-row">
                            <div class="col-9">
                                <input id="message-text" type="text" class="pl-0 pr-0 w-100" placeholder="Type a message..." @keyup.enter="send_m(chat.user_id)" />
                            </div>
                            <div class="col-3">
                                <input class="btn" type="submit" value="Send" @click="send_m(chat.user_id)" />
                            </div>
                        </div>
                        <!--<div class="tools">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                            <i class="fa fa-telegram" aria-hidden="true"></i>
                            <i class="fa fa-bell" aria-hidden="true"></i>
                            <i class="fa fa-meh-o" aria-hidden="true"></i>
                            <i class="fa fa-paperclip" aria-hidden="true"></i>
                            <i class="fa fa-gamepad" aria-hidden="true"></i>
                            <i class="fa fa-camera" aria-hidden="true"></i>
                            <i class="fa fa-folder" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-o-up m-0" aria-hidden="true"></i>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
	props: ['chats_private', 'login_user'],
	mounted(){
        
	},
	methods: {
		hide_chat(id){
			$('.hide-chat-box-' + id).parent().children(".chat-content").slideToggle();
		},
		close_chat(id){
            this.$emit('closeprivatechat_send', {
                user_id: id
            });
        },
        send_m(id){
            var text = document.getElementById('message-text').value;
            if(text.length > 0 && this.login_user != 0){
                this.$emit('messagesentprivate', {
                    message: text,
                    user_id: id
                });
                document.getElementById('message-text').value = "";
            }
        }
	},
	watch:{
        chats_private: {
            handler(val){
                setInterval(function(){
                    var objDiv = document.getElementById("messages-ul-"+val[0].user_id);
                    if(objDiv != null){
                        objDiv.scrollTop = objDiv.scrollHeight + 25; //25 del tamaño del mensaje a poner
                    }
                },1000);
            },
            deep: true //Forzar que todo la variable si cambia hace un watch
        }
	}
}
</script>