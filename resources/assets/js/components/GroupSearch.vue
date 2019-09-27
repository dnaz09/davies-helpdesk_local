<template>
    <div class="col-md-12">
    	<input type="text" class="form-control" v-model="search" placeholder="Enter Group Name...">
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
				this.searchGroup()
			}
		},
		methods: {
			searchGroup() {
				this.$parent.groupSearch(this.search);
			}
		}
	};
</script>