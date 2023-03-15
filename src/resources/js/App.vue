<template>
  <Header />
  <div>{{ hello }}</div>
  <router-view></router-view>
</template>

<script lang="ts">
import { onMounted, ref } from "vue";
import axios from "axios";
import Header from "./components/Header.vue";
import Friend from "./components/Friends/Index.vue";
import Setting from "./components/Settings/Index.vue";
export default {
  components: {
    Header,
    Friend,
    Setting,
  },
  setup() {
    const hello = ref<string>(
      "TypeScript"
    );
    const getUsers = async () => {
      console.log('test');
      const {data} = await axios.get('/api/index', {params: {id: 1}});
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
