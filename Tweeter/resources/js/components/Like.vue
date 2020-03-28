<template>
    <div>
        <h4>{{tweetid}}</h4>
        <h1 v-if="checkTweet()">You already likes this tweet</h1>
        <h1 v-else>You can like this tweet!</h1>
    </div>
</template>

<script>
export default {
    name: "Like",
    data : function (){
        return {
            likesList: [],
        }
    },
    props: {
        tweetid : Number,
    },
    methods: {
         checkTweet : function(){
             var state = false;
             this.likesList.forEach((like) => {
                 console.log(like.tweet_id, this.tweetid);
                 if(like.tweet_id == this.tweetid){ // you have already liked it. 
                    state = true;
                 }
             })
             return state;
         },
        getUsersLikes : function() {
            axios.get('/like/my-likes')
            .then(response => {
                //console.log(response.data);
                this.likesList = response.data.myLikes;
            })
            .catch(error => {
                    console.log(error.message); // change to error message on screen
                    this.quote = 'Error loading your likes';
                });
        }
    },
     beforeMount() {
         this.getUsersLikes();
         console.log('calling getUsersLikes');
     },
     mounted(){
         this.checkTweet();
     }
 }


</script>

<style>

</style>
