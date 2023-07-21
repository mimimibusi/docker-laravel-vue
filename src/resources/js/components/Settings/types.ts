import { InjectionKey, inject } from "vue";

export interface Event{
  id?: string,
  summary?: string,
  start: string,
  end: string,
  calendarId?: string,
  width?: number,
  stackIndex?: number,
}
export type ReturnType<T> = T extends (...args: any) => infer R ? R : any;
export const strictInject = <T>(key: InjectionKey<T>) => {
  return inject(key) as T;
};
