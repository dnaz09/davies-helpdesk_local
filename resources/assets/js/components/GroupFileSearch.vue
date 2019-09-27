<template>
	<div class="col-md-12">
    	<input type="text" class="form-control" v-model="search" placeholder="Name of file...">
	</div>
</template>
<script>
	export default {
		props: ['group_id'],
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
				if(this.search != ''){
					this.$parent.fileSearch(this.search, this.group_id);
				}else{
					this.$parent.getGroupFiles(this.group_id);
				}
			}
		}
	};
</script>