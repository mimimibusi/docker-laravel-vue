<template>
	<div>
		<p>{{ friendList.name }}</p>
	</div>
</template>

<script>
import { ref, reactive } from 'vue';
export default{
	props:{
		friendList: Object,
	},
	setup(props){
	},
}
</script>