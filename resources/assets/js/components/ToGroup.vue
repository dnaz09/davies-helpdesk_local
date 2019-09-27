<template>
	<div v-if="to_group != null">
		<div class="fixed-to-user">
			{{to_group.group_name}}
		</div>
		<!-- <a href="#" @click="getMembers(group_id)" data-toggle="modal" data-target="#viewMembersModal">Members</a> -->
		<span class="badge badge-warning pull-right">{{fcount}}</span>
	</div>
</template>
<script>
	export default {
		props: ['to_group','fcount','group_id'],
		methods: {
			getMembers(id){
				this.$parent.getGroupMembers(id)
			}
		}
	};
</script>