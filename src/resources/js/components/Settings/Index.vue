<template>
	<div>{{ title }}</div>
	<a href="login/google-oauth">Google認証aタグ</a>
	<!-- <a href="login/google-oauth" v-if="accessTokenFlag">Google認証aタグ</a> -->
	<!-- <a href="auth/google" target="_blank" rel="noopener norefferrer">Google認証aタグ</a> -->
</template>

<script>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

export default{
	name: 'Setting',
	setup(){
		const title = ref('せっていだよー＾＾');
		const accessTokenFlag = ref(true); //vuexにユーザー情報持たせてそれで判定しても良いかも

		const judgeHaveAccessToken = async ()=>{
			await axios.get('/judgeHaveAccessToken').then((res)=>{
				accessTokenFlag.value = res.data.result;
				console.log(accessTokenFlag.value);
			}).catch((error)=>{
				console.log('うまくいかなかったです');
			})
		}

		const getCalendar = async ()=>{
			if (accessTokenFlag) {
				await axios.get('/googleCalendar').then((res)=>{
					console.log(res);
				});
			}
			console.log('せっていだしょー');
		}

		onMounted(()=>{
			judgeHaveAccessToken();
			getCalendar();
		})
		return {
			title,
			accessTokenFlag,
		}
	}
}
</script>