<template>
  <div id="app">
    <div class="svgContainer">
      <svg id="navBlob" class="blobs" width="400" height="300" filter="url(#goo)">
        <defs>
          <filter id="goo">
            <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
            <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
            <feComposite in="SourceGraphic" in2="goo" operator="atop"/>
          </filter>
        </defs>
        <circle width=400px height=200px id="Circle10"></circle>
        <circle width=300px height=300px id="Circle11"></circle>
        <circle width=400px height=600px id="Circle12"></circle>
      </svg>
    </div>
    <div v-if="!$root.user" id="navSignedOut" class="nav">
      <div>
        <router-link v-if="!$root.user" to="/"><p class="logo">FriendTimacy</p></router-link>
      </div>
      <div v-if="!$root.user" class="navRight">
        <div><router-link v-if="!$root.user" to="/aboutus">About us</router-link></div>
        <div><router-link v-if="!$root.user" to="/signup">Sign up</router-link></div>
        <div><router-link v-if="!$root.user" to="/signin">Sign in <img v-if="$route.path!='/signin'" class="navArrow" src="./assets/icons/arrow-right-solid.svg"></router-link></div>
      </div>
    </div>
    <div v-if="$root.user" id="navSignedIn" class="nav">
      <div>
        <p v-if="$root.user" class="logo">FriendTimacy</p>
      </div>
      <div v-if="$root.user" class="navRightSignedIn">
        <div><router-link v-if="$root.user && $route.name=='friend'" to="/dashboard"><img class="navList" src="./assets/icons/list-ul-solid.svg">Back</router-link></div>
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
      fetch('/api/api-get-current-user.php', {
        method: 'GET'
      })
      .then(res => res.json())
      .then(json => {
        if(json.status == 1){
          this.$root.user = json.data
        }
      }).catch(error => {
        console.log(error)
      })
    },
    signout(){
      fetch('/api/api-signout.php', {
        method: 'GET'
      })
      .then(res => res.json())
      .then(json => {
        if(json.status == 1){
          this.$root.user = ''
        }
      }).catch(error => {
        console.log(error)
      })
    }
  }
}
</script>


<style lang="stylus">
@import './assets/variables.stylus.styl'
@import './assets/global.stylus.styl'

#navBlob,
#navBlob circle
  fill brandPink

#navBlob
  top -20%
  right -10%
  z-index -1

#Circle10
  animation from360to0 5s linear infinite
  cx 150
  cy 155
  r 100
  transform-origin 175px 150px

#Circle11
  animation from0to360 6s linear infinite
  cx 145
  cy 150
  r 100
  transform-origin 150px 165px

#Circle12
  animation from360to0 6.5s linear infinite
  cx 155
  cy 150
  r 100
  transform-origin 150px 155px

body
  font-family 'Poppins', sans-serif
  background-color tint(brandPink,90%)
  color brandGrey
  margin 0px
  overflow-x hidden

#app
  min-height 100vh
  display flex
  flex-direction column
  align-items center
  margin 0px 40px 20px 40px

#navSignedIn
  align-items flex-end

  .navRightSignedIn
    display flex
    justify-content flex-end

    div
      text-align right

      .navList
        width 17px
        vertical-align sub
        margin-right 5px

#navSignedOut
  align-items center

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

    .navArrow
      width 15px
      vertical-align middle
      margin-left 5px

.logo
  color brandPink
  margin 0px
  font-weight bold
  letter-spacing 2px

</style>
