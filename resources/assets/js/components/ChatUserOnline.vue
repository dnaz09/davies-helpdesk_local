<template>
<div>
    <div class="users-list" v-for="online in onlines">
        <div class="chat-user" v-bind:class="{ active1: online.active }"  v-on:click="SelectOfUser(online)">
            <!-- <img class="chat-avatar" src="images/user.png" alt=""> -->
           <span class="pull-right label label-primary" v-if="online.online == 1"><i></i></span>
           <span class="pull-right label label-danger" v-if="online.online != 1"><i></i></span>
            <div class="chat-user-name">
                <a href="#" @click="getMessages(online.id)" v-if="!unseen.includes(online.id)">{{ online.first_name }} {{ online.last_name }}</a>
                <a href="#" @click="getMessages(online.id)" v-if="unseen.includes(online.id)"><strong>{{ online.first_name }} {{ online.last_name }}</strong></a>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
      props: [ 'onlines','user','unseen'],
      methods: {
        getMessages(id) {
          this.$parent.fetchMessages(id)            
        },
        SelectOfUser:function(online){
          this.searchForActive();
          online.active = !online.active;    
        },
        searchForActive(){
          for(var i=0 ; i<this.onlines.length; i++){
            if(this.onlines[i].active == true){

            this.onlines[i].active = false;
                 
            }
          }
        }
      }
    };
</script>
