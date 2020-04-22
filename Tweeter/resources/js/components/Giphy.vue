<template>
    <div>
        <div v-if="gifToggle == true">
            <div class="container mb-2">
                <p class="card-text small mb-1 font-weight-bold">{{user}}</p>
                <div class="col-sm-6">
                    <img class='card-img border-bottom' :src="injectedGif" alt='commented Gif'>
                </div>
                <button @click='deleteGif' class='btn btn-link btn-sm' style="display:inline">Delete GIF</button>
            </div>
        </div>
        <div class="form-inline">
            <div class="form-group mb-0">
                <textarea class="form-control form-control-sm rounded-pill my-2" v-model="gifsearch" rows="1" placeholder="Search for a GIF"></textarea>
            </div>
            <button @click="sendSearch" class="btn btn-primary btn-sm ml-2 rounded-pill">Search</button>
        </div>
        <div v-if="gridToggle == true">
            <div class="gifGrid bg-dark">
                <img v-for="(giphy, index) in gifsArray" :key="giphy" @click.once="sendToDB(index)" class="gif" :src="giphy" alt="Searched Gifs">
            </div>
            <svg class="closeIcon mt-1" @click="gridToggle = false" height="20px" width="20px" x="0px" y="0px" viewBox="0 0 26 26" style="enable-background:new 0 0 26 26;" xml:space="preserve"><g><path style="fill:#030104;" d="M21.125,0H4.875C2.182,0,0,2.182,0,4.875v16.25C0,23.818,2.182,26,4.875,26h16.25
		        C23.818,26,26,23.818,26,21.125V4.875C26,2.182,23.818,0,21.125,0z M18.78,17.394l-1.388,1.387c-0.254,0.255-0.67,0.255-0.924,0
		        L13,15.313L9.533,18.78c-0.255,0.255-0.67,0.255-0.925-0.002L7.22,17.394c-0.253-0.256-0.253-0.669,0-0.926l3.468-3.467
		        L7.221,9.534c-0.254-0.256-0.254-0.672,0-0.925l1.388-1.388c0.255-0.257,0.671-0.257,0.925,0L13,10.689l3.468-3.468
		        c0.255-0.257,0.671-0.257,0.924,0l1.388,1.386c0.254,0.255,0.254,0.671,0.001,0.927l-3.468,3.467l3.468,3.467
		        C19.033,16.725,19.033,17.138,18.78,17.394z"/></g></svg>
                <p>Powered By GIPHY</p>
        </div>
    </div>
</template>

<script>
export default {
    name : "Giphy",
    data: function(){
        return {
            gifsearch: "",
            gifsArray: [],
            injectedGif: "",
            gifId: Number,
            gifToggle: false,
            gridToggle: false,
            user: this.username,
        }
    },
    props :{
        tweetid : Number,
        username: String,
    },
    methods: {
        sendSearch: function(){
            var slugified = this.slugify(this.gifsearch);
            axios.get("https://api.giphy.com/v1/gifs/search?q=" + slugified + "&api_key=A58IGl1RDtLVlRaN69KZV7ndSBDWVhDR&limit=6")
            .then(response => {
                //console.log(response.data.data);
                let newGifArray = response.data.data.map(gif =>{
                    return gif.images.downsized_medium.url;
                });
                this.gifsArray = newGifArray;
                this.gridToggle = true;
            })
            .catch(error => {
                console.log(error);
                document.getElementById("tweetGrid").innerHTML = "<h1>Oops there seem to have been an error. reload to try again</h1>" + error.message;
                });
        },
        clicked: function(){

        },
        sendToDB: function(index){
            //console.log('send to DB has been called');
             axios.post('/comment/addGifComment', {
                id : this.tweetid,
                URL : this.gifsArray[index],
                })
            .then(response => {
                console.log(response.data);
                this.injectedGif = response.data.URL;
                this.gifId = response.data.gifs_id;
                this.gifToggle = true;
                this.gridToggle = false;
                var scope = this;
                setTimeout(function(){
                    scope.hasBeenClicked = false;
                }, 5000)
            })
            .catch(error => {
                console.log(error);
                document.getElementById("tweetGrid").innerHTML = "<h1>OOps there seem to have been an error. reload to try again</h1>" + error.message;
                });
        },
        deleteGif: function(){
            console.log("delete gif has been evoked");
            axios.post('/comment/deleteGifComment', {
                id : this.gifId,
                })
            .then(response => {
                this.gifToggle = false;
            })
            .catch(error => {
                console.log(error.quote);
                document.getElementById("tweetGrid").innerHTML = "<h1>OOps there seem to have been an error. reload to try again</h1>" + error.message;
                });
        },
        slugify: function(text) {
            const from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;"
            const to = "aaaaaeeeeeiiiiooooouuuunc------"

            const newText = text.split('').map(
                (letter, i) => letter.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i)))

            return newText
                .toString()                     // Cast to string
                .toLowerCase()                  // Convert the string to lowercase letters
                .trim()                         // Remove whitespace from both sides of a string
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/&/g, '-y-')           // Replace & with 'and'
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-');        // Replace multiple - with single -
            }
    }
}
</script>

<style scoped>
    .gifGrid{
        display: grid;
        grid-template-columns:1fr 1fr 1fr;
        grid-template-rows:1fr 1fr;
        grid-row-gap: 1vh;
        grid-column-gap: 1vw;
        justify-items: center;
        align-items: center;
        padding: 1vh 1vw 1vh 1vw;
        border-radius: 6px;

    }
    .gif{
        width: 100%;
    }
    .closeIcon{
        float:right;
    }
</style>
