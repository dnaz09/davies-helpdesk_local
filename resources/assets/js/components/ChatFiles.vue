<template>
	<div v-if="to_user != null">
		<strong>Note: </strong><small> Click to download the files you shared with {{to_user.first_name}} {{to_user.last_name}}.</small><br>
		<div >
			<table class="table table-striped table-bordered" cellspacing="0" width="100%">
				<tbody>
					<tr v-for="sfile in sfiles">
						<td @click="onDownload(sfile.id)">{{sfile.filename}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>
<script>
	export default {
		props: ['to_user', 'sfiles'],
		methods: {
			onDownload(id){
				console.log(id)
				this.$parent.chatDownloadFile(id)
			}
		}
	};
</script>