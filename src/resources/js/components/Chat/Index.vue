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
    <div class="chat-field">
      <Chat
        v-if="mount"
        :roomName="chattedRoomLists[currentChatRoom].roomName"
        :chats="chats"
        @getChat="getChat"
      />
    </div>
  </div>
</template>

<script lang="ts">
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { ChatRoom, ChatData } from './types';
import Card from './Card.vue';
import Chat from './Chat.vue';

export default({
  components:{
    Card,
    Chat,
  },
  setup(){
    const title = 'チャット';
    const chattedRoomLists = ref<ChatRoom[]>([]);
    const chats = ref<ChatData[]>([]);
    const currentChatRoom = ref<number>(0);
    const mount = ref<boolean>(false);

    const selectChatRoom = (id: number)=>{
      mount.value = false;
      currentChatRoom.value = id;
      getChat(chattedRoomLists.value[currentChatRoom.value].roomName);
      mount.value = true;
    };

    const getChattedRoomLists = async () => {
      await axios.get('/getChattedRoomLists').then((res)=>{
        chattedRoomLists.value = res.data;
        mount.value = true;
      });
    }

    const getChat = async (roomName: string)=>{
      await axios.get('/getChats?currentRoomName=' + roomName).then((res)=>{
        chats.value = res.data;
        console.log(res.data);
      });
    }

    onMounted(async ()=>{
      await getChattedRoomLists();
      await getChat(chattedRoomLists.value[currentChatRoom.value].roomName);
    })

    return {
      title,
      chattedRoomLists,
      chats,
      currentChatRoom,
      mount,
      selectChatRoom,
      getChat,
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