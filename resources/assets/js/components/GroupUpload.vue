<template>
	<div>
		<input type="file" class="form-control" @change="onFileSelected">
		<button class="btn btn-sm btn-primary" @click="onUpload">Upload</button>
	</div>
</template>
<script>
	export default{
		props: ['user','group_id'],
		data() {
			return {
				selectedFile: null,
				file:''
			}
		},
		methods: {
			onFileSelected(e){
				this.selectedFile = e.target.files[0]
			},
			onUpload(){
				const fd = new FormData();
				fd.append('file', this.selectedFile, this.selectedFile.name)
				fd.append('group_id', this.group_id)
				fd.append('user', this.user)
				this.$emit('filesend', fd);
			}
		}
		
	};
</script>