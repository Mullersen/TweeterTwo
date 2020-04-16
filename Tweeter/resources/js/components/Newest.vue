<template>
  <div id="newest" class=" panel bg-light-prime">
    <div class="markers">NEW</div>
    <div class="container">
      <div id="new-content" class="container text-center">
        <h2 class="revealStats">Now introducing: The Retweet</h2>
        <h4 class="revealStats">Liking another Users tweets? Now you can re-tweet them to your own account.</h4>
        <img class="my-5 img-fluid border rounded shadow-sm" :src="image_src" alt="The new retweeting function">
        <div class="row justify-content-center">
          <div class="col-sm-8 ">
            <img class="rounded-circle align-self-center shadow float-left" style="height:130px; display:inline-block" :src="'/images/retweetFunction.png'" alt="Tweeters new retweet function">
            <b class="revealStats align-self-center" style="height:130px; display:inline">We have always loved showing respect to our fellow tweeters. Do like us and make your friends messages clearer to your own followers</b>
          </div>
        </div>
      </div>
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
