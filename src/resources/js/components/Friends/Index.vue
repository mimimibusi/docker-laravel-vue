<template>
	<div>{{ title }}</div>
	<div
		v-for="friendList in friendLists"
	>
		<Card :friendList="friendList" />
	</div>
</template>

<script>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios'
import Card from './Card.vue';

export default{
	components:{
		Card,
	},
	name: 'Friend',
	setup(){
		const title = ref('ともだちだよー＾＾');
		const friendLists = ref([]);
		const getFriends = async ()=>{
			await axios.get('/getFriends', {params: {id: 1}}).then((res)=>{
				res.data.forEach((friendData)=>{
					friendLists.value.push(friendData);
				})
			});
			console.log(friendLists.value);
		}
		onMounted(()=>{
			getFriends();
		})
		return {title, friendLists}
	}
}
</script>