<template>
	<div>{{ title }}</div>
</template>

<script>
import { ref, reactive } from 'vue';

export default{
	name: 'Setting',
	setup(){
		const title = ref('せっていだよー＾＾');
		return {title}
	}
}
</script>