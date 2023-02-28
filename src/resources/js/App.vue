<template>
  <div>{{ hello }}</div>
  <router-link to="/friend">
    友達
  </router-link>
  <router-link to="/setting">
    設定
  </router-link>
  <router-view></router-view>
</template>

<script lang="ts">
import { onMounted, ref } from "vue";
import axios from "axios";
import Friend from "./components/Friends/Index.vue";
import Setting from "./components/Settings/Index.vue";
export default {
  components: {
    Friend,
    Setting,
  },
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