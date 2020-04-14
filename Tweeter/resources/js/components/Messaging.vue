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
                  <h1>Messages with {{otherUser}}</h1>
                  <div v-if="messages.length > -1">
                      <div v-for="message in messages" :key="message.id">
                          <div v-if="message.sender === otherUser || message.receiver === myUser">
                              <p class="text-right">{{message.message}}</p>
                          </div>
                          <div v-else-if="message.sender === myUser || message.receiver === otherUser">
                              <p class="text-left">{{message.message}}</p>
                          </div>
                      </div>
                  </div>
                  <textarea v-model="messageContent" rows="4" placeholder="write you text here"></textarea>
                  <button @click.once="sendMessage">Send</button>
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
            messages: Array,
            messageToggle: false,
            follows: Array,
            myUser: String,
            otherUser: String,
            messageContent: String,
        }
    },
    methods: {
        loadMessages: function(index){
            this.messageToggle = true;
            this.otherUser = this.follows[index].followed_user;
            console.log("other user is: " +this.otherUser);
            axios.post('/messages/getMessages', {
                user : this.otherUser,
            })
            .then(response => {
                console.log(response.data);
                this.messages = response.data.messages;
                this.myUser = response.data.myUser;

            })
            .catch(error => {
                    console.log(error.message); // change to error message on screen
                });
        },
        sendMessage: function(){
            //console.log('send to DB has been called');
             axios.post('/messages/sendMessage', {
                content : this.messageContent,
                receiver : this.otherUser,
                })
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.log(error.message); // change to error message on screen
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
#floatRight{
    text-align: left;
}
#floatLeft{
    text-align: right;
}
</style>
