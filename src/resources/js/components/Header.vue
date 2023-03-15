<template>
	<div class="headerTab">
		<!-- <el-menu
			:default-active="'/friend'"
			mode="horizontal"
			router
		>
			<el-menu-item
				v-for="(route, key) in routes"
				:key="key"
				:route="{ path: route.path }"
				:index="route.path"
				v-show="!route.hidden"
			>
				<span>{{ route.label }}</span>
			</el-menu-item>
		</el-menu> -->
		<router-link to="/friend">
			友達
		</router-link>
		<router-link to="/setting">
			設定
		</router-link>
	</div>
</template>

<script>
import { ref, onMounted } from 'vue';
export default{
	name: 'Header',
	setup(){
		const routes = [
			{label: '友達', path: '/friend'},
			{label: '設定', path: '/setting'}
		];
		const activeIndex = ref('');
		onMounted(()=>{
			console.log(activeIndex.value);
		});
		return {routes, activeIndex};
	}
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