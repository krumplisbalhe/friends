<template>
<div  class="memories" >
	<div class="editingMemories">
		<input id="editInputL" v-if="isEditingMemory" type="date" v-model="newMemoryDate">
		<input  id="editInputR" v-if="isEditingMemory" type="text" v-model="newMemoryName">
		<button v-if="isEditingMemory" @click="saveMemoryData(newMemoryDate,newMemoryName)"><img class="check" src='../assets/icons/check-solid.svg' title="Save"></button>
		<button v-if="isEditingMemory" @click="isEditingMemory = false"><img class="close" src='../assets/icons/times-solid.svg' title="Close"></button>
		<div>
		<button v-if="!isEditingMemory" @click="isEditingMemory = true" ><img class="icon" src='../assets/icons/plus-solid.svg' title="Add memory"></button>
		</div>
	</div>
	<div v-for="memory in memories" class="memory">
		<img class="cheersIcons" src='../assets/icons/cheers.svg'>
		<p>{{memory.date}}</p>
		<p>{{memory.name}}</p>
		<div id="deleteMemory">
		<button class="editAboutButton" @click="deleteFriendMemoryData(memory)"><img src='../assets/icons/trash-alt-solid.svg' title="Delete memory"></button>
		</div>
	</div>
</div>
</template>

<script>
export default {
	name: 'Memories',
	props: ['memories'],
  data(){
    return{
			isEditingMemory: false,
			newMemoryDate: '',
      newMemoryName: ''
    }
  },
  methods:{
		saveMemoryData(newMemoryDate, newMemoryName){
			this.isEditingMemory=false
			this.$emit('saveMemoryData', newMemoryDate, newMemoryName)
			this.newMemoryDate= ''
      this.newMemoryName= ''
		},
		deleteFriendMemoryData(memory){
			this.$emit('deleteFriendMemoryData', memory)
		}
  }
}
</script>

<style scoped lang="stylus">
@import '.././assets/variables.stylus.styl'

.memories
	padding 20px 30px 20px 50px
	display flex
	flex-direction column

	.editingMemories
		width 100%
		height 30px
		display flex
		margin-top 10px
		margin-bottom 10px
		justify-content flex-end

		button
			margin 0
			padding 0
			width 20%

		#editInputL, #editInputR
			margin-right 5px
			border 1px solid brandGrey
      align-self center
			margin-bottom 0px

		.check
			width 85%

		.close
			width 70%

	.memory
		display flex
		flex-direction row
		align-items center
		font-size 14px

		p
			flex-grow 1

		:last-child
			align-self flex-end

		div

			button
				padding 0px
				margin-top 16px
				margin-bottom 16px
				margin-left 30px
				align-self flex-end

				img
					width 15px

	p
		padding-left 10px

	.cheersIcons
		width 10%
		height 10%


</style>
