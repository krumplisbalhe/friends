<template>
  <div v-if="friend">
    <div v-if="$root.user" class="friend">
      <div class="friendAbout" >
        <div class="friendName">
          <p v-if="!isEditingFriendAbout">{{friend.first_name}} {{friend.last_name}}</p>
          <input v-if="isEditingFriendAbout" type="text" v-model="friend.first_name" placeholder="First name">
          <input id="lastNameInput" v-if="isEditingFriendAbout" type="text" v-model="friend.last_name" placeholder="Last name">
        </div>
        <div id="avatarWrapper">
          <img class="avatar" v-if="friend.image_url==''" src="../assets/dummy.png">
          <img class="avatar" v-if="friend.image_url !=='' && !friend.image_url.includes('http')" :src="`/uploads/${friend.image_url}`">
          <img class="avatar" v-if="friend.image_url !=='' &&friend.image_url.includes('http')" :src="friend.image_url">
          <div :class="[{categoryTitle: true}, friend.category_name]"><p>{{friend.category_name}}</p></div>
        </div>
        <div id="fileUploadWrapper">
        <label for="file">
        <input type="file" id="file" @change="uploadImage">
        <img class="icon" title="Change image" src='../assets/upload-solid.svg'>
        </label>
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
        <div v-if="!isEditingFriendAbout">
          <img v-if="!isEditingFriendAbout" class="icon" src='../assets/birthday-cake-solid.svg'>
          <p v-if="!isEditingFriendAbout">{{getAge(friend.birthdate)}}</p>
        </div>
        <div>
          <img class="icon" src='../assets/baby-carriage-solid.svg'>
          <p v-if="!isEditingFriendAbout">{{friend.birthdate}}</p>
          <input v-if="isEditingFriendAbout" type="date" v-model="friend.birthdate" placeholder="Birthday">
        </div>
        <div class="editButtonsWrapper">
          <button v-if="!isEditingFriendAbout" @click="isEditingFriendAbout = true" class="editAboutButton" title="Edit friend info" id="startEditingFriend"><img src='../assets/edit-solid.svg'></button>
          <button v-if="isEditingFriendAbout" @click="deleteFriend(friend)" id="deleteFriendButton" title="Delete Friend"><img src='../assets/trash-alt-red-solid.svg'></button>
          <button v-if="isEditingFriendAbout" @click="saveFriendDataChanges(friend)" class="editAboutButton" title="Save friend info" id="saveFriendInfo"><img src='../assets/check-solid.svg'></button>
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
            <div class="editingMemories">
              <input v-if="isEditingMemory" type="date" v-model="newMemoryDate">
              <input v-if="isEditingMemory" type="text" v-model="newMemoryName">
              <button v-if="isEditingMemory" @click="saveMemory"><img class="check" src='../assets/check-solid.svg' title="Save"></button>
              <button v-if="isEditingMemory" @click="isEditingMemory = false"><img class="close" src='../assets/times-solid.svg' title="Close"></button>
              <button v-if="!isEditingMemory" @click="isEditingMemory = true" ><img class="plus" src='../assets/plus-solid.svg' title="Add memory"></button>
            </div>
            <div v-for="memory in memories" class="memory">
              <img class="cheersIcons" src='../assets/019-cheers.svg'>
              <p>{{memory.date}}</p>
              <p>{{memory.name}}</p>
              <div id="deleteMemory">
              <button class="editAboutButton" @click="deleteFriendMemory(memory)"><img src='../assets/trash-alt-solid.svg' title="Delete memory"></button>
              </div>
            </div>
          </div>
          <div v-if="contentToShow == 3" class="note">
          <div class="noteButtonsWrapper">
            <button v-if="!isEditingNote" class="editAboutButton" @click="startEditingNote" title="Edit notes"><img src='../assets/edit-solid.svg'></button>
            <button class="editAboutButton" v-if="isEditingNote" @click="saveFriendNote(friend)" title="Save changes"><img src='../assets/check-solid.svg'></button>
          </div>
          <pre v-if="!isEditingNote">{{friend.note}}</pre>
          <textarea ref="noteArea" v-if="isEditingNote" v-model="friend.note" placeholder="Notes to remember"></textarea>
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
      friend: {
        'image_url': ''
      },
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
    startEditingNote(){
      this.isEditingNote = true
      this.$nextTick(()=>{
        this.$refs.noteArea.focus()
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
    saveFriendNote(friend){
      let formData = new FormData()
      formData.append('friendID', friend.friend_fk)
      formData.append('note', friend.note)
      fetch('/api/api-update-notes.php', {
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
      fetch('/api/api-update-friend.php', {
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
    saveMemory(){
      let formData = new FormData()
      formData.append('friendID', this.friendID)
      formData.append('date', this.newMemoryDate)
      formData.append('name', this.newMemoryName)
      fetch('/api/api-add-memories.php', {
        method: 'POST',
        credentials: 'include',
        body: formData
      })
      .then(res => res.json())
      .then(json => {
        console.log(json)
        this.isEditingMemory=false
        this.memories.push({date: this.newMemoryDate,friend: this.friendID,name: this.newMemoryName})
        this.newMemoryDate= ''
        this.newMemoryName= ''
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
@import '.././assets/global.stylus.styl'

#startEditingFriend
  align-self flex-end
  flex-grow 1
  text-align right

#saveFriendInfo
  align-self flex-end
  flex-grow 1
  text-align right

#deleteFriendButton
  border none
  background transparent
  cursor pointer
  outline none
  margin-bottom 5px
  padding 0px
  flex-grow 1
  text-align left

  img
    width 15px

#avatarWrapper
  padding 0px
  align-self center
  position relative
  display grid
  justify-items center
  border-radius 50%
  overflow hidden
  margin-bottom 5px

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

.noteButtonsWrapper
  align-self flex-end

.editButtonsWrapper
  width 100%
  margin-right 20px
  display flex
  flex-direction row
  // padding-top 20px

#lastNameInput
  margin-left 10px

.editAboutButton
  padding-top 15px
  border none
  background transparent
  cursor pointer
  outline none
  margin-bottom 5px
  padding 0px

  img
    width 20px

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
  padding-top 30px

  .friendAbout
    width 40%
    display flex
    flex-direction column
    align-items flex-start

    >div:nth-child(n+3):nth-last-child(n)
      display flex
      flex-direction row
      align-items center
      padding-left 20%
      margin-bottom 10px
      max-width 70%

      >p
        margin 0px
        font-size 14px
        width 80%
        overflow-wrap break-word

      >input
        margin 0

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

          .frequencyType
            cursor pointer

          .activeFrequency
            color brandPink

      .memories
        padding 20px 30px 20px 50px
        display flex
        flex-direction column

        .editingMemories
          align-self flex-end
          display flex
          align-items center
          margin-top 10px
          margin-bottom 10px

          button
            margin 0
            padding 0
            width 10%

          input
            margin 0
            border 1px solid brandGrey
            margin-right 5px

          .check
            width 50%

          .close
            width 40%

        .memory
          display flex
          flex-direction row
          align-items center
          font-size 14px

          p
            flex-grow 1

          :last-child
            align-self flex-end

          div

            button
              padding 0px
              margin-top 16px
              margin-bottom 16px
              margin-left 30px
              align-self flex-end

              img
                width 15px

        p
          padding-left 20px

        .cheersIcons
          width 10%
          height 10%

        button
          align-self flex-end
          border none
          background transparent
          cursor pointer
          outline none
          margin-bottom 5px
          color #565051

          .plus
            width 20px

      .note
        display flex
        flex-direction column
        padding 20px 30px
        height 100%

        p
          font-size 14px
          margin 0px

        textarea
          border none
          overflow auto
          outline none
          font-size 14px
          height 100%

        pre
          font-size 14px

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
