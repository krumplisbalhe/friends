<template>
	<div class="signup" v-if="!submitted">
		<input type="text" v-model="firstName" placeholder="First name">
		<input type="text" v-model="lastName" placeholder="Last name">
		<input type="text" v-model="email" placeholder="Email">
		<input type="password" v-model="userPassword" placeholder="Password" @keyup.enter="signUpUser">
		<button class="buttonswithArrow" @click="signUpUser">Sign up <img class="arrow" src='../assets/icons/arrow-right-solid.svg'> </button>
	</div>
	<div class="welcome" v-else>
		<img src="../assets/bracelet.svg">
		<p>One step closer to <span>nurture</span> your <span>relationships</span>.
		You can find the Log in button in the right upper corner.</p>
	</div>
</template>

<script>
export default {
	data(){
		return {
			email: '',
			userPassword: '',
			firstName: '',
			lastName:'',
			submitted: false
		}
	},
	methods: {
		signUpUser(){
			let formData = new FormData()
			formData.append('firstName', this.firstName)
			formData.append('lastName', this.lastName)
			formData.append('email', this.email)
			formData.append('userPassword', this.userPassword)
			fetch('/api/api-signup.php', {
				method: 'POST',
				body: formData
			})
			.then(res => res.json())
			.then(json => {
				this.submitted=true
				console.log(json)
			}).catch(error => {

				console.log(error)
			})
		}
	},
}
</script>

<style lang="stylus">
.signup
	display flex
	flex-direction column
	padding-top 140px

	input
		margin-bottom 15px

.welcome
	font-size 18px
	display flex
	flex-direction column
	justify-content center
	align-items center
	padding 0px 20% 5px 20%
	font-size 20px
	letter-spacing 2px
	text-align center

	span
		font-weight 700

	img
		width 150px

</style>
