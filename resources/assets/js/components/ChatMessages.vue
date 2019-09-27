<template>
  <div class="content" v-chat-scroll>
    <div v-for="message in messages">
      <div :class="{'right' : (message.user.id == user.id) , 'left' : (message.user.id != user.id) }">
        <div class="author-name"> {{message.user.first_name}} {{message.user.last_name}}
          <small class="chat-date">
            {{ message.created_at }}
          </small>
        </div>
        <div class="chat-message" :class="{'active' : (message.user.id == user.id)}">
          {{ message.message }}  
        </div>
      </div>
    </div>
  </div>
</template> 

<script>
export default {
  props: ['messages' , 'user' ,'to_id', 'to_user'],
  created(){  
  },
 
  methods:{
    scrollDown: function(){
      var elem = this.$el
      elem.scrollTop = elem.scrollHeight;
      console.log(elem.scrollTop + " " + elem.scrollHeight);
    }
  },       
};
</script>