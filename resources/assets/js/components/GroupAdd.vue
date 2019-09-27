<template>
	<div>
        <input type="text" name="group_name" class="form-control" placeholder="Enter Group Name..." v-model="group_name" @keyup.enter="createGroup" required><br>
        <div class="chat-users-list">
            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody v-for="user in users">
                    <tr v-if="user.id != curr_user.id">
                        <td>{{user.first_name}} {{user.last_name}}</td>
                        <td>
                            <input type="checkbox" v-model="user_id" :value="user.id">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div><br>
        <span>
        	<button class="btn btn-primary btn-sm" @click="createGroup">Create</button>
        </span>
	</div>
</template>

<script>
	export default {
		props: ['users', 'curr_user'],
		data () {
			return {
				user_id: [],
				group_name: ''
			}
		},
        created() {
        },
		methods: {
			createGroup () {
                if(this.group_name != '' || this.user_id != ''){
                    this.$emit('groupadd', {
                        group_name: this.group_name,
                        user_id: this.user_id
                    });
                    swal("Good job!", "Group Successfuly Created!", "success");
                    this.group_name = '';
                }else{
                    swal("Whoops!", "Error in Creating Group!", "warning");
                }
			}
		}
	};
</script>