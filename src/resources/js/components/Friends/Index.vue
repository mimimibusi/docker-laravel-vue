<template>
	<h1>{{ title }}</h1>
	<div
		v-if="friendLists.length !== 0"
		v-for="friendList in friendLists"
	>
		<Card :friendData="friendList" />
	</div>
	<div v-else>友達いないおー；；</div>
</template>

<script>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios'
import Card from './Card.vue';

export default({
	components:{
		Card,
	},
	name: 'Friend',
	setup(){
		const title = '友達一覧';
		const friendLists = ref([]);
		const getFriends = async ()=>{
			await axios.get('/getFriends').then((res)=>{
				console.log(res.data);
				friendLists.value = res.data;
			});
			console.log(friendLists.value);
		}
		onMounted(()=>{
			getFriends();
		})
		return {title, friendLists}
	}
})
</script>