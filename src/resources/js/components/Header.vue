<template>
	<div class="headerTab">
		<router-link to="/friend">
			友達
		</router-link>
		<router-link to="/setting">
			設定
		</router-link>
	</div>
</template>

<script>
import { ref } from 'vue';
export default{
	name: 'Header',
}
</script>
<style scoped>
.headerTab{
	display: flex;
	justify-content: space-around;
	border: 1px solid #d4d6da;
	box-shadow: 0px 4px 2px -1px rgba(0,0,0,0.5);
}
</style>