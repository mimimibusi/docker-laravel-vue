<template>
  <div class="chat-room-header">
    <span>{{ roomName }}</span>
  </div>
  <div class="chat-time-line">
    <div v-for="chat in chats">
      <span>{{ chat.message }}</span>
    </div>
  </div>
  <div class="chat-room-textarea">
    <form @submit.prevent="sendMessage">
      <input type="text" v-model="message">
      <input type="submit" value="送信">
    </form>
  </div>
</template>

<script lang="ts">
import { ChatData } from './types';
import { ref, SetupContext } from 'vue';
import axios from 'axios';

interface Props{
  roomName: string,
}

export default({
  name: 'Chat',
  props: {
    roomName: {
      type: String,
      required: true
    },
    chats: {
      type: Array as ()=> ChatData[],
      required: true
    }
  },
  emits: ['getChat'],
  setup(props: Props, context: SetupContext){
    const message = ref('');
    const sendMessage = async ()=>{
      const params = {
        sendMessage: message.value,
        roomName: props.roomName
      }
      axios.post('/sendMessage', {params: params}).then((res)=>{
        context.emit('getChat', props.roomName);
        message.value = '';
      });
    }
    return {
      message,
      sendMessage,
    }
  }
})
</script>