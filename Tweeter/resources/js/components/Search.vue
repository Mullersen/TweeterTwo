<template>
    <div id="search" class="card">
        <div class="card-body">
            <h2 class="my4">Search for a user by username or email</h2>
            <hr>
            <div class="form-group">
                <input class="form-control" v-model="searchedUsername" type="text" placeholder="Search for users">
            </div>
            <button class="btn btn-primary" @click="searchDB">Search</button>
            <div class="form-group" v-if="toggle">
                <h2 class="my-3">Your search found the following user</h2>
                <ul>
                    <li><h3 class="my-3">{{foundUsername}}</h3></li>
                </ul>
                <button class="btn btn-light"><a :href="url" :id="url">Go to {{foundUsername}}'s profile</a></button>
            </div>
            <div v-if="toggleTwo">
                <h3>The user you searched for might not exist in the database. Try again.</h3>
            </div>
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
                    console.log(response.data);
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
