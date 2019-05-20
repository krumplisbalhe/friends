<template>
<div class="modalContainer">
	<div @click="closeModal" class="greyLayer">
	</div>
	<div class="modal">
		<input type="text" v-model="friend.firstName" placeholder="First name">
		<input type="text" v-model="friend.lastName" placeholder="Last name">
		<input type="text" v-model="friend.email" placeholder="Email">
		<input type="date" v-model="friend.birthday" placeholder="Birthday" title="Birth date">
		<input type="text" v-model="friend.address" placeholder="Address">
		<input type="text" v-model="friend.phoneNumber" placeholder="Phone number">
		<input type="text" v-model="friend.workplace" placeholder="Workplace">
		<select v-model="friend.category">
			<option value="1">Family</option>
			<option value="2">Work</option>
			<option value="3">Friends</option>
		</select>
		<button @click="addData(friend)" class="buttonswithArrow">Add friend<img class="arrow" src='../assets/icons/arrow-right-solid.svg'> </button>
	</div>
</div>
</template>

<script>
export default {
	name: 'Modal',
	data(){
		return{
			friend: {
				firstName:'',
				lastName:'',
				email:'',
				birthday:'',
				address:'',
				phoneNumber:'',
				workplace:'',
				category: 1
			}
		}
	},
	methods:{
		closeModal(){
			this.$emit('close')
		},
		addData(friend){
			this.$emit('addData', friend)
		}
	}
}
</script>

<style scoped lang="stylus">
@import '.././assets/variables.stylus.styl'

.modalContainer
	display flex
	align-items center
	justify-content center

.modal
	z-index 5
	display flex
	flex-flow row wrap
	align-items center
	justify-content space-around
	padding 5% 2% 2% 2%
	background-color tint(brandPink, 90%)
	position fixed
	width 600px
	overflow auto
	height 70vh
	top 6vh
	border-radius 25px
	box-shadow 3px 6px 19px -10px brandPink

	input
		width 200px
		margin-bottom 30px

	select
		margin-right 15px
		margin-left 15px
		margin-bottom 30px

</style>
