<template>
	<div class="signin">
		<input type="text" v-model="email" placeholder="Email">
		<input type="password" v-model="userPassword" placeholder="Password" @keyup.enter="signInUser">
		<button class="buttonswithArrow" @click="signInUser">Sign in <img class="arrow" src='../assets/icons/arrow-right-solid.svg'></button>
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
			isFeedbackModalOpen: false,
			feedbackMessage:'',
			feedbackImage: 0
		}
	},
	methods: {
		signInUser(){
			let formData = new FormData()
			formData.append('email', this.email)
			formData.append('userPassword', this.userPassword)
			fetch('/api/api-signin.php', {
				method: 'POST',
				body: formData,
				credentials: 'include'
			})
			.then(res => res.json())
			.then(json => {
				if(json.status == 1){
					this.$root.user = json.data
					this.$router.push('/dashboard')
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
	}
}
</script>

<style lang="stylus">
.signin
	display flex
	flex-direction column
	padding-top 170px

	input
		margin-bottom 15px

</style>
