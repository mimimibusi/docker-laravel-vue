<template>
	<div>{{ title }}</div>
</template>

<script>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

export default{
	name: 'Setting',
	setup(){
		const title = ref('せっていだよー＾＾');
		const getCalendar = async ()=>{
			await axios.get('/api/Google_Calendar').then((res)=>{
				console.log(res);
			});
		}
		onMounted(()=>{
			getCalendar();
		})
		return {title}
	}
}
</script>