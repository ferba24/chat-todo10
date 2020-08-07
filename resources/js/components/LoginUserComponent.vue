<template>
<div class="modal fade" id="showModalLogin" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Login</h5>
				<small>Login by users</small>
			</div>
			<div class="modal-body">
				<form @submit.prevent="login">
					<div v-if="errors && errors.generic" class="text-danger">
						{{ errors.generic }}
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Your name or email address</label>
								<input type="text" name="username" v-model="fields.username" id="username" placeholder="Your name or email address" class="form-control"/>
								<div v-if="errors && errors.username" class="text-danger">{{ errors.username[0] }}</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Password</label>
								<input type="password" name="password" v-model="fields.password" id="password" placeholder="********" class="form-control"/>
								<div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button id="sendButton" type="submit" class="btn btn-primary">
							<span v-if="!send_login">
								Log in
							</span>
							<span v-if="send_login">
								<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
								Loading...
							</span>
							</button>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="https://customers.todo10.com/xenforojose/index.php?register/" class="btn btn btn-secondary">Register Now</a>
				<a href="https://customers.todo10.com/xenforojose/" class="btn btn-secondary">Close</a>
			</div>
		</div>
	</div>
</div>
</template>

<script>
export default {
	data(){
		return {
			send_login: false,
			fields: {},
			errors: {},
		}
	},
	methods:{
		login: function() {
			this.send_login = true;
			document.getElementById('sendButton').setAttribute("disabled", "disabled");

			let url = this.$backendURL + '/api/login';
			this.errors = {};
			axios.post(url, this.fields).then(response => {
				this.send_login = false;
				document.getElementById('sendButton').removeAttribute("disabled");

				if(response.data.success) {
					//Envía el ID del usuario conectado
					this.$emit('login_usersent', {
						user_id: response.data.user.user_id,
						timezone: response.data.user.timezone
					});
					$('#showModalLogin').modal('hide');
				}else if(response.data.errors){
					this.errors = {"generic": response.data.errors[0].message} || {};
				}else{
					this.errors.generic = "Some error. Contact the webmaster.";
				}
			})
			.catch(error => {
				if (error.response.status == 422) {
					this.send_login = false;
					document.getElementById('sendButton').removeAttribute("disabled");
					this.errors = error.response.data.errors || {};
				} 
				if(error.response.status == 500) {
					this.send_login = false;
					document.getElementById('sendButton').removeAttribute("disabled");
					this.errors = {"generic": "Error 500."} || {};
				}
			});
		}
	}
}
</script>
