<template>
	<div v-if="friend">
		<div v-if="$root.user" class="friend">
			<FriendAbout
				:friend="friend" @deleteData="deleteFriend" @saveDataChanges="saveFriendDataChanges"
				@uploadData="uploadImage"
			>
			</FriendAbout>
			<div class="friendContent">
				<div class="buttonPanel" id="friendPanel">
					<button @click="contentToShow = 1" :class="{activeButton: contentToShow==1}">Stay in touch</button>
					<button @click="contentToShow = 2" :class="{activeButton: contentToShow==2}">Memories</button>
					<button @click="contentToShow = 3" :class="{activeButton: contentToShow==3}">Notes</button>
				</div>
				<div class="contentToShow">
					<Keepintouch :friend="friend" @saveStayInTouchData="saveStayInTouch" v-if="contentToShow == 1">
					</Keepintouch>
					<Memories :memories="memories" v-if="contentToShow == 2" @saveMemoryData="saveMemory" @deleteFriendMemoryData="deleteFriendMemory"></Memories>
					<Notes v-if="contentToShow == 3" :notes="notes" @saveData="saveFriendNote"></Notes>
				</div>
			</div>
			</div>
	</div>
</template>

<script>
import FriendAbout from '@/components/FriendAbout.vue'
import Keepintouch from '@/components/Keepintouch.vue'
import Memories from '@/components/Memories.vue'
import Notes from '@/components/Notes.vue'

export default {
	name: 'dashboard',
	components: {
		FriendAbout,
		Keepintouch,
		Memories,
		Notes
	},
	data () {
		return {
			friend: {
				'image_url': ''
			},
			friendID:'',
			memories: [],
			contentToShow: 1,
			notes:''
		}
	},
	created(){
		this.getOneFriend()
		this.getFriendMemories()
	},
	methods:{
		deleteFriend(friend){
			let formData = new FormData()
			formData.append('friendID', friend.friend_fk)
			fetch('/api/api-delete-friend.php', {
				method: 'POST',
				credentials: 'include',
				body:formData
			})
			.then(res => res.json())
			.then(json => {
				console.log(json)
				this.$router.push('/dashboard')
				//check if its 1
			}).catch(error => {

				console.log(error)
			})
		},
		getOneFriend(){
			fetch(`/api/api-get-one-friend.php?friendID=${this.$route.params.id}`, {
				method: 'GET',
				credentials: 'include'
			})
			.then(res => res.json())
			.then(json => {
				console.log(json)
				//check if its 1
				this.friend = json.data[0]
				this.friendID = json.data[0].friend_fk
				this.notes = json.data[0].note
				this.imageFuck="http://localhost:9000/uploads/" + this.friend.image_url
				console.log(this.friend.image_url)
			}).catch(error => {

				console.log(error)
			})
		},
		getFriendMemories(){
			fetch(`/api/api-get-friend-memories.php?friendID=${this.$route.params.id}`, {
				method: 'GET',
				credentials: 'include'
			})
			.then(res => res.json())
			.then(json => {
				console.log(json)
				this.memories = json.data
				console.log(this.memories)
				//check if its 1
			}).catch(error => {

				console.log(error)
			})
		},
		deleteFriendMemory(memory){
			let formData = new FormData()
			console.log(memory.id)
			formData.append('memoryID', memory.id)
			fetch('/api/api-delete-memories.php', {
				method: 'POST',
				credentials: 'include',
				body:formData
			})
			.then(res => res.json())
			.then(json => {
				console.log(json)
				this.getFriendMemories()
				//check if its 1
			}).catch(error => {

				console.log(error)
			})
		},
		saveFriendNote(friend, note){
			let formData = new FormData()
			formData.append('friendID', friend.friend_fk)
			formData.append('note', note)
			fetch('/api/api-update-notes.php', {
				method: 'POST',
				credentials: 'include',
				body: formData
			})
			.then(res => res.json())
			.then(json => {
				console.log(json)
				//check if its 1
			}).catch(error => {

				console.log(error)
			})
		},
		saveFriendDataChanges(friend){
			console.log(friend)
			let formData = new FormData()
			formData.append('friendID', friend.friend_fk)
			formData.append('firstName', friend.first_name)
			formData.append('lastName', friend.last_name)
			formData.append('phoneNumber', friend.phone_number)
			formData.append('email', friend.email)
			formData.append('address', friend.address)
			formData.append('workplace', friend.workplace)
			formData.append('birthday', friend.birthdate)
			formData.append('category', friend.category_fk)
			fetch('/api/api-update-friend.php', {
				method: 'POST',
				credentials: 'include',
				body: formData
			})
			.then(res => res.json())
			.then(json => {
				console.log(json)
				//check if its 1
				// this.friend = json.data[0]
			}).catch(error => {

				console.log(error)
			})
		},
		uploadImage(e){
			let data = new FormData()
			data.append('friendID', this.friendID)
			data.append('fileToUpload', event.target.files[0])
			fetch('/api/api-add-image.php', {
				method: 'POST',
				body: data,
				credentials: 'include'
			})
			.then(res => res.json())
			.then(json => {
				console.log(json)
				this.friend.image_url = json.data
			}).catch(error => {

				console.log(error)
			})
		},
		saveMemory(newMemoryDate, newMemoryName){
			let formData = new FormData()
			formData.append('friendID', this.friendID)
			formData.append('date', newMemoryDate)
			formData.append('name', newMemoryName)
			fetch('/api/api-add-memories.php', {
				method: 'POST',
				credentials: 'include',
				body: formData
			})
			.then(res => res.json())
			.then(json => {
				console.log(json)
				this.getFriendMemories()
				//check if its 1
			}).catch(error => {

				console.log(error)
			})
		},
		saveStayInTouch(number, frequency){
			let formData = new FormData()
			formData.append('friendID', this.friendID)
			formData.append('stayInTouchFrequency', number)
			console.log(number)
			fetch('/api/api-update-friend-stay-in-touch.php', {
				method: 'POST',
				credentials: 'include',
				body: formData
			})
			.then(res => res.json())
			.then(json => {
				this.friend.frequency = frequency
				console.log(json)
				// this.isEditingMemory=false
				// getFriendMemories()
				//check if its 1
			}).catch(error => {

				console.log(error)
			})
		}
	}
}

</script>

<style lang="stylus">
.friend
	display flex
	justify-content center
	width 700px
	padding-top 30px

	.friendAbout
		width 40%

	.friendContent
		width 60%
		display flex
		flex-direction column

		#friendPanel
			margin-top 20px

		.contentToShow
			background-color white
			box-shadow 3px 6px 19px -10px #CCCCCC
			height 100%

</style>
