<template>
  <div>
    <h1>{{ title }}</h1>
  </div>
  <div class="chat-contents">
    <div class="chat-room-list">
      <div
        v-if="chattedRoomLists.length !== 0"
        v-for="(chattedRoom, index) in chattedRoomLists"
        :key="index"
        :class="{current: currentChatRoom === index}"
      >
      <Card
        :chattedRoom="chattedRoom"
        :index="index"
        @click="selectChatRoom(index)"
      />
      </div>
      <div v-else>
        <button>新規チャット</button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { ChatRoom, ChatData } from './types';
import Card from './Card.vue';

export default({
  components:{
    Card,
  },
  setup(){
    const title = 'チャット';
    const chattedRoomLists = ref<ChatRoom[]>([]);
    const currentChatRoom = ref<number>(0);

    const selectChatRoom = (id: number)=>{
      currentChatRoom.value = id;
    };

    const getChattedRoomLists = async () => {
      await axios.get('/getChattedRoomLists').then((res)=>{
        chattedRoomLists.value = res.data;
      });
    }

    onMounted(async ()=>{
      await getChattedRoomLists();
    })

    return {
      title,
      chattedRoomLists,
      currentChatRoom,
      selectChatRoom,
    }
  }
})
</script>

<style>
.chat-contents{
  display: flex;
}
.current{
  background-color: rgba(0, 0, 0, 0.1);
}
</style>