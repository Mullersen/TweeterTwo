<template>
  <div id="newest" class="bg-light-prime">
      <div class="container py-5 text-center">
          <br>
          <br>
          <br>
        <img class="my-5 img-fluid" :src="image_src" alt="The new retweeting function">
        <h2 class="pt-4">Now introducing: The Retweet</h2>
        <h4>Liking another Users tweets? Now you can re-tweet them to your own account.</h4>
      </div>
      <br>
      <br>
      <br>
      <div class="bg-light py-5 my-5 text-center">
          <h1 mt-5>The place to be, to see...</h1>
          <h2>What's happening in the world and who are in it</h2>
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

</style>
