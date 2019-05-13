<template>
  <div id="app">
    <div v-if="this.$route.name !== 'signin'" class="topRightBlob1"></div>
    <!-- <svg
  width="600"
  height="600"
  viewBox="0 0 600 600"
  xmlns="http://www.w3.org/2000/svg"
>
  <g transform="translate(300,300)">
    <path d="M127.9,-205.3C153.1,-182.8,152,-125.9,173.7,-79.1C195.4,-32.4,239.7,4.2,228,27.4C216.3,50.6,148.6,60.3,115.2,101C81.8,141.7,82.7,213.3,61.1,229.3C39.5,245.3,-4.6,205.7,-55.5,190.1C-106.3,174.6,-163.9,183.2,-177.7,158.7C-191.5,134.2,-161.6,76.6,-162.4,27.4C-163.3,-21.9,-194.9,-62.6,-196.2,-102C-197.5,-141.3,-168.5,-179.2,-130.7,-195.9C-93,-212.7,-46.5,-208.3,2.4,-212.1C51.4,-215.9,102.7,-227.8,127.9,-205.3Z" fill="#eab0a2" />
  </g>
</svg> -->
    <div v-if="this.$route.name !== 'signin'" class="topRightBlob2"></div>
    <div id="nav">
      {{$root.user}}
      <div><router-link to="/"><p class="logo">FriendTimacy</p></router-link></div>
      <div class="navRight">
        <div v-if="!$root.user"><router-link to="/aboutus">About us</router-link></div>
        <div v-if="!$root.user"><router-link to="/signup">Sign up</router-link></div>
        <div v-if="!$root.user"><router-link to="/signin">Sign in</router-link></div>
        <div v-if="$root.user" @click="signout"><router-link to="/">Sign out</router-link></div>
      </div>
    </div>
    <router-view class="router-view"/>
  </div>
</template>

<script>
export default {
  data(){
    return {
    }
  },
  created(){
    this.getCurrentUser()
  },
  methods: {
    getCurrentUser(){
      fetch('/friends/backend/api/api-get-current-user.php', {
        method: 'GET'
      })
      .then(res => res.json())
      .then(json => {
        if(json.status = 1){
          this.$root.user = json.data
        }
        console.log(json)
      }).catch(error => {
        console.log(error)
      })
    },
    signout(){
      fetch('/friends/backend/api/api-signout.php', {
        method: 'GET'
      })
      .then(res => res.json())
      .then(json => {
        this.$root.user = ''
        console.log(json)
      }).catch(error => {
        console.log(error)
      })
    }
    // getServerStuff () {
    //   fetch('http://localhost:8080/friends/backend/api/test.php')
    //   .then(res => res.json())
    //   .then(json => {
    //     this.$root.serverStuff = json
    //     console.log(json)
    //   }).catch(error => {
    //     console.log(error)
    //   })
    // },
    // setServerStuff(){
    //   let formData = new FormData()
    //   formData.append('name', this.name)
    //   formData.append('lover', this.lover)
    //   fetch('http://localhost:8080/friends/backend/api/set.php', {
    //     method: 'POST',
    //     body: formData
    //   })
    //   .then(res => res.json())
    //   .then(json => {
    //     console.log(json)
    //   }).catch(error => {
    //     console.log(error)
    //   })
    // }
  }
}
</script>


<style lang="stylus">
@import './assets/global.stylus.styl'

body
  font-family 'Poppins', sans-serif
  background-color tint(brandPink,90%)
  color brandGrey
  margin 0px

#app
  min-height 100vh
  display flex
  flex-direction column
  align-items center
  margin 0px 40px 20px 40px

#nav
  display flex
  align-items center
  z-index 10
  width 90%
  padding-top 35px
  padding-bottom 30px
  font-size 14px
  flex 0

  div
    width 50%

  a
    color brandGrey
    text-decoration none
    &.router-link-exact-active
      color brandGreen

.logo
  color brandPink
  margin 0px
  font-weight bold
  letter-spacing 2px

.navRight
  display flex
  flex-direction row
  align-items space between

  > div
    text-align center

  :first-child
    text-align left

  :last-child
    text-align right

.router-view
  flex-grow 1

.topRightBlob1
  z-index 9
  background-image url('./assets/blob-shape.svg')
  width 400px
  height 400px
  position absolute
  top -179px
  right -127px
  background-size contain
  background-repeat no-repeat
  transform rotate(77deg)
  pointer-events none

.topRightBlob2
  background-image url('./assets/blob-shape2.svg')
  width 400px
  height 400px
  position absolute
  top -172px
  right -113px
  background-size contain
  background-repeat no-repeat
  transform rotate(77deg)
  pointer-events none

</style>
