<template>
<div>
  <div v-if="$root.user && !isEditing" class="friend">
    <button @click="isEditing = true">Edit</button>
    <div class="friendAbout">
      <img :src="friend.image_url">
      <p>{{friend.first_name}} {{friend.last_name}}</p>
      <div>
        <p>{{friend.phone_number}}</p>
        <p>{{friend.email}}</p>
        <p>{{friend.address}}</p>
      </div>
      <p>{{friend.workplace}}</p>
      <div>
        <p></p>
        <p>{{friend.birthdate}}</p>
      </div>
    </div>
    <div class="friendContent">
      <p>{{friend.category_name}}</p>
      <p>{{friend.frequency}}</p>
      <p>{{friend.note}}</p>
    </div>
  </div>
  <div div v-if="$root.user && isEditing">
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
  </div>
</div>
</template>

<script>
export default {
  data () {
    return {
      friend: {},
      isEditing: false
    }
  },
  created(){
    this.getOneFriend()
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
    }
  }
}

</script>

<style lang="stylus">

.friend
  display flex
  flex-direction column
  justify-content center

  .friendAbout
    width 30%

  .friendContent
    width 70%

</style>
