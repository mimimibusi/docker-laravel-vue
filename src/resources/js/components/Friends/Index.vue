<template>
	<div>{{ title }}</div>
</template>

<script>
import { ref, reactive } from 'vue';

export default{
	name: 'Friend',
	setup(){
		const title = ref('ともだちだよー＾＾');
		return {title}
	}
}
</script>