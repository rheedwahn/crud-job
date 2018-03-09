<template>
	<div class="container">
		<div class="row">
			<article class="span8">
				<h3> Student Login Page </h3>
				<div class="inner-1">
					<form id="contact-form" class="login" autocomplete="off" @submit.prevent="login" method="post">
						<div>
							<label class="matric">
								<input name="matric" v-model="matric" v-validate="{required : true, regex: /^([0-9]+)$/, min:11, max:11}" :class="{'input': true, 'is-danger': errors.has('matric') }" type="text" placeholder="Matriculation Number">
								<span v-show="errors.has('matric')" class="help is-danger fa fa-warning">{{ errors.first('matric') }}</span>
							</label>
						</div>
						<div >
							<label class="password">
								<input name="password" v-model="password" class="form-control" v-validate="'required|min:5'" :class="{'input': true, 'is-danger': errors.has('password') }" type="password" placeholder="Password">
								<span v-show="errors.has('password')" class="help is-danger fa fa-warning">{{ errors.first('password') }}</span>
							</label>
						</div>
						<div class="span6" style="margin-left: 170px">
							<button type="submit" class="btn-primary">
							Login
							</button>
						</div>
					</form>
				</div>
			</article>
			<article class="span4">
				<div id="success">hey</div>
			</article>
		</div>
	</div>
</template>

<script>
import axios from 'axios'
import swal from 'bootstrap-sweetalert'
export default {
	data(){
		return {
			matric: null,
			password: null
		}
	},
	methods: {
		login() {
			this.$validator.validateAll().then(result => {
				if (result) {
					axios.post('auth/login', {matric:this.matric,password:this.password})
					.then(response=>{
						let token = response.data.token;
						let base64Url = token.split('.')[1];
						let base64 = base64Url.replace('-', '+').replace('_', '/');
						console.log(JSON.parse(window.atob(base64)));
						localStorage.setItem('token', token);
						window.location='/hostel';

					}).then(response=>{
						fetchUser: true;
					}).catch(response=>{
						swal(" ",
						 	"Invalid Matriculation/Password Combination!",
						 	 "error")
					})
				}
			})  
		}
	}
} 
</script>