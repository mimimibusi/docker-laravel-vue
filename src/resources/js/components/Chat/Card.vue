<template>
	<div class="card">
		<p>{{ chattedRoom.roomName }}</p>
	</div>
</template>

<script lang="ts">
import { ChatRoom } from './types';

export default({
  name: 'Card',
  props:{
    chattedRoom: {
      type: Object as ()=> ChatRoom,
      required: true
    },
  },
});
</script>