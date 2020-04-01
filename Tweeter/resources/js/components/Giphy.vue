<template>
    <div>
        <input v-model="gifsearch" placeholder="Search for a GIF">
        <button @click="sendSearch" class="btn btn-primary btn-sm ml-2 rounded-pill">comment with GIF</button>
        <div id="gifs">
            <img @click="sendToDB" :src="gifs" :alt="gifsearch">
        </div>
    </div>
</template>

<script>
export default {
    name : "Giphy",
    data: function(){
        return {
            gifsearch: "",
            gifs: String,
        }
    },
    props :{
        tweetid : Number,
    },
    methods: {
        sendSearch: function(){
            var slugified = this.slugify(this.gifsearch);
            axios.get("http://api.giphy.com/v1/gifs/search?q="+ slugified + "&api_key=A58IGl1RDtLVlRaN69KZV7ndSBDWVhDR&limit=6")
            .then(response => {
                console.log(response.data);
                this.gifs = response.data.data[0].images.original.url;
            })
            .catch(error => {
                console.log(error); // change to error message on screen
                });
        },
        sendToDB: function(){
            console.log('send to DB has been called');
             axios.post('/comment/addGifComment', {
                id : this.tweetid,
                URL : this.gifs,
                })
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.log(error); // change to error message on screen
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

<style>

</style>
