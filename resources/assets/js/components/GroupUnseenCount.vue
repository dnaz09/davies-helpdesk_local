<template>
	<span class="badge badge-warning pull-right" v-if="gunseencount != 0">{{gunseencount}}</span>
</template>
<script>
	export default {
		props: ['gunseencount']
	};
</script>