<template>
	<div>
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
	left 33%
	top 220px
	z-index 6
	display flex
	flex-direction column
	align-items center
	justify-content space-around
	padding 10px 2% 2% 2%
	background-color brandPink
	color white
	width 33%
	overflow auto
	height 200px
	border-radius 25px
	opacity 0.9

	p
		font-size 20px
		text-align center

	.feedback
		width 40px

	.close
		width 20px
		align-self flex-end
		cursor pointer

</style>
