<template>
  <div class="signin">
    <input type="text" v-model="email" placeholder="Email">
    <input type="password" v-model="userPassword" placeholder="Password">
    <button class="buttonswithArrow" @click="signInUser">Sign in <img class="arrow" src='../assets/icons/arrow-right-solid.svg'></button>
  </div>
</template>

<script>
export default {
  data(){
    return {
      email: '',
      userPassword: ''
    }
  },
  methods: {
    signInUser(){
      let formData = new FormData()
      formData.append('email', this.email)
      formData.append('userPassword', this.userPassword)
      fetch('/api/api-signin.php', {
        method: 'POST',
        body: formData,
        credentials: 'include'
      })
      .then(res => res.json())
      .then(json => {
        this.$root.user = json.data
        this.$router.push('/dashboard')
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

.signin
  display flex
  flex-direction column
  padding-top 150px

</style>
