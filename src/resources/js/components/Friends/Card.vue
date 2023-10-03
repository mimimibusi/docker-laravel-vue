<template>
	<div class="card" @click="getDMRoom(friendData.name)">
		<p>{{ friendData.name }}</p>
	</div>
	<div v-show="modalFlag">
    <FriendModal
      :friendData="friendData"
			:existDMRoom="existDMRoom ? true : false "
      :modalFlag="modalFlag"
      @deleteModal="deleteModal"
    />
  </div>
</template>

<script lang="ts">
import { ref } from 'vue';
import FriendModal from './FriendModal.vue';
import { User } from '../../@types/chat';
import axios from 'axios';

export default({
	props:{
		friendData: {
			type: Object as ()=> User,
			required: true
		},
	},
	components:{
		FriendModal
	},
	setup(){
		const modalFlag = ref<boolean>(false);
    const existDMRoom = ref<boolean>(false);
		
		const getDMRoom = async (name: string)=>{
			await axios.get('/getDMRoom?friendName=' + name).then((res)=>{
				existDMRoom.value = res.data;
				modalFlag.value = true;
			})
		}

		const deleteModal = ()=>{
      modalFlag.value = false;
    }
		
		return {
			modalFlag,
			existDMRoom,
			getDMRoom,
			deleteModal
		}
	},
})
</script>

<style lang="scss">
p{
	margin-top: 0;
	margin-bottom: 0;
}
.card{
	/* border-top: 1px solid #d4d6da; */
	border-bottom: 1px solid #d4d6da;
	height: 100px;
	&:hover{
		background-color: rgba(0, 0, 0, 0.1);
	}
}
</style>