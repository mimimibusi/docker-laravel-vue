<template>
  <div id="overlay-modal" @click.stop="$emit('deleteModal')">
    <div class="base-modal">
      <div class="edit-content">
        <router-link id="edit" :to="{name: 'eventEdit', params: {id: event.id, calendarId: event.calendarId}}">編集</router-link>
        <span id="delete" class="btn btn-primary btn-link" @click.stop="deleteEvent(event)">削除</span>
        <span id="close" class="btn btn-primary btn-link" @click.stop="$emit('deleteModal')">閉じる</span>
      </div>
      <div class="event-content">
        <h2>
          {{ event.summary }}
        </h2>
        <span>
          {{ event.start }} 〜 {{ event.end }}
        </span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Event } from './types';
import axios from 'axios';
import { key, strictInject } from './provider';

export default({
  props:{
    event: {
      type: Object as ()=> Event,
      required: true
    },
    modalFlag: Boolean
  },
  name: 'EventModal',
  setup(){
    const {
      events
    } = strictInject(key);

    const deleteEvent = (event: Event)=>{
      const params = {id: event.id, calendarId: event.calendarId};
      axios.delete('/deleteEvent', {params: params}).then(()=>{
        events.value = events.value.filter(function(event2: Event){
          return event2.id !== event.id;
        });
        alert(event.summary + 'イベントを削除しました');
      }).catch(()=>{
        alert('削除できませんでした');
      });
    }

    return{
      deleteEvent
    }
  }
})
</script>

<style>
#overlay-modal{
  /*　要素を重ねた時の順番　*/
  z-index:2;

  /*　画面全体を覆う設定　*/
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background-color:rgba(0,0,0,0);

  /*　画面の中央に要素を表示させる設定　*/
  display: flex;
  align-items: center;
  justify-content: center;

}

.base-modal{
  position: relative;
  z-index: 3;
  padding: 20px;
  /* width: 33%;
  height: 33%;
  min-width: 350px; */
  background-color: white;
  box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.5);
}

.edit-content{
  display: flex;
  /* justify-content: space-between; */
  justify-content: flex-end;
  gap: 12px;
}

.edit-content #edit{
  text-decoration: none;
  color: black;
}
</style>