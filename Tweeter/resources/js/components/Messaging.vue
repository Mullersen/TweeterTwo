<template>
  <div id="messagesPage">
    <h2 class="text-center my-4">Your inbox</h2>
    <h5 class="my-4">Click on a user below to start a conversation or add new users by following more</h5>
      <div class="row">
          <div class="col-sm-4">
              <ul class=" list-group list-group-flush">
                  <li v-for="(follow, index) in follows" :key="follow.followed_user" @click="loadMessages(index)" class="list-group-item">{{follow.followed_user}}</li>
              </ul>
          </div>
          <div class="col-sm-8 border rounded-sm">
              <div v-if="messageToggle == true">
                  <h2>Messages with {{otherUser}}</h2>
                      <div id="v-for-object">
                            <div v-for="message in messages" :key="message.id">
                                <h5 v-if="message.sender == myUser" ><span style="display:block; text-align:left" class="badge badge-pill badge-light">From {{message.sender}} {{message.message}} {{message.created_at}}</span></h5>
                                <h5 v-else><span style="display:block; text-align:right" class="badge badge-pill badge-light">{{message.message}}</span></h5>
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
            messages: Object,
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
                    console.log(response.data.messages);
                    instance.messages = response.data.messages;
                    instance.myUser = response.data.myUser;
                    // for (var i=0; i<= response.data.messages.length; i++){
                    //     if (response.data.messages[i].sender == instance.MyUser){

                    //     }
                    // }
                })
                .catch(error => {
                     console.log(error.message);
                     document.getElementById("messagesPage").innerHTML = "<h1>Oops there seem to have been an error. Reload to try again</h1>" + error.message;
                    });
            }, 1000);
        },
        sendMessage: function(){
            if(this.errors.length >=1){
                    this.errors.splice(0,1);
                };
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
                })
                .catch(error => {
                    console.log(error.message);
                    //document.getElementById("messagesPage").innerHTML = "<h1>OOps there seem to have been an error. reload to try again</h1>" + error.message;
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
                    console.log(error.message);
                    document.getElementById("messagesPage").innerHTML = "<h1>OOps there seem to have been an error. reload to try again</h1>" + error.message;
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
