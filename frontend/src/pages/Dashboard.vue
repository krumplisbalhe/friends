<template>
  <div v-if="$root.user" class="dashboard">
    <div class="panel">
      <button @click="sortingCategory = 1" :class="{activeButton: sortingCategory==1}">Family</button>
      <button @click="sortingCategory = 2" :class="{activeButton: sortingCategory==2}">Work</button>
      <button @click="sortingCategory = 3" :class="{activeButton: sortingCategory==3}">Friends</button>
      <button @click="sortingCategory = 4" :class="{activeButton: sortingCategory==4}">All</button>
      <button  @click="openModal" title="Add friend"><img class="plus" src='../assets/plus-solid.svg'></button>
    </div>
    <div @click="closeModal" v-if="modalIsOpen==true" class="greyLayer">
    </div>
    <div v-if="modalIsOpen==true" class="modalContainer">
      <div class="modal">
        <input type="text" v-model="firstName" placeholder="First name">
        <input type="text" v-model="lastName" placeholder="Last name">
        <input type="text" v-model="email" placeholder="Email">
        <input type="date" v-model="birthday" placeholder="Birthday" title="Birth date">
        <input type="text" v-model="address" placeholder="Address">
        <input type="text" v-model="phoneNumber" placeholder="Phone number">
        <input type="text" v-model="workplace" placeholder="Workplace">
        <select v-model="category">
          <option value="1">Family</option>
          <option value="2">Work</option>
          <option value="3">Friends</option>
        </select>
        <button @click="addFriend"> Add friend<img class="arrow" src='../assets/arrow-right-solid.svg'> </button>
      </div>
    </div>
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
export default {
  data(){
    return {
      modalIsOpen: false,
      firstName:'',
      lastName:'',
      email:'',
      birthday:'',
      address:'',
      phoneNumber:'',
      workplace:'',
      category: 1,
      sortingCategory: 4
    }
  },
  created(){
    this.getAllFriends()
  },
  methods:{
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
    openModal(){
      this.modalIsOpen=true
    },
    closeModal(){
      this.modalIsOpen=false
    },
    addFriend(){
      let formData = new FormData()
      formData.append('firstName', this.firstName)
      formData.append('lastName', this.lastName)
      formData.append('email', this.email)
      formData.append('birthday', this.birthday)
      formData.append('address', this.address)
      formData.append('phoneNumber', this.phoneNumber)
      formData.append('workplace', this.workplace)
      formData.append('category', this.category)
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

<style lang="stylus" scoped>
@import '.././assets/global.stylus.styl'

.panel
  margin-top 80px
  display flex
  flex-direction row
  justify-content space-between
  align-items flex-start

  button
    border none
    background transparent
    cursor pointer
    outline none
    font-family 'Poppins', sans-serif
    font-size 14px
    margin-bottom 5px
    text-transform uppercase
    color #565051

    .plus
      width 20px

  .activeButton
    border-bottom 5px solid brandGreen

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

.greyLayer
  position fixed
  top 0
  left 0
  width 100%
  height 100%
  background-color black
  opacity 0.7
  z-index 4

.modalContainer
  z-index 5

.modal
  z-index 5
  display flex
  flex-flow row wrap
  align-items center
  justify-content space-around
  padding 40px
  background-color tint(brandPink,90%)
  position fixed
  width 600px
  overflow auto
  height 70vh
  top 60px
  border-radius 25px
  box-shadow 3px 6px 19px -10px brandPink

  input, select
    padding 15px
    width 200px
    margin-bottom 30px
    border-radius 25px
    border 3px white solid
    background-color white
    outline none
    box-shadow 3px 6px 19px -10px #ccc
    color #565051

  select
    margin-right 10px

  button
    padding 15px
    margin-bottom 20px
    background-color transparent
    border none
    color #565051
    font-weight bold
    width 50%
    align-self center
    cursor pointer

    .arrow
      width 20px
      position relative
      top 8px
      left 3px
      color white

::placeholder
  color #565051

</style>
