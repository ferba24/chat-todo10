<template>

    <div class="card-body messages-content" style="overflow-y: auto;" id="scroll-messages-content">
        <div class="message_block" v-for="message in filterMessages" :key="message.id">
            <div class="report">
                <a href="javascript:void(0);" @click="reportMessage(message.id)"><i class="fas fa-flag"></i></a>
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
        <div class="modal fade" id="showModalReport" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Report message</h5>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="report">
                            <div v-if="errors && errors.generic" class="text-danger">
                                {{ errors.generic }}
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" v-if="!report_success">
                                        <label>Reason</label>
                                        <textarea name="reason" v-model="fields.reason" id="reason" class="form-control"></textarea>
                                        <div v-if="errors && errors.reason" class="text-danger">{{ errors.reason[0] }}</div>
                                    </div>
                                    <div v-if="report_success">
                                        Your report was sent
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="javascript:void(0);" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                <a href="javascript:void(0);" id="sendButton_report" @click="report" class="btn btn-primary" style="color:white !important;"> 
                                    <span v-if="!send_report">
                                        <i class="fas fa-bug"></i> Send report
                                    </span>
                                    <span v-if="send_report">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: table-cell !important;"></span>
                                        Loading...
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['messages', 'current_room', 'login_user_roles'],
    data() {
        return{
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            is_mod: false,
            send_report: false,
            id_message_report: -1,
            fields: {},
            errors: {},
            report_success: false,
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
        $('#showModalReport').on('hidden.bs.modal', this.setZIndex);
    },
    methods: {
        setZIndex(){
            document.getElementById('scroll-messages-content').style.zIndex = '1';
        },
        checkIsMod(){
            if(this.login_user_roles.includes(3) || this.login_user_roles.includes(4)){
                this.is_mod = true;
            }
        },
        reportMessage(id){
            let me = this;
            me.report_success = false;
            me.id_message_report = id;
            document.getElementById('sendButton_report').style.display="";
            //check freport exist
            let url = me.$backendURL + '/api/report/check';
			axios.post(url,{
                id: id,
                _token: me.csrf
            }).then(response => {
                if(response.data.count == 0){
                    document.getElementById('scroll-messages-content').style.zIndex = 'auto';
                    $("#showModalReport").modal("show");
                }else{
                    alert('You already reported this message');
                }
			})
			.catch(error => {
				if(error.response.status == 500) {
					me.send_report = false;
					me.errors = {"generic": "Error to check report: 500."} || {};
				}
			});
        },
        report(){
            let me = this;
            me.send_report = true;
			document.getElementById('sendButton_report').setAttribute("disabled", "disabled");

			let url = me.$backendURL + '/api/report/send';
			me.errors = {};
			axios.post(url, {
                message_id: me.id_message_report,
                reason: me.fields.reason,
                _token: me.csrf
            }).then(response => {
				me.send_report = false;
				document.getElementById('sendButton_report').style.display="none";

				if(response.data.success) {
					me.report_success = true;
					//$('#showModalReport').modal('hide');
				}else if(response.data.errors){
					me.errors = {"generic": response.data.errors[0].message} || {};
				}else{
					me.errors.generic = "Some error. Contact the webmaster.";
				}
			})
			.catch(error => {
				if (error.response.status == 422) {
					me.send_report = false;
					document.getElementById('sendButton_report').removeAttribute("disabled");
					me.errors = error.response.data.errors || {};
				} 
				if(error.response.status == 500) {
					me.send_report = false;
					document.getElementById('sendButton_report').removeAttribute("disabled");
					me.errors = {"generic": "Error 500."} || {};
				}
			});
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