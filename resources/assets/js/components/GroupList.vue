<template>
<div>
    <div class="users-list" v-for="group in groups">
		<div class="chat-user chat-user-group">
        	<span class="pull-right label label-primary">
        		<a href="#" @click="getMembers(group.id)" data-toggle="modal" data-target="#viewMembersModal">Members</a>
        	</span>
        	<div class="chat-user-name">
            	<a href="#" @click="getGroupMessages(group.id)" v-if="!gunseen.includes(group.id)">{{ group.group_name }}</a>
            	<a href="#" @click="getGroupMessages(group.id)" v-if="gunseen.includes(group.id)"><strong>{{ group.group_name }}</strong></a>
        	</div>
        </div>
	</div>
</div>
</template>

<script>
	export default {
		props: ['groups', 'user', 'gunseen'],
		methods: {
			getGroupMessages(id) {
				this.$parent.fetchGroupMessages(id)
			},
			getMembers(id){
				this.$parent.getGroupMembers(id)
				this.$parent.getNonMembers(id)
			}
		}
	};
</script>