<template>
  <div id="app">
    <div v-if="this.$route.name !== 'signin'" class="topRightBlob1"></div>
    <div v-if="this.$route.name !== 'signin'" class="topRightBlob2"></div>
    <div v-if="!$root.user" id="navSignedOut">
      <div>
        <router-link v-if="!$root.user" to="/"><p class="logo">FriendTimacy</p></router-link>
      </div>
      <div v-if="!$root.user" class="navRight">
        <div><router-link v-if="!$root.user" to="/aboutus">About us</router-link></div>
        <div><router-link v-if="!$root.user" to="/signup">Sign up</router-link></div>
        <div><router-link v-if="!$root.user" to="/signin">Sign in</router-link></div>
      </div>
    </div>
    <div id="navSignedIn">
      <div>
        <p v-if="$root.user" class="logo">FriendTimacy</p>
      </div>
      <div v-if="$root.user" class="navRightSignedIn">
        <div><router-link v-if="$root.user && $route.name=='friend'" to="/dashboard">Dashboard</router-link></div>
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

#navSignedOut
  display flex
  align-items center
  z-index 3
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

#navSignedIn
  display flex
  flex-direction row
  align-items flex-end
  z-index 3
  width 90%
  padding-top 35px
  padding-bottom 30px
  font-size 14px

  div
    width 50%

    a
      color brandGrey
      text-decoration none

      &.router-link-exact-active
        color brandGreen

  .navRightSignedIn
    display flex
    flex-direction row
    justify-content flex-end

    div
      text-align right

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
  z-index 2
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
