<template>
    <div>
        <div v-if="gifToggle == true">
            <div class="container mb-2">
                <div class="col-sm-6">
                    <img class='card-img border-bottom' :src="injectedGif" alt='commented Gif'>
                </div>
                <button @click='deleteGif' class='btn btn-link btn-sm' style="display:inline">Delete GIF</button>
            </div>
        </div>
        <div class="form-inline">
            <div class="form-group mb-0">
                <input class="form-control form-control-sm rounded-pill my-2" v-model="gifsearch" placeholder="Search for a GIF">
            </div>
            <button @click="sendSearch" class="btn btn-primary btn-sm ml-2 rounded-pill">comment with GIF</button>
        </div>
        <div v-if="gridToggle == true" class="gridContainer">
            <div class="gifGrid bg-primary">
                <img v-for="(giphy, index) in gifsArray" :key="giphy" @click="sendToDB(index)" class="gif" :src="giphy" alt="Searched Gifs">
            </div>
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
        }
    },
    props :{
        tweetid : Number,
    },
    methods: {
        sendSearch: function(){
            var slugified = this.slugify(this.gifsearch);
            axios.get("http://api.giphy.com/v1/gifs/search?q=" + slugified + "&api_key=A58IGl1RDtLVlRaN69KZV7ndSBDWVhDR&limit=6")
            .then(response => {
                console.log(response.data.data);
                let newGifArray = response.data.data.map(gif =>{
                    return gif.images.downsized_medium.url;
                });
                this.gifsArray = newGifArray;
                this.gridToggle = true;
            })
            .catch(error => {
                console.log(error); // change to error message on screen
                });
        },
        sendToDB: function(index){
            console.log('send to DB has been called');
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
            })
            .catch(error => {
                console.log(error); // change to error message on screen
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
                console.log(error.quote); // change to error message on screen
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
    .gridContainer{

    }
/* in smaller screens put as position float bottom: 0; */
    .gifGrid{
        display: grid;
        grid-template-columns:1fr 1fr 1fr;
        grid-template-rows:1fr 1fr;
        justify-items: center;
        align-items: center;
        z-index: 10000;
    }
    .gif{
        width: 100%;
    }
</style>
