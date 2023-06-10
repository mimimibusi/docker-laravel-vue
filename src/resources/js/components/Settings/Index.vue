<template>
	<div>{{ title }}</div>
	<Calendar />
	<a href="login/google-oauth">Google認証aタグ</a>
	<br>
	<button @click="createCalendarEvent"></button>
	<!-- <a href="login/google-oauth" v-if="accessTokenFlag">Google認証aタグ</a> -->
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
		const accessTokenFlag = ref(true); //vuexにユーザー情報持たせてそれで判定しても良いかも

		// const judgeHaveAccessToken = async ()=>{
		// 	await axios.get('/judgeHaveAccessToken').then((res)=>{
		// 		accessTokenFlag.value = res.data.result;
		// 		console.log(accessTokenFlag.value);
		// 	}).catch((error)=>{
		// 		console.log('うまくいかなかったです');
		// 	})
		// }

		const getCalendar = async ()=>{
			if (accessTokenFlag) {
				await axios.get('/googleCalendar').then((res)=>{
					// console.log(res);
				});
			}
		}

		const createCalendarEvent = async ()=>{
			await axios.post('/createCalendarEvent', {
				
			}).then((res)=>{
				// console.log(res);
			})
		}

		onMounted(()=>{
			// judgeHaveAccessToken();
			getCalendar();
		})
		return {
			title,
			accessTokenFlag,
			createCalendarEvent
		}
	}
}
</script>