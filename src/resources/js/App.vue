<template>
  <Header />
  <div>{{ hello }}</div>
  <div>{{ user }}</div>
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
    const user = ref<string>('');
    const getUsers = async () => {
      const {data} = await axios.get('/index');
      console.log(data);
      user.value = data.name;
    }
    onMounted(()=>{
      getUsers();
    })
    return {
      hello,
      user
    };
  },
};
</script>
