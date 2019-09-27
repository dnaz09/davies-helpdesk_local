<template>
  <div class="content"  v-chat-scroll>
    <div v-for="gmessage in gmessages">
      <div :class="{'right' : (gmessage.user.id == user.id) , 'left' : (gmessage.user.id != user.id) }">
        <div class="author-name"> 
            {{gmessage.user.first_name}} {{gmessage.user.last_name}}
          <small class="chat-date">
            {{gmessage.created_at}}  
          </small>
        </div>
        <div class="chat-message" :class="{'active' : (gmessage.user.id == user.id)}">
          {{gmessage.gmessage}}  
        </div>
      </div>
    </div>
  </div>
</template> 
<script>
export default {
  props: ['gmessages' , 'user' ,'group_id'],
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