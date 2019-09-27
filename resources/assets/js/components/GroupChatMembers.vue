<template>
	<div>
        <input type="text" v-model="search" class="form-control" placeholder="Enter Name of User...">
    	<table class="table table-striped table-bordered" cellspacing="0" width="100%">
    		<thead>
    			<tr>
    				<th>Name</th>
    				<th>Action</th>
    			</tr>
    		</thead>
    		<tbody v-for="member in members">
    			<tr>
    				<td>{{member.first_name}} {{member.last_name}}</td>
    				<td>
    					<input type="checkbox" v-model="user_id" :value="member.id">
    				</td>
    			</tr>
    		</tbody>
    	</table>
        <span>
        	<button class="btn btn-danger btn-sm" @click="removeMember(user_id, group.id)">Remove</button>
        </span>
	</div>
</template>

<script>
	export default {
		props: ['members', 'group'],
		data () {
			return {
				user_id: [],
				group_id: '',
                search: null
			}
		},
        watch: {
            search(after, before){
                this.searchUser()
            }
        },
		methods: {
			removeMember (user_id, group_id) {
                if(this.user_id != ''){
                    swal("Good job!", "Group Successfuly Created!", "success");
                    this.$parent.removeGroupMember(user_id,group_id)
                }else{
                    swal("Whoops!", "Error in Removing user!", "warning")
                }
			},
            searchUser() {
                if(this.search != '')
                {
                    this.$parent.searchMember(this.search, this.group.id);
                }else{
                    this.$parent.getGroupMembers(this.group.id)
                }
            }
		}
	};
</script>