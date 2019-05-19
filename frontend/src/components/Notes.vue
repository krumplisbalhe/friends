<template>
	<div  class="note">
		<div class="noteButtonsWrapper">
			<button v-if="!isEditingNote" @click="startEditingNote" title="Edit notes"><img src='../assets/icons/edit-solid.svg'></button>
			<button v-if="isEditingNote" @click="saveData" title="Save changes"><img src='../assets/icons/check-solid.svg'></button>
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
	padding 30px 30px
	height 100%

	.noteButtonsWrapper
		align-self flex-end

		button
			width 30px
			height 30px

			img
				width 20px
				height 20px

	textarea
		border none
		overflow auto
		outline none
		font-size 14px
		height 100%

	pre
		font-size 14px

</style>
