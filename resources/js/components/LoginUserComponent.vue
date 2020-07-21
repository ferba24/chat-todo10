<template>
<div class="modal fade" id="showModalLogin" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Login 2</h5>
				<small>Login by users</small>
			</div>
			<div class="modal-body">
				<form @submit.prevent="login">

					<div v-if="errors && errors.generic" class="text-danger">{{ errors.generic }}</div>

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
									<input type="password" name="password" v-model="fields.password" id="password" placeholder="Password" class="form-control"/>
									<div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>
								</div>
							</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary">Log in</button>
						</div>
					</div>
				</form>
				<br/>
				<div class="row">
					<div class="col-md-6 text-left">
						<a href="https://customers.todo10.com/xenforojose/index.php?register/" class="btn btn-default">Register Now</a>
					</div>
					<div class="col-md-6 text-right">
						<a href="https://customers.todo10.com/xenforojose/" class="btn btn-default">Close</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script>
export default {
	data(){
		return {
			fields: {},
			errors: {},
		}
	},
	methods:{
		login: function() {
			let url = this.$backendURL + '/api/login';
			this.errors = {};
			axios.post(url, this.fields).then(response => {
				if(response.data.success) {
					location.href = this.$backendURL + '/home/';
				} 
			})
			.catch(error => {
				if (error.response.status == 422) {
					this.errors = error.response.data.errors || {};
				} 
				if(error.response.status == 500) {
					this.errors = {"generic": "Incorrect password. Please try again."} || {};
				}
			});   
		}
	}
}
</script>
