<template>
  <div id="newest" class="panel bg-light-prime">
      <div class="markers">NEW</div>
      <div id="new-content" class="container text-center">
        <h2 class="revealStats pt-4">Now introducing: The Retweet</h2>
        <h4 class="revealStats">Liking another Users tweets? Now you can re-tweet them to your own account.</h4>
        <img class="my-5 img-fluid shadow-sm" :src="image_src" alt="The new retweeting function">
        <p class="revealStats">We have always loved showing respect to our fellow tweeters. Do like us and make your friends messages clearer to your own followers</p>
      </div>
  </div>
</template>

<script>
export default {
 data : function() {
     return{
     image_src: '/images/retweet.jpg'
    }
 }
}
</script>

<style>
#newest{
    height:130vh;
}
#new-content{
    padding-top:20vh;
}
</style>
