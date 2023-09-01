<template>
	<div>
    <h1>{{ title }}</h1>
		<router-link to="/setting/calendar">予定</router-link>
    <br>
    <a href="login/google-oauth">Google認証aタグ</a>
	</div>
</template>

<script lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default({
	name: 'Setting',
	setup(){
		const title = '設定';
		const accessTokenFlag = ref<boolean>(true); //vuexにユーザー情報持たせてそれで判定しても良いかも

		// const judgeHaveAccessToken = async ()=>{
		// 	await axios.get('/judgeHaveAccessToken').then((res)=>{
		// 		accessTokenFlag.value = res.data.result;
		// 		console.log(accessTokenFlag.value);
		// 	}).catch((error)=>{
		// 		console.log('うまくいかなかったです');
		// 	})
		// }


		onMounted(()=>{
			// judgeHaveAccessToken();
		})
		return {
			title,
			accessTokenFlag
		}
	}
})
</script>
