<template>
	<div  class="note">
		<div class="noteButtonsWrapper">
			<div v-if="!isEditingNote">
			<button @click="startEditingNote" title="Edit notes"><img src='../assets/icons/edit-solid.svg'></button>
			</div>
			<div v-if="isEditingNote">
			<button @click="saveData" title="Save changes"><img src='../assets/icons/check-solid.svg'></button>
			</div>
		</div>
		<pre v-if="!isEditingNote">{{ notes }}</pre>
		<textarea ref="noteArea" v-if="isEditingNote" v-model="note" placeholder="Notes to remember"></textarea>
	</div>
</template>

<script>
export default {
	name: 'Notes',
	props:['notes'],
	data(){
		return{
			isEditingNote: false,
			note: ''
		}
	},
	created(){
		this.note = this.notes
	},
	methods:{
		startEditingNote(){
			this.isEditingNote = true
			this.$nextTick(()=>{
				this.$refs.noteArea.focus()
			})
		},
		saveData(){
			this.$emit('saveData', this.note)
			this.isEditingNote = false
		}
	}
}
</script>

<style scoped lang="stylus">
@import '.././assets/variables.stylus.styl'
.note
	display flex
	flex-direction column
	padding 20px 30px
	height 100%

	.noteButtonsWrapper
		align-self flex-end
		display flex
		width 100%
		height 30px
		justify-content flex-end
		margin-top 10px
		margin-bottom 10px
		align-items center

		div
			width 30px
			height 30px
			text-align right

			button
				padding 0px

				img
					width 22px
					height 22px

	textarea
		border none
		overflow auto
		outline none
		font-size 14px
		height 100%
		margin 0px
		padding 0px

	pre
		font-size 14px
		margin 0px
		padding 0px

</style>
