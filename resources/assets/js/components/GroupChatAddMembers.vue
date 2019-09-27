<template>
	<div>
        <input type="text" v-model="search" class="form-control" placeholder="Enter Name of User...">
        <div class="chat-users-list">
            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody v-for="nonmemb in nonmembs">
                    <tr>
                        <td>{{nonmemb.first_name}} {{nonmemb.last_name}}</td>
                        <td>
                            <input type="checkbox" v-model="user_id" :value="nonmemb.id">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div><br>
        <span>
        	<button class="btn btn-primary btn-sm" @click="addMembers(user_id, group.id)">Add User</button>
        </span>
	</div>
</template>

<script>
	export default {
		props: ['nonmembs', 'curr_user', 'group'],
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
			addMembers (user_id, group_id) {
                if(this.user_id != ''){
                    this.$parent.addGroupMembers(user_id, group_id);
                    swal("Good job!", "Group Successfuly Created!", "success");
                }else{
                    swal("Whoops!", "Error in Creating Group!", "warning");
                }
			},
            searchUser() {
                if(this.search != '')
                {
                    this.$parent.searchNonMember(this.search, this.group_id);
                }else{
                    this.$parent.getNonMembers(this.group_id)
                }
            }
		}
	};
</script>