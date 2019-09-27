<template>
    <div class="col-md-12">
    	<input type="text" class="form-control" v-model="search" placeholder="Enter Name of User...">
	</div>
</template>
<script>
	export default {
		props: [],
		data() {
			return {
				search: ''
			}
		},
		watch: {
			search(after, before){
				this.searchUser()
			}
		},
		methods: {
			searchUser() {
				if(this.search != '')
				{
					this.$parent.memberSearch(this.search);
				}else{
					// this.$parent.getAllOnlineUser();
				}
			}
		}
	};
</script>