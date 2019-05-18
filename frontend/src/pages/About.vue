<template>
	<div class="about">
		<div class="row">
			<div class="aboutContainers imageContainer">
				<img class="aboutImage" src="../assets/about/1.png">
			</div>
			<div class="aboutContainers textContainer">
				<p>Quick access to your friends - with <span>category sorting</span></br></br>Adding a new contact is an easy and fast process - press the + button</p>
			</div>
		</div>
		<div class="row">
			<div class="aboutContainers textContainer">
				<p>Set up the <span>keep in touch reminder</span> individually to each of your friends</br></br>These reminders will land in your <span>mailbox</span> - now you know who to call on your way home </p>
			</div>
				<div class="aboutContainers imageContainer">
				<img class="aboutImage" src="../assets/about/2.png">
			</div>
		</div>
		<div class="row">
			<div class="aboutContainers imageContainer">
				<img class="aboutImage" src="../assets/about/3.png">
			</div>
			<div class="aboutContainers textContainer">
				<p>Keep a record of the <span>memorable days</span> with your loved ones and use the <span>notebook</span> in your favor</p>
			</div>
		</div>
		<div class="slogen">
			<h2>Let technology help you to be the friend you want to have</h2>
		</div>
	</div>
</template>

<script>
export default {
	data(){
		return {
		}
	},
	methods: {
	}
}
</script>

<style lang="stylus">
@import '../assets/variables.stylus.styl'

.about
	display flex
	flex-direction column
	justify-content space-between
	align-items center
	padding-top 50px

	.slogen
		display flex
		width 100%
		justify-content flex-end

	.row
		display flex
		height 50vh
		padding-left 50px
		padding-right 50px
		padding-bottom 50px

		.imageContainer
			width 60%

			.aboutImage
				width 100%
				box-shadow 0 0 50px #FFFFFF, -10px 0 80px #FFFFFF, 10px 0 80px #ffffff

		.textContainer
			width 40%

			p
				padding 50px
				font-size 18px

				span
					font-weight 700

h2
	padding-top 50px
	letter-spacing 1px
	font-size 12px
	color brandPink

</style>
