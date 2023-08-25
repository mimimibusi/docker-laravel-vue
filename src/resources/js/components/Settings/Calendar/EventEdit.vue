<template>
  <div class="summary_edit">
    <h1 @click="test()">んgぱんrgぽん</h1>
    <form @submit.prevent="updateEvent">
      <div>
        <label for="summary">タイトル</label>
        <input type="text" name="summary" v-model="event.summary">
      </div>
      <div>
        <label for="start">Start Date:</label>
        <input type="date" name="start" id="start" v-model="event.start" required>
      </div>
      <div>
        <label for="end">End Date:</label>
        <input type="date" name="end" id="end" v-model="event.end" required>
      </div>
      <input type="submit" value="保存">
    </form>
    <button class="delete-button" type="submit" @click="deleteEvent()">削除</button>
  </div>
</template>

<script lang="ts">
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { Event } from './types';
import moment from 'moment';
import { useRouter } from 'vue-router';

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
    const router = useRouter();

    const event = ref<Event>({
      id: '',
      summary: '',
      start: '',
      end: '',
      calendarId: ''
    });

    const test = ()=>{
      console.log('props.id');
      console.log(props.id);
    }

    const getEvent = ()=>{
      const params = {
        id: props.id,
        calendarId: props.calendarId
      }
      axios.get('/getEditEvent', {params: params}).then((res)=>{
        const result = formatEvent(res.data);
        event.value = result;
        console.log(event.value);
      });
    }

    const formatEvent = (event: Event)=>{
      const start = moment(event.start).format('YYYY-MM-DD');
      const end = moment(event.end).format('YYYY-MM-DD');
      event.start = start;
      event.end = end;
      return event;
    }

    const updateEvent = async ()=>{
      await axios.put('/updateEvent', event.value).then((res)=>{
        router.push('../');
      }).catch(()=>{
        alert('更新できませんでした');
      })
    }

    const deleteEvent = async ()=>{
      const params = {id: event.value.id, calendarId: event.value.calendarId};
      axios.delete('/deleteEvent', {params: params}).then(()=>{
        router.push('../');
      }).catch(()=>{
        alert('削除できませんでした');
      });
    }

    onMounted(()=>{
      getEvent();
    });
    return {
      event,
      test,
      updateEvent,
      deleteEvent
    }
  }
});
</script>

<style>
.delete-button{
  background-color: red;
  color: white;
}
</style>