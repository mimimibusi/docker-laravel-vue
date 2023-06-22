<template>
  <div id="overlay-modal" @click.self="$emit('deleteModal')">
    <div class="base-modal">
      <div class="edit-content">
        <span id="edit"  class="btn btn-primary btn-link" @click.stop="editEvent()">編集</span>
        <span id="delete" class="btn btn-primary btn-link" @click.stop="deleteEvent()">削除</span>
        <span id="close" class="btn btn-primary btn-link" @click.stop="$emit('deleteModal')">閉じる</span>
      </div>
      <div class="event-content">
        <h2>
          {{ event.name }}
        </h2>
        <span>
          {{ event.start }} 〜 {{ event.end }}
        </span>
      </div>
    </div>
  </div>
</template>

<script>
import { watch, ref, reactive, onMounted, computed } from 'vue';

export default({
  props:{
    event: Object,
    modalFlag: Boolean
  },
  name: 'EventModal',
  setup(){
    const editEvent = ()=>{
      console.log('editEvent');
    }
    const deleteEvent = ()=>{
      console.log('deleteEvent');
    }
    return{
      editEvent,
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
</style>