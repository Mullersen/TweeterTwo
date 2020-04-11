<template>
  <div>
    <h2 class="text-center my-4">Your messages</h2>
    <h5 class="my-4">Click on a user below to start a conversation or add new users by following more</h5>
      <div class="row">
          <div class="col-4">
              <ul class=" list-group list-group-flush">
                  <li v-for="(follow, index) in follows" :key="follow.followed_user" @click="loadMessages(index)" class="list-group-item">{{follow.followed_user}}</li>
              </ul>
          </div>
          <div class="col-8 border rounded-sm">
              <div v-if="messageToggle == true">
                  <h2>Messages with {{otherUser}}</h2>
                  <div v-if="messages.length > -1">
                      <div v-for="message in messages" :key="message.id">
                          <div v-if="message.sender === otherUser">
                              <h5 class="text-right"><span class="badge badge-pill badge-light">{{message.message}}</span></h5>
                          </div>
                          <div v-else-if="message.sender === myUser">
                              <h5 class="text-left"><span class="badge badge-pill badge-light">{{message.message}}</span></h5>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                    <textarea class="form-control" id="newMessageText" v-model="messageContent" rows="3" placeholder="Write your message here"></textarea>
                    <button class="btn btn-outline-primary my-2" @click="sendMessage">Send</button>
                    <p v-if="errors.length">
                        <b>Please correct the following error(s):</b>
                        <ul>
                            <li v-for="error in errors" :key="error">{{ error }}</li>
                        </ul>
                    </p>
                  </div>
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
            messageContent: "",
            errors: [],
        }
    },
    methods: {
        loadMessages: function(index){
            this.messageToggle = true;
            this.otherUser = this.follows[index].followed_user;
            console.log("other user is: " +this.otherUser);
            var instance  = this;
            setInterval(function(){
                axios.post('/messages/getMessages', {
                    user : instance.otherUser,
                })
                .then(response => {
                    console.log(response.data);
                    instance.messages = response.data.messages;
                    instance.myUser = response.data.myUser;

                })
                .catch(error => {
                     console.log(error.message); // change to error message on screen
                    });
            }, 1000);
        },
        sendMessage: function(){

            if(!this.messageContent){
                 this.errors.push("Write something to send a message");
            } else {
                axios.post('/messages/sendMessage', {
                    content : this.messageContent,
                    receiver : this.otherUser,
                    })
                .then(response => {
                    console.log(response.data);
                    this.messageContent = "";
                    this.loadMessages();
                    this.errors = this.errors.splice(0,1);
                })
                .catch(error => {
                    console.log(error.message); // change to error message on screen
                    });
            }
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
