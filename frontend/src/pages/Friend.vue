<template>
<div>
  <button @click="isEditing = true" class="editButton">Edit</button>
  <div v-if="$root.user" class="friend">
    <div class="friendAbout">
      <img class="avatar" :src="friend.image_url">
      <p v-if="!isEditing" class="friendName">{{friend.first_name}} {{friend.last_name}}</p>
      <input v-else type="text" v-model="friend.first_name" placeholder="First name">
      <div><img class="icon" src='../assets/phone-solid.svg'><p>{{friend.phone_number}}</p></div>
      <div><img class="icon" src='../assets/at-solid.svg'><p>{{friend.email}}</p></div>
      <div><img class="icon" src='../assets/map-marker-alt-solid.svg'><p>{{friend.address}}</p></div>
      <div><img class="icon" src='../assets/briefcase-solid.svg'><p>{{friend.workplace}}</p></div>
      <div><img class="icon" src='../assets/birthday-cake-solid.svg'><p>{{getAge(friend.birthdate)}}</p></div>
      <div><img class="icon" src='../assets/baby-carriage-solid.svg'><p>{{friend.birthdate}}</p></div>
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
        <p>Notes</p>
        <p>{{friend.note}}</p>
      </div>
    </div>
  </div>
  <!-- <div div v-if="$root.user && isEditing">
    <img :src="friend.image_url">
    <input type="text" v-model="friend.first_name" placeholder="First name">
    <input type="text" v-model="friend.last_name" placeholder="Last name">
    <input type="text" v-model="friend.phone_number" placeholder="Phone number">
    <input type="text" v-model="friend.email" placeholder="Email">
    <input type="text" v-model="friend.address" placeholder="Address">
    <input type="text" v-model="friend.workplace" placeholder="Workplace">
    <input type="date" v-model="friend.birthdate" placeholder="Birthday">
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
      isEditing: false,
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
    saveFriendDataChanges(friend){
      let formData = new FormData()
      console.log(friend)
      formData.append('friendID', friend.friend_fk)
      formData.append('firstName', friend.first_name)
      formData.append('lastName', friend.last_name)
      formData.append('phoneNumber', friend.phone_number)
      formData.append('email', friend.email)
      formData.append('address', friend.address)
      formData.append('workplace', friend.workplace)
      formData.append('birthday', friend.birthdate)
      formData.append('category', friend.category_fk)
      console.log(formData)
      fetch('/friends/backend/api/api-update-friend.php', {
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

.friendName
  align-self center
  font-weight 700
  font-size 18px

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
