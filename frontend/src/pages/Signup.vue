<template>
	<div>
		<div class="signup" v-if="!submitted">
			<input type="text" v-model="firstName" placeholder="First name">
			<input type="text" v-model="lastName" placeholder="Last name">
			<input type="text" v-model="email" placeholder="Email">
			<input type="password" v-model="userPassword" placeholder="Password" @keyup.enter="signUpUser">
			<button class="buttonswithArrow" @click="signUpUser">Sign up <img class="arrow" src='../assets/icons/arrow-right-solid.svg'> </button>
		</div>
		<div class="welcome"  v-if="submitted">
			<img src="../assets/bracelet.svg">
			<p>One step closer to <span>nurture</span> your <span>relationships</span>.
			You can find the Log in button in the right upper corner.</p>
		</div>
		<FeedbackModal :message="feedbackMessage" :image="feedbackImage" v-if="isFeedbackModalOpen" @close="closeModal"></FeedbackModal>
	</div>
</template>

<script>
import FeedbackModal from '@/components/FeedbackModal.vue'

export default {
	components: {
		FeedbackModal
	},
	data(){
		return {
			email: '',
			userPassword: '',
			firstName: '',
			lastName:'',
			submitted: false,
			isFeedbackModalOpen: false,
			feedbackMessage:'',
			feedbackImage: 0
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
				if(json.status == 1){
					this.submitted = true
				}
				if(json.status == 0){
					this.isFeedbackModalOpen = true
					this.feedbackMessage = json.message
					this.feedbackImage = 0
				}
			}).catch(error => {
				console.log(error)
			})
		},
		closeModal(){
			this.isFeedbackModalOpen = false
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
	padding 150px 20% 5px 20%
	font-size 20px
	letter-spacing 2px
	text-align center

	span
		font-weight 700

	img
		width 150px

.feedbackModal
	align-self center

</style>
