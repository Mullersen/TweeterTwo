<template>
    <div id="search">
        <input v-model="searchedUsername" type="text" placeholder="Search for users">
        <button @click="searchDB">Search</button>
        <div v-if="toggle">
            <h1>{{foundUsername}}</h1>
            <button><a :href="url" :id="url">Go to {{foundUsername}}'s profile</a></button>
        </div>
        <div v-if="toggleTwo">
            <h2>The username you searched for might not exist in the database. Try again.</h2>
        </div>
    </div>
</template>

<script>
export default {
    name: "Search", 
    data: function(){
        return{
            searchedUsername: "", 
            foundUsername: "",
            foundUserId: Number,
            toggle: false,
            toggleTwo: false,
            url: "",
        }
    }, 
    methods: {
        searchDB: function(){
            axios.post('/search/searchUsername', {
                    username: this.searchedUsername,
                    })
                .then(response => {
                    console.log(response.data.users[0].id);
                    this.foundUsername = response.data.users[0].name;
                    this.foundUserId = response.data.users[0].id;
                    this.url = '/profile/show/' + response.data.users[0].id;
                    this.toggle = true; 
                    if(this.toggleTwo == true){
                        this.toggleTwo = false;
                    }
                })
                .catch(error => {
                    this.toggleTwo = true;
                    if(this.toggle == true){
                        this.toggle = false;
                    }
                    console.log(error.message);
                    });
        }
    }

}
</script>

<style>

</style>