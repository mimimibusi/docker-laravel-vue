import { createRouter, createWebHistory } from 'vue-router';
import Friend from '../components/Friends/Index.vue';
import Setting from '../components/Settings/Index.vue';

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/friend',
      name: 'friend',
      component: Friend
    },
    {
      path: '/setting',
      name: 'setting',
      component: Setting
    }
  ]
})