<template>
	<span class="badge badge-warning pull-right" v-if="unseencount != 0">{{unseencount}}</span>
</template>
<script>
	export default {
		props: ['unseencount']
	};
</script>