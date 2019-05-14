<template>
  <div class="landing">
    <div class="svgContainer">
      <svg id="pinkBlob" width="400" height="300" filter="url(#goo)">
        <defs>
          <filter id="goo">
            <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
            <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
            <feComposite in="SourceGraphic" in2="goo" operator="atop"/>
          </filter>
        </defs>
        <circle width=400px height=200px id="Circle1"></circle>
        <circle width=300px height=300px id="Circle2"></circle>
        <circle width=400px height=600px id="Circle3"></circle>
      </svg>
      <svg id="greyBlob" width="400" height="300" filter="url(#goo)">
        <defs>
          <filter id="goo">
            <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
            <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
            <feComposite in="SourceGraphic" in2="goo" operator="atop"/>
          </filter>
        </defs>
        <circle width=500px height=600px id="Circle4"></circle>
        <circle width=400px height=700px id="Circle5"></circle>
        <circle width=600px height=600px id="Circle6"></circle>
      </svg>
      <svg id="greenBlob" width="400" height="300" filter="url(#goo)">
        <defs>
          <filter id="goo">
            <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
            <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
            <feComposite in="SourceGraphic" in2="goo" operator="atop"/>
          </filter>
        </defs>
        <circle width=700px height=700px id="Circle7"></circle>
        <circle width=600px height=500px id="Circle8"></circle>
        <circle width=800px height=600px id="Circle9"></circle>
      </svg>
    </div>
    <div class="heroText">
      <p>We help you to keep your important relationships strong and happy</p>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import HelloWorld from '@/components/HelloWorld.vue'

export default {
  name: 'landing',
  components: {
    HelloWorld
  }
}
</script>

<style lang="stylus">
@import '.././assets/global.stylus.styl'

.landing
  width 100%
  display flex
  flex-direction row

  div
    width 50%

  .heroText
    display flex
    flex-direction column
    align-items grid-start
    font-size 35px
    padding 160px 30px 30px 0px
    width 50%

    p
      padding-left 0

@keyframes from0to360 {
  from{transform:rotate(0)}
  to{transform:rotate(360deg)}
}

@keyframes from360to0 {
  from{transform:rotate(360deg)}
  to{transform:rotate(0deg)}
}

#pinkBlob,
#pinkBlob circle
  fill brandPink

#pinkBlob
  position absolute
  left 5%
  top 25%

#greyBlob
  position absolute
  left 15%
  top 50%

#greenBlob
  position absolute
  left 20%
  top 10%

#greyBlob,
#greyBlob circle
  fill brandGrey

#greenBlob,
#greenBlob circle
  fill brandGreen

#Circle1
  animation from360to0 5s linear infinite
  cx 150
  cy 155
  r 100
  transform-origin 155px 150px

#Circle2
  animation from0to360 4s linear infinite
  cx 145
  cy 150
  r 100
  transform-origin 150px 145px

#Circle3
  animation from360to0 5.5s linear infinite
  cx 155
  cy 150
  r 100
  transform-origin 150px 155px

#Circle4
  animation from360to0 7s linear infinite
  cx 150
  cy 155
  r 100
  transform-origin 155px 150px

#Circle5
  animation from0to360 6s linear infinite
  cx 145
  cy 150
  r 100
  transform-origin 150px 145px

#Circle6
  animation from360to0 6.5s linear infinite
  cx 155
  cy 150
  r 100
  transform-origin 150px 155px

#Circle7
  animation from360to0 8s linear infinite
  cx 150
  cy 155
  r 100
  transform-origin 155px 150px

#Circle8
  animation from0to360 9s linear infinite
  cx 145
  cy 150
  r 100
  transform-origin 150px 145px

#Circle9
  animation from360to0 8.5s linear infinite
  cx 155
  cy 150
  r 100
  transform-origin 150px 155px

</style>
