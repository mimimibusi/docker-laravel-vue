<template>
  <div
    class="calendar-event"
    :style="`width:${event.width}%; background-color:${event.color};`"
    draggable="true"
    @dragstart="$emit('dragStart', $event, eventId)"
    @click="showModal()"
  >
  {{ event.name }}
  </div>
  <EventModal
    v-show="modalFlag"
    :event="event"
    @deleteModal="deleteModal"
  />
</template>

<script>
import { watch, ref, reactive, onMounted, computed } from 'vue';
import EventModal from './EventModal';

export default({
  components:{
    EventModal
  },
  props:{
    event: Object,
    eventId: Number
  },
  name: 'CalendarEvent',
  emits: ['dragStart'],
  setup(){
    const modalFlag = ref(false);
    const showModal = ()=>{
      console.log('showModal');
      modalFlag.value = true;
    }
    const deleteModal = ()=>{
      console.log('deleteModal');
      modalFlag.value = false;
    }
    return {
      modalFlag,
      showModal,
      deleteModal
    }
  }
})
</script>
