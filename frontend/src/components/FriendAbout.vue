<template>
  <div class="friendAbout" >
    <div class="friendName">
      <p v-if="!isEditingFriendAbout">{{friend.first_name}} {{friend.last_name}}</p>
      <input v-if="isEditingFriendAbout" type="text" v-model="friend.first_name" placeholder="First name">
      <input id="lastNameInput" v-if="isEditingFriendAbout" type="text" v-model="friend.last_name" placeholder="Last name">
    </div>
    <div class="avatarWrapper">
      <img class="avatar" v-if="friend.image_url==''" src="../assets/dummy.png">
      <img class="avatar" v-if="friend.image_url !=='' && !friend.image_url.includes('http')" :src="`/uploads/${friend.image_url}`">
      <img class="avatar" v-if="friend.image_url !=='' &&friend.image_url.includes('http')" :src="friend.image_url">
      <div :class="[{categoryTitle: true}, friend.category_name]"><p>{{friend.category_name}}</p></div>
    </div>
    <div id="fileUploadWrapper">
      <label for="file">
        <input type="file" id="file" @change="uploadData">
        <img title="Change image" src='../assets/icons/upload-solid.svg'>
      </label>
    </div>
    <div>
      <img class="icon2" src='../assets/icons/phone-solid.svg'>
      <p v-if="!isEditingFriendAbout">{{friend.phone_number}}</p>
      <input v-if="isEditingFriendAbout" type="text" v-model="friend.phone_number" placeholder="Phone number">
    </div>
    <div>
      <img class="icon2" src='../assets/icons/at-solid.svg'>
      <p v-if="!isEditingFriendAbout">{{friend.email}}</p>
      <input v-if="isEditingFriendAbout" type="text" v-model="friend.email" placeholder="Email">
    </div>
    <div>
      <img class="icon2" src='../assets/icons/map-marker-alt-solid.svg'>
      <p v-if="!isEditingFriendAbout">{{friend.address}}</p>
      <input v-if="isEditingFriendAbout" type="text" v-model="friend.address" placeholder="Address">
    </div>
    <div>
      <img class="icon2" src='../assets/icons/briefcase-solid.svg'>
      <p v-if="!isEditingFriendAbout">{{friend.workplace}}</p>
      <input v-if="isEditingFriendAbout" type="text" v-model="friend.workplace" placeholder="Workplace">
    </div>
    <div v-if="!isEditingFriendAbout">
      <img v-if="!isEditingFriendAbout" class="icon2" src='../assets/icons/birthday-cake-solid.svg'>
      <p v-if="!isEditingFriendAbout">{{getAge(friend.birthdate)}}</p>
    </div>
    <div>
      <img class="icon2" src='../assets/icons/baby-carriage-solid.svg'>
      <p v-if="!isEditingFriendAbout">{{friend.birthdate}}</p>
      <input v-if="isEditingFriendAbout" type="date" v-model="friend.birthdate" placeholder="Birthday">
    </div>
    <div class="editButtonsWrapper">
      <button v-if="!isEditingFriendAbout" @click="isEditingFriendAbout = true" class="editAboutButton" title="Edit friend info" id="startEditingFriend"><img src='../assets/icons/edit-solid.svg'></button>
      <button v-if="isEditingFriendAbout" @click="deleteData(friend)" id="deleteFriendButton" title="Delete Friend"><img src='../assets/icons/trash-alt-red-solid.svg'></button>
      <button v-if="isEditingFriendAbout" @click="saveDataChanges(friend)" class="editAboutButton" title="Save friend info" id="saveFriendInfo"><img src='../assets/icons/check-solid.svg'></button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FriendAbout',
  props: ['friend'],
  data(){
    return{
      isEditingFriendAbout: false
    }
  },
  methods:{
    deleteData(friend){
      this.$emit('deleteData', friend)
    },
    saveDataChanges(friend){
      this.$emit('saveDataChanges', friend)
      this.isEditingFriendAbout=false
    },
    uploadData(e){
      this.$emit('uploadData', e)
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

<style scoped lang="stylus">
@import '.././assets/global.stylus.styl'

.friendAbout
    display flex
    flex-direction column
    align-items flex-start

    >div:nth-child(n+3):nth-last-child(n)
      display flex
      align-items center
      padding-left 20%
      margin-bottom 10px
      max-width 70%

      >p
        margin 0px
        font-size 14px
        width 80%
        overflow auto

      >input
        padding 5px
        margin-bottom 8px
        margin-top 20px
        align-self center
        margin 0

    .friendName
      font-weight 700
      font-size 18px
      align-self center

      input
        width 70px
    
      #lastNameInput
        margin-left 10px

    .avatarWrapper
      align-self center
      position relative
      display grid
      justify-items center
      border-radius 50%
      overflow hidden
      margin-bottom 10px

      .avatar
        width 200px
        height 200px
        object-fit cover
        align-self center

      .categoryTitle
        position absolute
        width 100%
        color white
        bottom 0px
        text-transform capitalize
        text-align center
        color white
        opacity 0.9

        &.family
          background-color brandGreen

        &.friends
          background-color brandPink

        &.work
          background-color brandGrey

    #fileUploadWrapper
      width 100%
      height 40px
      padding 0px

      label
        width 100%
        margin-top -50px
        height 10px
        position relative

        input
          width 100%
          height 30px
          pointer-events none
          opacity 0
          font-size 0
          padding 0px
          margin 0px
          border none

        img
          position absolute
          top 20px
          left 130px
          cursor pointer
          width 20px
          height 20px

    .editButtonsWrapper
      width 100%
      margin-right 20px
      display flex

      .editAboutButton
        padding-top 15px
        margin-bottom 5px
        padding 0px

        img
          width 20px

      #deleteFriendButton
        margin-bottom 5px
        padding 0px
        flex-grow 1
        text-align left

        img
          width 15px

      #saveFriendInfo
        align-self flex-end
        flex-grow 1
        text-align right

      #startEditingFriend
        align-self flex-end
        flex-grow 1
        text-align right

</style>
