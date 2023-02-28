<template>
  <div>{{ hello }}</div>
</template>

<script lang="ts">
import { onMounted, ref } from "vue";
import axios from "axios"
export default {
  setup() {
    const hello = ref<string>(
      "TypeScript"
    );
    const getUsers = async () => {
      console.log('test');
      const {data} = await axios.get('/index', {params: {id: 1}});
      console.log(data);
    }
    onMounted(()=>{
      getUsers();
    })
    return {
      hello
    };
  },
};
</script>