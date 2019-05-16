<template>
  <div id="app">
    <div class="svgContainer">
      <svg id="navBlob" width="400" height="300" filter="url(#goo)">
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
    <div v-if="!$root.user" id="navSignedOut">
      <div>
        <router-link v-if="!$root.user" to="/"><p class="logo">FriendTimacy</p></router-link>
      </div>
      <div v-if="!$root.user" class="navRight">
        <div><router-link v-if="!$root.user" to="/aboutus">About us</router-link></div>
        <div><router-link v-if="!$root.user" to="/signup">Sign up</router-link></div>
        <div><router-link v-if="!$root.user" to="/signin">Sign in <img v-if="$route.path!='/signin'" class="navArrow" src='./assets/arrow-right-solid.svg'></router-link></div>
      </div>
    </div>
    <div v-if="$root.user" id="navSignedIn">
      <div>
        <p v-if="$root.user" class="logo">FriendTimacy</p>
      </div>
      <div v-if="$root.user" class="navRightSignedIn">
        <div><router-link v-if="$root.user && $route.name=='friend'" to="/dashboard"><img class="navList" src='./assets/list-ul-solid.svg'>Back</router-link></div>
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
        if(json.status = 1){
          this.$root.user = json.data
        }
        console.log(json)
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

.navArrow
  width 15px
  vertical-align middle
  margin-left 5px

.navList
  width 17px
  vertical-align sub
  margin-right 5px


@keyframes from0to360 {
  from{transform:rotate(0)}
  to{transform:rotate(360deg)}
}

@keyframes from360to0 {
  from{transform:rotate(360deg)}
  to{transform:rotate(0deg)}
}

#navBlob,
#navBlob circle
  fill brandPink
  pointer-events none

#navBlob
  position absolute
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

#navSignedOut
  display flex
  align-items center
  z-index 3
  width 90%
  padding-top 30px
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
  padding-top 30px
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

input, textarea, pre
  font-family 'Poppins', sans-serif
  color brandGrey
  outline none

</style>
