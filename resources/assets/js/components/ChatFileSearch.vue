<template>
	<div class="col-md-12">
    	<input type="text" class="form-control" v-model="search" placeholder="Name of file...">
	</div>
</template>
<script>
	export default {
		props: ['to_id', 'user'],
		data() {
			return {
				search: null
			}
		},
		watch: {
			search(after, before){
				this.searchUser()
			}
		},
		methods: {
			searchUser() {
				this.$parent.chatFileSearch(this.search, this.to_id, this.to_user);
			}
		}
	};
</script>