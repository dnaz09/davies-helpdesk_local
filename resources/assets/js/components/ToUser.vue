<template>
	<div v-if="to_user != null">
		<div class="fixed-to-user">
			{{to_user.first_name}} {{to_user.last_name}}
			<span class="badge badge-warning pull-right">{{sfcount}}</span>
		</div>
	</div>
</template>
<script>
	export default {
		props: ['to_user', 'sfcount']
	};
</script>