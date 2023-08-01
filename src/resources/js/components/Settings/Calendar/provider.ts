import { InjectionKey, ref, inject } from "vue";
import { Event, ReturnType } from "./types";

export const key: InjectionKey<ReturnType<typeof useProvide>> = Symbol('CalendarEvent');
export const useProvide = ()=>{
  const events = ref<Event[]>([]);
  return{
    events
  }
}

export const strictInject = <T>(key: InjectionKey<T>) => {
  return inject(key) as T;
};