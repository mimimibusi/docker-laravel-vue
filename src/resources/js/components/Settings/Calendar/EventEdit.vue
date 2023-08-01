<template>
  <div class="summary_edit">
    <h1 @click="test()">んgぱんrgぽん</h1>
    <textarea name="summary" id="" cols="30" rows="10">{{ event?.summary }}</textarea>
  </div>
</template>

<script lang="ts">
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { Event } from './types';

interface Props{
  id: string,
  calendarId: string
}

export default({
  props: {
    id: String,
    calendarId: String
  },
  setup(props: Props){
    const event = ref<Event>();

    const test = ()=>{
      console.log('props.id');
      console.log(props.id);
    }

    onMounted(async ()=>{
      const params = {
        id: props.id,
        calendarId: props.calendarId
      }
      await axios.get('/getEditEvent', {params: params}).then((res)=>{
        event.value = res.data;
      });
      console.log(event.value);
    });
    return {
      test,
      event
    }
  }
});
</script>