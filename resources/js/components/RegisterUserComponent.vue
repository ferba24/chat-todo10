<template>
<div class="modal fade" id="showModal2" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Register User</h5>
		<small>Please fill out this form</small>
      </div>
	  
		  <div class="modal-body">
		  <form @submit.prevent="saveUser">
		  <div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input type="text" v-model="fields.username" class="form-control" name="username" aria-describedby="username" placeholder="User name" /> 			
					<div v-if="errors && errors.username" class="text-danger">{{ errors.username[0] }}</div>
					<div v-if="errors && errors.repeatUser" class="text-danger">{{ errors.repeatUser }}</div>
				  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input type="text" v-model="fields.email" class="form-control" name="email" aria-describedby="email" placeholder="Email" /> 			
					<div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
					<div v-if="errors && errors.repeatEmail" class="text-danger">{{ errors.repeatEmail }}</div>
				  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input type="password" v-model="fields.password" class="form-control" name="password" aria-describedby="password" placeholder="Password" /> 			
					<div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>
				  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6 text-right">
				<button type="submit" class="btn btn-success btn-block btn-sm active"  role="button">
					Register
				</button>
			</div>
			<div class="col-md-6 text-right">
				<a href="https://customers.todo10.com/xenforojose/" class="btn btn-default">Close</a>
			</div>
		  </div>
		  </form>
      </div>
    </div>
  </div>
</div>
</template>

<script>
    export default {
			data() {
				return {
				  fields: {},
				  errors: {},
				}
			},
			methods:{
				saveUser: function() {
					let url = this.$backendURL + '/api/saveUsers';
					this.errors = {};
					axios.post(url, this.fields).then(response => {
						if(response.data.success) {
							location.href = this.$backendURL + '/home/' + response.data.user.user_id;
						} else {
							let json = JSON.parse(response.request.response);
							this.errors = {"repeatUser": json.errors[0].message, "repeatEmail": json.errors[1].message} || {};
						}
					})
					.catch(error => {
						if (error.response.status == 422) {
						  this.errors = error.response.data.errors || {};
						} 
					});   
				}
			}
    }
</script>
