<template>
  <div
    class="calendar-event"
    :style="`width:${event.width}%; background-color:blue;`"
    draggable="true"
    @dragstart="$emit('dragStart', $event, eventId)"
  >
  {{ event.summary }}
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
    eventId: String
  },
  name: 'CalendarEvent',
  emits: ['dragStart'],
})
</script>
