<template>
	<div>
		<input type="file" class="form-control fileclass" @change="onFileSelected">
		<button class="btn btn-sm btn-primary" @click="onUpload">Upload</button>
	</div>
</template>
<script>
	export default{
		props: ['user','to_id'],
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
				fd.append('to_id', this.to_id)
				fd.append('user', this.user)
				this.$emit('singlefilesend', fd);
			}
		}
		
	};
</script>