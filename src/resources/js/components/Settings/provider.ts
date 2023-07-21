import { InjectionKey, ref } from "vue";
import { Event, ReturnType } from "./types";

export const key: InjectionKey<ReturnType<typeof useProvide>> = Symbol('CalendarEvent');
export const useProvide = ()=>{
  const events = ref<Event[]>([]);
  return{
    events
  }
}