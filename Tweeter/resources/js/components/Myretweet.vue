<template>
    <div>
        <button @click="toggle" class="btn btn-outline-primary btn-sm mb-3">Retweet</button>
        <div v-if="toggleView == true">
            <div class="card bg-light-prime absolute">
                <div class="card-body">
                    <h3 class="card-title mt-3">Retweet @{{retweetauthor}}'s tweet</h3>
                    <div class="card mb-3">
                        <p class="card-text">{{retweetcontent}}</p>
                    </div>
                    <textarea  class="form-control" v-model="newTweet" style="width:100%;" rows="5"></textarea>
                    <button @click.once="sendRetweet" class="btn btn-primary btn-sm my-3">Tweet it!</button>
                    <svg id="closeIcon" @click="toggleBack" height="20px" width="20px" x="0px" y="0px" viewBox="0 0 26 26" style="enable-background:new 0 0 26 26;" xml:space="preserve"><g><path style="fill:#030104;" d="M21.125,0H4.875C2.182,0,0,2.182,0,4.875v16.25C0,23.818,2.182,26,4.875,26h16.25
                    C23.818,26,26,23.818,26,21.125V4.875C26,2.182,23.818,0,21.125,0z M18.78,17.394l-1.388,1.387c-0.254,0.255-0.67,0.255-0.924,0
                    L13,15.313L9.533,18.78c-0.255,0.255-0.67,0.255-0.925-0.002L7.22,17.394c-0.253-0.256-0.253-0.669,0-0.926l3.468-3.467
                    L7.221,9.534c-0.254-0.256-0.254-0.672,0-0.925l1.388-1.388c0.255-0.257,0.671-0.257,0.925,0L13,10.689l3.468-3.468
                    c0.255-0.257,0.671-0.257,0.924,0l1.388,1.386c0.254,0.255,0.254,0.671,0.001,0.927l-3.468,3.467l3.468,3.467
                    C19.033,16.725,19.033,17.138,18.78,17.394z"/></g></svg>
                    <p v-if="errors.length">
                        <b v-for="error in errors" :key="error">Please correct the following error: {{ error }}</b>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Myretweet",
    data: function(){
        return {
            toggleView: false,
            newTweet:"",
            errors: [],
        }
    },
    props: {
            retweetcontent: String,
            retweetauthor: String,
            username: String,
    },
    methods: {
        toggle: function(){
            this.toggleView = true;
        },
        toggleBack: function(){
            this.toggleView = false;
        },
        sendRetweet: function(){
            if(this.errors.length >=1){
                    this.errors.splice(0,1);
                };
             if(!this.newTweet){
                 this.errors.push("Write something to send a message");
            } else {
                axios.post('/tweet/addRetweet', {
                    content: this.retweetcontent,
                    author: this.retweetauthor,
                    newcontent: this.newTweet,
                    })
                .then(response => {
                    console.log(response.data);
                    var page = window.location.pathname;
                    //console.log(page);
                    if(page == "/tweetFeed"){
                        var tweetGrid = document.getElementById("tweetGrid");
                        var newCard = document.createElement('div');
                        newCard.classList.add("card");
                        newCard.classList.add("mb-2");
                        newCard.innerHTML="<div class='card-body'><h5 class='card-subtitle text-muted'>@ " + this.username + "</h5><p class='card-text mb-2'>"+ this.newTweet + "</p><div class='card my-3'><div class='card-body bg-light'><p class='card-subtitle mb-2'>" + this.retweetauthor + "</p><p class='card-text text-muted mb-2'>" + this.retweetcontent + "</p></div></div></div>";
                        tweetGrid.insertBefore(newCard, tweetGrid.childNodes[0]);
                        document.getElementById("closeIcon").style.margin = 0;
                    }
                    this.toggleView = false;
                })
                .catch(error => {
                    document.getElementById("tweetGrid").innerHTML = "<h1>OOps there seem to have been an error. reload to try again</h1>" + error.message;
                    console.log(error.message);
                    });
            }
        }
    }
}
</script>

<style>
.absolute{
    position: fixed !important;
    top: 30vh;
    left: 20vw;
    width: 60vw;
    height: 60vh;
    z-index: 1000;
    background-color: #F0F7F4 !important;
}
#closeIcon{
        float:right !important;
        margin-top: 13vh !important;
    }
@media (max-width: 1024px){
.absolute{
    top: 30vh;
    left: 20vw;
    width: 60vw;
    height: 37vh;
    }
}
@media (max-width: 430px){
.absolute{
    top:10vh;
    height:80vh;
    width:90vw;
    left:5vw;
}

}
</style>
