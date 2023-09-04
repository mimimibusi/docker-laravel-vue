<template>
	<div class="friend-chat-card" @click="viewModal()">
		<p>{{ friendData.name }}</p>
	</div>
	<div v-show="modalFlag">
    <FriendModal
      :friendData="friendData"
      :modalFlag="modalFlag"
      @deleteModal="deleteModal"
    />
  </div>
</template>

<script lang="ts">
import { ref } from 'vue';
import FriendModal from './FriendModal.vue';
import { User } from './types';

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

		const viewModal = ()=>{
			modalFlag.value = true;
		}

		const deleteModal = ()=>{
      modalFlag.value = false;
    }
		
		return {
			modalFlag,
			viewModal,
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
.friend-chat-card{
	/* border-top: 1px solid #d4d6da; */
	border-bottom: 1px solid #d4d6da;
	height: 100px;
	&:hover{
		background-color: rgba(0, 0, 0, 0.1);
	}
}
</style>