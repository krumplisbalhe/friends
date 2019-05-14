<template>
  <div>
    <button @click="isEditingFriendAbout = true" class="editButton">Edit</button>
    <button v-if="isEditingFriendAbout" @click="saveFriendDataChanges(friend)">Save changes</button>
    <div v-if="$root.user" class="friend">
      <div class="friendAbout" >
        <div class="friendName">
          <p v-if="!isEditingFriendAbout">{{friend.first_name}} {{friend.last_name}}</p>
          <input v-if="isEditingFriendAbout" type="text" v-model="friend.first_name" placeholder="First name">
          <input v-if="isEditingFriendAbout" type="text" v-model="friend.last_name" placeholder="Last name">
        </div>
        <img class="avatar" :src="friend.image_url">

      <!-- <form action="upload.php" method="post" enctype="multipart/form-data"> -->
          <input type="file" name="fileToUpload" id="fileToUpload" @change="uploadImage">
          <!-- <button @click="uploadImage()">Upload Image</button> -->
      <!-- </form> -->


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
        <div class="friendPanel">
          <button @click="contentToShow = 1" :class="{activeButt: contentToShow==1}">Stay in touch</button>
          <button @click="contentToShow = 2" :class="{activeButt: contentToShow==2}">Memories</button>
          <button @click="contentToShow = 3" :class="{activeButt: contentToShow==3}">Notes</button>
        </div>
        <div class="contentToShow">
          <div v-if="contentToShow == 1" class="friendKeepInTouch">
            <div class="imageBox">
            <img v-if="friend.frequency=='daily'" src="../assets/daily.svg">
            <img v-if="friend.frequency=='weekly'" src="../assets/weekly.svg">
            <img v-if="friend.frequency=='monthly'" src="../assets/monthly.svg">
            <img v-if="friend.frequency=='yearly'" src="../assets/yearly.svg">
            <img v-if="friend.frequency=='never'" src="../assets/never.svg">
            </div>
            <div class="frequencyBox">
              <div class="frequencyType" :class="{activeFrequency: friend.frequency=='daily'}" @click="saveStayInTouch(1, 'daily')">Daily</div>
              <div class="frequencyType" :class="{activeFrequency: friend.frequency=='weekly'}" @click="saveStayInTouch(2, 'weekly')">Weekly</div>
              <div class="frequencyType" :class="{activeFrequency: friend.frequency=='monthly'}" @click="saveStayInTouch(3, 'monthly')">Monthly</div>
              <div class="frequencyType" :class="{activeFrequency: friend.frequency=='yearly'}" @click="saveStayInTouch(4, 'yearly')">Yearly</div>
              <div class="frequencyType" :class="{activeFrequency: friend.frequency=='never'}" @click="saveStayInTouch(5, 'never')">Never</div>
            </div>
          </div>
          <div v-if="contentToShow == 2" class="memories" >
            <button @click="isEditingMemory = true" >Add memory</button>
            <div v-for="memory in memories" class="memory">
              <img src='../assets/019-cheers.svg'>
              <p>{{memory.date}}</p>
              <p>{{memory.name}}</p>
            </div>
            <input v-if="isEditingMemory" type="date" v-model="newMemoryDate">
              <input v-if="isEditingMemory" type="text" v-model="newMemoryName">
              <button v-if="isEditingMemory" @click="saveMemory">Save memory</button>
          </div>
          <div v-if="contentToShow == 3" class="note">
          <button @click="isEditingNote = true" class="editButton">Edit</button>
          <p>Notes</p>
          <p v-if="!isEditingNote">{{friend.note}}</p>
          <button v-if="isEditingNote" @click="saveFriendNote(friend)">Save changes</button>
          <input v-if="isEditingNote" type="text" v-model="friend.note">
          </div>
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
      friendID:'',
      isEditingFriendAbout: false,
      isEditingNote: false,
      memories: [],
      imageFuck: '',
      contentToShow: 1,
      isEditingMemory: false,
      newMemoryDate: '',
      newMemoryName: ''
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
        this.friendID = json.data[0].friend_fk
        this.imageFuck="http://localhost:9000/uploads/" + this.friend.image_url
        console.log(this.friend.image_url)
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
    },
    uploadImage(e){
      let data = new FormData()
      data.append('friendID', this.friendID)
      data.append('fileToUpload', event.target.files[0])
      fetch('/friends/backend/api/api-add-image.php', {
        method: 'POST',
        body: data,
        credentials: 'include'
      })
      .then(res => res.json())
      .then(json => {
        console.log(json)
      }).catch(error => {

        console.log(error)
      })
    },
    saveMemory(){
      let formData = new FormData()
      formData.append('friendID', this.friendID)
      formData.append('date', this.newMemoryDate)
      formData.append('name', this.newMemoryName)
      fetch('/friends/backend/api/api-add-memories.php', {
        method: 'POST',
        credentials: 'include',
        body: formData
      })
      .then(res => res.json())
      .then(json => {
        console.log(json)
        this.isEditingMemory=false
        this.memories.push({date: this.newMemoryDate,friend: this.friendID,name: this.newMemoryName})
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
      fetch('/friends/backend/api/api-update-friend-stay-in-touch.php', {
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
  align-self center

  input
    width 70px

.icon
  width 14px
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

    >div:not(:first-child)
      display flex
      flex-direction row
      align-items center
      padding-left 25%
      margin-bottom 10px

      >p
        margin 0px
        font-size 14px

    .avatar
      width 200px
      height 200px
      object-fit cover
      border-radius 50%
      align-self center

  .friendContent
    // margin-top 80px
    width 60%
    display flex
    flex-direction column

    .contentToShow
      background-color white
      box-shadow 3px 6px 19px -10px #ccc
      height 100%

      .friendKeepInTouch
        text-align center
        display flex
        flex-direction row
        padding-top 33%

        .imageBox
          width 70%
          img
            width 50%

        .frequencyBox
          display flex
          flex-direction column
          justify-content space-around
          color lightness(brandGrey, 80%)

          .activeFrequency
            color brandPink

      .memories
        padding 20px 50px

        .memory
          display flex
          flex-direction row
          align-items center

        p
          padding-left 20px

        img
          width 10%
          height 10%

      .note
        background pink
        margin 10px
        padding-left 10px

    .friendPanel
      margin-top 20px
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

      .activeButt
        border-bottom 5px solid brandGreen
</style>
