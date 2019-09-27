<template>
	<div>
		<strong>Note: </strong><small> Click to download the file.</small>
		<div >
			<table class="table table-striped table-bordered" cellspacing="0" width="100%">
				<tbody>
					<tr v-for="file in files">
						<td @click="onDownload(file.id)">{{file.filename}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>
<script>
	export default {
		props: ['to_group', 'files'],
		methods: {
			onDownload(id){
				console.log(id)
				this.$parent.downloadFile(id)
			}
		}
	};
</script>