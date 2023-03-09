<template>
	<div class="friendChatCard">
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

<style lang="scss">
p{
	margin-top: 0;
	margin-bottom: 0;
}
.friendChatCard{
	/* border-top: 1px solid #d4d6da; */
	border-bottom: 1px solid #d4d6da;
	height: 100px;
	&:hover{
		background-color: rgba(0, 0, 0, 0.1);
	}
}
</style>