<template>
  <div>
      <div class="row">
          <div class="col-4 bg-prime-light">
              <ul class=" list-group list-group-flush">
                  <li v-for="(follow, index) in follows" :key="follow.followed_user" @click="loadMessages(index)" class="list-group-item">{{follow.followed_user}}</li>
              </ul>
          </div>
          <div class="col-6 bg-light">
              <div v-if="messageToggle == true">
                  <h1>Messages with{{otherUser}}</h1>
                  <textarea v-model="messageContent" cols="10" rows="30"></textarea>
                  <button @click="sendMessage">Send</button>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
export default {
    name: "Messaging",
    data: function(){
        return{
            sender: String,
            content: String,
            messageToggle: false,
            follows: Array,
            otherUser: String,
            messageContent: String,
        }
    },
    methods: {
        loadMessages: function(index){
            this.messageToggle = true;
            this.otherUser = this.follows[index].followed_user;
            console.log(this.follows[index].followed_user);
            // axios.get('/messages/getMessages', {
            //     user : this.follows[index].followed_user,
            // })
            // .then(response => {
            //     console.log(response.data);
            //     // if(!Null){
            //     //     this.content = response.data.message;
            //     //     this.sender = response.data;
            //     // }
            // })
            // .catch(error => {
            //         console.log(error.message); // change to error message on screen
            //     });
        },
        sendMessage: function(){
            //console.log('send to DB has been called');
             axios.post('/message/sendMessage', {
                content : this.messageContent,
                receiver : this.otheruser,
                })
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.log(error); // change to error message on screen
                });
        }
    },
    beforeMount(){
        axios.get('/messages/getFollows')
            .then(response => {
                //console.log(response.data.follows);
                this.follows = response.data.follows;
            })
            .catch(error => {
                    console.log(error.message); // change to error message on screen
                });
    }
}
</script>

<style>






































</style>