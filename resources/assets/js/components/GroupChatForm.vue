<template>
    <div class="input-group input-group-sm">
        <textarea type="text" class="form-control" placeholder="Type your message here..." v-model="newGroupMessage" @keydown="handleInputMessage"></textarea>
        
        <span class="input-group-btn">
            <button class="btn btn-primary btn-sm" @click="sendGMessage">
                Send
            </button>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['user','group_id'],

        data() {
            return {
                newGroupMessage: '',
                d: new Date()
            }
        },
       
        methods: {
            handleInputMessage(e) {
                if(e.keyCode === 13 && !e.shiftKey){
                    e.preventDefault();
                    this.sendGMessage();
                }
            },
            sendGMessage() {
                if(this.newGroupMessage != ''){
                    this.$emit('groupmessagesent', {
                        user: this.user,
                        created_at: this.d.getFullYear() + "-" + (this.d.getMonth()+1) + "-" + this.d.getDate() + " " +
                                    this.d.getHours() + ":" + this.d.getMinutes() + ":" + this.d.getSeconds(),
                        gmessage: this.newGroupMessage,
                        group_id :this.group_id
                    });
                    this.newGroupMessage = ''
                }else{
                    swal("Whoops!", "Cannot send a blank message!", "warning");
                }
            }
        }    
    };
</script>
