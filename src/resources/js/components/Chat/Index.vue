<template>
  <div>
    <h1>{{ title }}</h1>
	<div
		v-if="chattedRoomLists.length !== 0" v-for="chattedRoom in chattedRoomLists"
	>
		<Card :chattedRoom="chattedRoom" />
	</div>
  <div v-else>
    <button>新規チャット</button>
  </div>
  </div>
</template>

<script lang="ts">
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { ChatRoom } from './types';
import Card from './Card.vue';

export default({
  components:{
    Card
  },
  setup(){
    const title = 'チャット';
    const chattedRoomLists = ref<ChatRoom[]>([]);

    const getChattedRoomLists = async () => {
      axios.get('/getChattedRoomLists').then((res)=>{
        chattedRoomLists.value = res.data;
        console.log(chattedRoomLists.value);
      });
    }

    onMounted(()=>{
      getChattedRoomLists();
    })

    return {
      title,
      chattedRoomLists
    }
  }
})
</script>