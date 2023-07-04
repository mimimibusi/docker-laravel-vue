<template>
  <div
    class="calendar-event"
    :style="`width:${event.width}%; background-color:${event.color};`"
    draggable="true"
    @dragstart="$emit('dragStart', $event, eventId)"
  >
  {{ event.name }}
  </div>
</template>

<script lang="ts">
import { ref } from 'vue';
import EventModal from './EventModal.vue';
import { Event } from './types'

export default({
  components:{
    EventModal
  },
  props:{
    event: {
      type: Object as ()=> Event,
      required: true
    },
    eventId: Number
  },
  name: 'CalendarEvent',
  emits: ['dragStart'],
})
</script>
