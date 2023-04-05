<template>
	<div>{{ title }}</div>
	<Calendar />
</template>

<script>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';
import Calendar from './Calendar.vue';

export default{
	components: {
		Calendar
	},
	name: 'Setting',
	setup(){
		const title = ref('せっていだよー＾＾');
		const getCalendar = async ()=>{
			// await axios.get('/api/Google_Calendar').then((res)=>{
			// 	console.log(res);
			// });
			console.log('せっていだしょー');
		}
		onMounted(()=>{
			getCalendar();
		})
		return {title}
	}
}
</script>