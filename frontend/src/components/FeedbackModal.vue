<template>
	<div>
		<div @click="closeFeedbackModal" class="greyLayer">
		</div>
		<div class="feedbackModal" >
			<img @click="closeFeedbackModal" class= "close" src="../assets/feedbacks/times-solid.svg">
			<img class="feedback" v-if="image == 0" src="../assets/feedbacks/exclamation-triangle-solid.svg">
			<img class="feedback" v-if="image == 1" src="../assets/feedbacks/check-circle-solid.svg">
			<p>{{ message }}</p>
		</div>
	</div>
</template>

<script>
export default {
  name: 'FeedbackModal',
  props: ['message', 'image'],
  data(){
    return{
    }
  },
  methods:{
    closeFeedbackModal(){
			this.$emit('close')
		},
  }
}
</script>

<style scoped lang="stylus">
@import '.././assets/variables.stylus.styl'

.feedbackModal
	position fixed
	top 50%
	left 33%
	top 33%
	z-index 6
	display flex
	flex-direction column
	align-items center
	justify-content center
	padding 0px 2% 2% 2%
	background-color brandGrey
	border white 1px solid
	color white
	width 30vw
	overflow auto
	height 30vh
	border-radius 25px

	.feedback
		width 50px

	.close
		width 20px
		align-self flex-end
		padding-bottom 30px
		cursor pointer

</style>
