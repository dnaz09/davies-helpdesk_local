<template>
    <div class="input-group input-group-sm">
        <textarea type="text" name="message" class="form-control" placeholder="Type your message here..." v-model="newMessage" @keydown="handleMessageInput"></textarea>
        
        <span class="input-group-btn">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
                Send
            </button>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['user','to_id'],

        data() {
            return {
                newMessage: '',
                d: new Date()
            }
        },
       
        methods: {
            handleMessageInput(e) {
                if(e.keyCode === 13 && !e.shiftKey){
                    e.preventDefault();
                    this.sendMessage();
                }
            },
            sendMessage() {
                if(this.newMessage != ''){
                    this.$emit('messagesent', {
                    user: this.user,
                    created_at: this.d.getFullYear() + "-" + (this.d.getMonth()+1) + "-" + this.d.getDate() + " " +
                                this.d.getHours() + ":" + this.d.getMinutes() + ":" + this.d.getSeconds(),
                    message: this.newMessage,
                    to_id :this.to_id
                });

                this.newMessage = ''
                }else{
                    swal("Whoops!", "Cannot send a blank message!", "warning");
                }
            }
        }    
    };
</script>
