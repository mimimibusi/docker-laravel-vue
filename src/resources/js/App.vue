<template>
    <div>
        <Header />
        <div>{{ hello }}</div>
        <div>{{ user }}</div>
        <router-view></router-view>
    </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from "vue";
import axios from "axios";
import Header from "./components/Header.vue";
import Friend from "./components/Friends/Index.vue";
import Setting from "./components/Settings/Index.vue";
export default defineComponent({
    components: {
        Header,
        Friend,
        Setting,
    },
    setup() {
        const hello = ref("TypeScript");
        const user = ref("");
        const getUsers = async () => {
            const { data } = await axios.get("/index");
            console.log(data);
            user.value = data.name;
        };
        onMounted(() => {
            getUsers();
        });
        return {
            hello,
            user,
        };
    },
});
</script>
