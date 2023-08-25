import { createRouter, createWebHistory } from 'vue-router';
import App from '../App.vue'
import Friend from '../components/Friends/Index.vue';
import Setting from '../components/Settings/Index.vue';
import Calendar from '../components/Settings/Calendar/Calendar.vue';
import EventEdit from '../components/Settings/Calendar/EventEdit.vue';

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/:catchAll(.*)',
      redirect: '/friend'
    },
    {
      path: '/friend',
      name: 'friend',
      component: Friend
    },
    {
      path: '/setting',
      name: 'setting',
      component: Setting
    },
    {
      path: '/setting/calendar',
      name: 'calendar',
      component: Calendar
    },
    {
      path: '/setting/calendar/edit/:id',
      name: 'eventEdit',
      component: EventEdit,
      props: true
    }
  ]
})