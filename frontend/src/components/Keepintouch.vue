<template>
	<div class="keepInTouch">
		<div class="imageBox">
			<img v-if="friend.frequency=='daily'" src="../assets/frequencies/daily.svg">
			<img v-if="friend.frequency=='weekly'" src="../assets/frequencies/weekly.svg">
			<img v-if="friend.frequency=='monthly'" src="../assets/frequencies/monthly.svg">
			<img v-if="friend.frequency=='yearly'" src="../assets/frequencies/yearly.svg">
			<img v-if="friend.frequency=='never'" src="../assets/frequencies/never.svg">
		</div>
		<div class="frequencyBox">
			<div class="frequencyType" :class="{activeFrequency: friend.frequency=='daily'}" @click="saveStayInTouchData(1, 'daily')">Daily</div>
			<div class="frequencyType" :class="{activeFrequency: friend.frequency=='weekly'}" @click="saveStayInTouchData(2, 'weekly')">Weekly</div>
			<div class="frequencyType" :class="{activeFrequency: friend.frequency=='monthly'}" @click="saveStayInTouchData(3, 'monthly')">Monthly</div>
			<div class="frequencyType" :class="{activeFrequency: friend.frequency=='yearly'}" @click="saveStayInTouchData(4, 'yearly')">Yearly</div>
			<div class="frequencyType" :class="{activeFrequency: friend.frequency=='never'}" @click="saveStayInTouchData(5, 'never')">Never</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Keepintouch',
	props: ['friend'],
	data(){
		return{
		}
	},
	methods:{
		saveStayInTouchData(number, frequency){
			this.$emit('saveStayInTouchData', number, frequency)
		}
	}
}
</script>

<style scoped lang="stylus">
@import '.././assets/variables.stylus.styl'

.keepInTouch
	text-align center
	display flex
	padding-top 33%

	.imageBox
		width 70%

		img
			width 50%

	.frequencyBox
		display flex
		flex-direction column
		justify-content space-around
		color lightness(brandGrey, 80%)

		.frequencyType
			cursor pointer

		.activeFrequency
			color brandPink

</style>
