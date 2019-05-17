<template>
  <div v-if="$root.user" class="dashboard">
    <div class="buttonPanel" id="dashboardPanel">
      <button @click="sortingCategory = 1" :class="{activeButton: sortingCategory==1}">Family</button>
      <button @click="sortingCategory = 2" :class="{activeButton: sortingCategory==2}">Work</button>
      <button @click="sortingCategory = 3" :class="{activeButton: sortingCategory==3}">Friends</button>
      <button @click="sortingCategory = 4" :class="{activeButton: sortingCategory==4}">All</button>
      <button  @click="openModal" title="Add friend"><img class="icon" src='../assets/icons/plus-solid.svg'></button>
    </div>
    <Modal v-if="modalIsOpen" @close="closeModal" @addData="addFriend">
    </Modal>
    <div class="dashboardInner">
      <div @click="goToFriend(friend)" v-for="friend in $root.friends" v-if="friend.category_fk==sortingCategory || sortingCategory==4" class="friendContainer">
        <img v-if="friend.image_url==''" src="../assets/dummy.png">
        <img v-if="friend.image_url !=='' && !friend.image_url.includes('http')" :src="`/uploads/${friend.image_url}`">
        <img v-if="friend.image_url !=='' &&friend.image_url.includes('http')" :src="friend.image_url">
        <div class="name">{{friend.first_name}} {{friend.last_name}}</div>
      </div>
    </div>
  </div>
</template>

<script>
import Modal from '@/components/Modal.vue'

export default {
  name: 'dashboard',
  components: {
    Modal
  },
  data(){
    return {
      sortingCategory: 4,
      modalIsOpen: false
    }
  },
  created(){
    this.getAllFriends()
  },
  methods:{
    openModal(){
      this.modalIsOpen=true
    },
    closeModal(){
      this.modalIsOpen=false
    },
    getAllFriends(){
      fetch('/api/api-get-all-friends.php', {
        method: 'GET',
        credentials: 'include'
      })
      .then(res => res.json())
      .then(json => {
        console.log(json)
        //check if its 1
        this.$root.friends = json.data
      }).catch(error => {

        console.log(error)
      })
    },
    goToFriend(friend){
      console.log(friend)
      this.$router.push(`friend/${friend.id}`)
    },
    addFriend(friend){
      let formData = new FormData()
      formData.append('firstName', friend.firstName)
      formData.append('lastName', friend.lastName)
      formData.append('email', friend.email)
      formData.append('birthday', friend.birthday)
      formData.append('address', friend.address)
      formData.append('phoneNumber', friend.phoneNumber)
      formData.append('workplace', friend.workplace)
      formData.append('category', friend.category)
      fetch('/api/api-add-friend.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(json => {
        this.closeModal()
        this.getAllFriends()
        console.log(json)
      }).catch(error => {

        console.log(error)
      })
    }
  }
}
</script>

<style lang="stylus">
@import '.././assets/global.stylus.styl'

#dashboardPanel
  margin-top 80px

.dashboardInner
  z-index 0
  display flex
  flex-direction column
  width 700px
  background-color white
  padding-top 20px
  box-shadow 3px 6px 19px -10px #ccc

.friendContainer
  display flex
  flex-direction row
  align-items center
  padding-bottom 20px
  cursor pointer
  padding-left 30%

  img
    width 80px
    height 80px
    object-fit cover
    border-radius 50%
    margin-right 40px

  .name
    margin-right 40px

</style>
