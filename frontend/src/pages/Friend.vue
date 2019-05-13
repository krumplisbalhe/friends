<template>
<div>
  <button @click="isEditingFriendAbout = true" class="editButton">Edit</button>
  <button v-if="isEditingFriendAbout" @click="saveFriendDataChanges(friend)">Save changes</button>
  <div v-if="$root.user" class="friend">
    <div class="friendAbout" >
      <img class="avatar" :src="friend.image_url">
      <div class="friendName">
        <p v-if="!isEditingFriendAbout">{{friend.first_name}} {{friend.last_name}}</p>
        <input v-if="isEditingFriendAbout" type="text" v-model="friend.first_name" placeholder="First name">
        <input v-if="isEditingFriendAbout" type="text" v-model="friend.last_name" placeholder="Last name">
      </div>
      <div>
        <img class="icon" src='../assets/phone-solid.svg'>
        <p v-if="!isEditingFriendAbout">{{friend.phone_number}}</p>
        <input v-if="isEditingFriendAbout" type="text" v-model="friend.phone_number" placeholder="Phone number">
      </div>
      <div>
        <img class="icon" src='../assets/at-solid.svg'>
        <p v-if="!isEditingFriendAbout">{{friend.email}}</p>
        <input v-if="isEditingFriendAbout" type="text" v-model="friend.email" placeholder="Email">
      </div>
      <div>
        <img class="icon" src='../assets/map-marker-alt-solid.svg'>
        <p v-if="!isEditingFriendAbout">{{friend.address}}</p>
        <input v-if="isEditingFriendAbout" type="text" v-model="friend.address" placeholder="Address">
      </div>
      <div>
        <img class="icon" src='../assets/briefcase-solid.svg'>
        <p v-if="!isEditingFriendAbout">{{friend.workplace}}</p>
        <input v-if="isEditingFriendAbout" type="text" v-model="friend.workplace" placeholder="Workplace">
      </div>
      <div>
        <img v-if="!isEditingFriendAbout" class="icon" src='../assets/birthday-cake-solid.svg'>
        <p v-if="!isEditingFriendAbout">{{getAge(friend.birthdate)}}</p>
      </div>
      <div>
        <img class="icon" src='../assets/baby-carriage-solid.svg'>
        <p v-if="!isEditingFriendAbout">{{friend.birthdate}}</p>
        <input v-if="isEditingFriendAbout" type="date" v-model="friend.birthdate" placeholder="Birthday">
      </div>
    </div>
    <div class="friendContent">
      <div class="friendCategory">{{friend.category_name}}</div>
      <div class="touchAndMemoriesWrapper">
        <div class="friendKeepInTouch">
          <p>Stay in touch</p>
          <img v-if="friend.frequency=='daily'" src="../assets/daily.svg">
          <img v-if="friend.frequency=='weekly'" src="../assets/weekly.svg">
          <img v-if="friend.frequency=='monthly'" src="../assets/monthly.svg">
          <img v-if="friend.frequency=='yearly'" src="../assets/yearly.svg">
          <img v-if="friend.frequency=='never'" src="../assets/never.svg">
          <p>{{friend.frequency}}</p>
        </div>
        <div class="memories" >
          <p v-for="memory in memories">{{memory.date}} {{memory.name}}</p>
        </div>
      </div>
      <div class="note">
        <button @click="isEditingNote = true" class="editButton">Edit</button>
        <p>Notes</p>
        <p v-if="!isEditingNote">{{friend.note}}</p>
        <button v-if="isEditingNote" @click="saveFriendNote(friend)">Save changes</button>
        <input v-if="isEditingNote" type="text" v-model="friend.note">
      </div>
    </div>
  </div>
  <!-- <div div v-if="$root.user && isEditingFriendAbout">
    <select v-model="friend.category_fk">
      <option value="1">Family</option>
      <option value="2">Work</option>
      <option value="3">Friends</option>
    </select>
    <button @click="saveFriendDataChanges(friend)">Save changes<img class="arrow" src='../assets/arrow-right-solid.svg'> </button>
  </div> -->
</div>
</template>

<script>
export default {
  data () {
    return {
      friend: {},
      isEditingFriendAbout: false,
      isEditingNote: false,
      memories: []
    }
  },
  created(){
    this.getOneFriend()
    this.getFriendMemories()
  },
  methods:{
    getOneFriend(){
      fetch(`/friends/backend/api/api-get-one-friend.php?friendID=${this.$route.params.id}`, {
        method: 'GET',
        credentials: 'include'
      })
      .then(res => res.json())
      .then(json => {
        console.log(json)
        //check if its 1
        this.friend = json.data[0]
      }).catch(error => {

        console.log(error)
      })
    },
    getFriendMemories(){
      fetch(`/friends/backend/api/api-get-friend-memories.php?friendID=${this.$route.params.id}`, {
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
    saveFriendNote(friend){
      let formData = new FormData()
      formData.append('friendID', friend.friend_fk)
      formData.append('note', friend.note)
      fetch('/friends/backend/api/api-update-notes.php', {
        method: 'POST',
        credentials: 'include',
        body: formData
      })
      .then(res => res.json())
      .then(json => {
        console.log(json)
        this.isEditingNote=false
        //check if its 1
      }).catch(error => {

        console.log(error)
      })
      
    },
    saveFriendDataChanges(friend){
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
      fetch('/friends/backend/api/api-update-friend.php', {
        method: 'POST',
        credentials: 'include',
        body: formData
      })
      .then(res => res.json())
      .then(json => {
        console.log(json)
        this.isEditingFriendAbout=false
        //check if its 1
        // this.friend = json.data[0]
      }).catch(error => {

        console.log(error)
      })
    },
    getAge(dateString){
      var today = new Date()
      var birthDate = new Date(dateString)
      var age = today.getFullYear() - birthDate.getFullYear()
      var m = today.getMonth() - birthDate.getMonth()
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate()))
      {
          age--
      }
      if(dateString === '0000-00-00'){
        age = ''
      }
      return age
    }
  }
}

</script>

<style lang="stylus">
@import '.././assets/global.stylus.styl'

input
  padding 5px
  margin-bottom 8px
  margin-top 20px
  border-radius 25px
  border 3px white solid
  background-color white
  outline none
  box-shadow 3px 6px 19px -10px #ccc
  color #565051
  align-self center

.friendName
  font-weight 700
  font-size 18px

  input
    width 70px

.icon
  width 15px
  margin-right 10px

.editButton
  margin-top 40px

.friend
  display flex
  flex-direction row
  justify-content center
  width 700px

  .friendAbout
    width 40%
    display flex
    flex-direction column
    align-items flex-start

    >div
      display flex
      flex-direction row
      align-items center
      padding-left 30px

    .avatar
      width 200px
      height 200px
      object-fit cover
      border-radius 50%
      align-self center

  .friendContent
    width 60%
    background-color white
    box-shadow -8px 0px 10px -11px #ccc
    display flex
    flex-direction column

    .friendCategory
      width 100%-20px
      height 40px
      background-color brandGreen
      text-transform uppercase
      padding-top 20px
      padding-left 20px
      font-weight 700

    .touchAndMemoriesWrapper
      display flex
      flex-direction row

      .friendKeepInTouch
        width 45%
        margin 10px
        box-shadow 0 4px 8px 0 #ccc
        text-align center

        img
          width 25%

      .memories
        margin 10px
        width 45%
        height 170px
        box-shadow 0 4px 8px 0 #ccc
        overflow auto

        p
          padding 10px

    .note
      background pink
      margin 10px
      padding-left 10px


</style>
