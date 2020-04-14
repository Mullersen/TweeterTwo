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
                    <svg class="closeIcon" @click="toggleBack" height="20px" width="20px" x="0px" y="0px" viewBox="0 0 26 26" style="enable-background:new 0 0 26 26;" xml:space="preserve"><g><path style="fill:#030104;" d="M21.125,0H4.875C2.182,0,0,2.182,0,4.875v16.25C0,23.818,2.182,26,4.875,26h16.25
                    C23.818,26,26,23.818,26,21.125V4.875C26,2.182,23.818,0,21.125,0z M18.78,17.394l-1.388,1.387c-0.254,0.255-0.67,0.255-0.924,0
                    L13,15.313L9.533,18.78c-0.255,0.255-0.67,0.255-0.925-0.002L7.22,17.394c-0.253-0.256-0.253-0.669,0-0.926l3.468-3.467
                    L7.221,9.534c-0.254-0.256-0.254-0.672,0-0.925l1.388-1.388c0.255-0.257,0.671-0.257,0.925,0L13,10.689l3.468-3.468
                    c0.255-0.257,0.671-0.257,0.924,0l1.388,1.386c0.254,0.255,0.254,0.671,0.001,0.927l-3.468,3.467l3.468,3.467
                    C19.033,16.725,19.033,17.138,18.78,17.394z"/></g></svg>
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
            newTweet:" ",
        }
    },
    props: {
            retweetcontent: String,
            retweetauthor: String,
    },
    methods: {
        toggle: function(){
            this.toggleView = true;
        },
        toggleBack: function(){
            this.toggleView = false;
        },
        sendRetweet: function(){
            
            axios.post('/tweet/addRetweet', {
                content: this.retweetcontent,
                author: this.retweetauthor,
                newcontent: this.newTweet,
                })
            .then(response => {
                console.log(response.data);
                this.toggleView = false;
            })
            .catch(error => {
                console.log(error.message);
                });
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
    height: 50vh;
    z-index: 1000;
    background-color: #F0F7F4 !important;
}
.closeIcon{
        float:right !important;
        margin-top: 10vh !important;
    }
</style>
