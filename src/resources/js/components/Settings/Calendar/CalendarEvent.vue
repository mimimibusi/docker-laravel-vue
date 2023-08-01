<template>
  <div
    class="calendar-event"
    :style="`width:${event.width}%; background-color:blue;`"
    draggable="true"
    @dragstart="$emit('dragStart', $event, eventId)"
    @click.stop="viewModal()"
  >
  {{ event.summary }}
  </div>
  <div v-show="modalFlag">
    <EventModal
      :event="event"
      :modalFlag="modalFlag"
      @deleteModal="deleteModal"
    />
  </div>
</template>

<script lang="ts">
import { ref } from 'vue';
import EventModal from './EventModal.vue';
import { Event } from './types';

export default({
  components:{
    EventModal
  },
  props:{
    event: {
      type: Object as ()=> Event,
      required: true
    },
    eventId: String
  },
  name: 'CalendarEvent',
  emits: ['dragStart'],
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
  }
})
</script>
