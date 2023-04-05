<template id="my-component-template">
  <div>
    <Calendar borderless />
    <DatePicker v-model="date" mode="dateTime" :rules="rules" />
    <h1>gg</h1>
  </div>
</template>

<script>
import { watch, ref, reactive } from 'vue';
import { Calendar, DatePicker } from 'v-calendar';
import 'v-calendar/style.css';

export default {
  components: {
    Calendar,
    DatePicker,
  },
  name: 'Calendar',
  setup(){
    let defaultDateTime = new Date();
    defaultDateTime.setHours(10);
    defaultDateTime.setMinutes(0);
    const date = ref(defaultDateTime);
    const rules = reactive({
      hours: { min: 7, max: 23},
      minutes: { interval: 5 },
    });
    watch(date, ()=>{
      console.log(defaultDateTime);
      console.log(date.value);
    })
    return {
      date,
      rules,
    }
  }
}

</script>