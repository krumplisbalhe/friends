<template>
  <div class="about">
    <div class="row">
      <div class="imageContainer">
        <img class="aboutImage" src="../assets/about/1.png">
      </div>
      <div class="textContainer">
        <p>Quick access to your friends - with category sorting </p>
      </div>
    </div>
    <div class="row">
      <div class="textContainer">
        <p>Adding a new contact is an easy and fast process - press the + button</p>
      </div>
      <div class="imageContainer">
        <img class="aboutImage" src="../assets/about/2.png">
      </div>
    </div>
    <div class="row">
      <div class="imageContainer">
        <img class="aboutImage" src="../assets/about/3.png">
      </div>
      <div class="textContainer">
        <p>Set up the keep in touch reminder individually to each and every one of your friends. These reminders will land in your mailbox - now you know who to call on your way home, or who to check up on with a kind message. </p>
      </div>
    </div>
    <div class="row">
      <div class="textContainer">
        <p>Keep a record of the memorable days with your loved ones and use the notebook in your favor.</p>
      </div>
      <div class="imageContainer">
        <img class="aboutImage" src="../assets/about/4.png">
      </div>
    </div>
    <h2>Let technology help you to be the friend you want to have</h2>
  </div>
</template>

<script>
export default {
  data(){
    return {
    }
  },
  methods: {
  }
}
</script>

<style lang="stylus">
.about
  display flex
  flex-direction column
  justify-content space-between
  align-items center
  padding-top 40px

  .row
    display flex
    flex-direction row
    height 50vh
    
    div
      width 50%

    .imageContainer
      background-color white

.aboutImage
  width 80%


</style>
