<template id="my-component-template">
  <h1>{{ displayDate }}</h1>
  <div class="content">
    <div class="button-area">
      <button @click="prevMonth()">前の月</button>
      <button @click="nextMonth()">次の月</button>
    </div>
    <div class="calendar">
      <div class="calendar-weekly">
        <div class="calendar-youbi" v-for="youbi in youbiArray" :key="youbi">
          {{ youbi }}
        </div>
      </div>
      <div class="calendar-weekly" v-for="(week, index) in calendars" :key="index">
        <div
          class="calendar-daily"
          :class="{outside: currentMonth !== day.month}"
          v-for="(day, index) in week"
          :key="index"
          @drop="dragEnd($event, day.date)"
          @dragover.prevent
        >
          <div class="calendar-day">
            <p :class="{today: day.date === today}">
              {{ day.day }}
            </p>
          </div>
          <div v-for="dayEvent in day.dayEvents" :key="dayEvent.id">
            <div
              v-if="dayEvent.width"
            >
              <CalendarEvent
                :event="dayEvent"
                :eventId="dayEvent.id"
                @dragStart="dragStart"
              />
            </div>
            <div v-else style="height:26px"></div>
          </div>
        </div>
      </div>
    </div>
    <button @click="updateEvents()">更新</button>
  </div>
</template>

<script lang="ts">
import { ref, computed } from 'vue';
import CalendarEvent from './CalendarEvent.vue';
import axios from 'axios';
import moment from 'moment';
import { Event } from './types';

export default {
  components: {
    CalendarEvent,
  },
  name: 'Calendar',
  setup(){
    const today = moment().format('YYYY-MM-DD');

    const currentDate = ref(moment());
    const calendarVisible = ref<Boolean>(false);

    const youbiArray = ['日', '月', '火', '水', '木', '金', '土'];

    const events = ref<Event[]>([
      { id: 1, name: "ミーティング", start: "2023-07-01", end:"2023-07-01", color:"blue"},
      { id: 2, name: "イベント", start: "2023-07-02", end:"2023-07-03", color:"limegreen"},
      { id: 3, name: "会議", start: "2023-07-07", end:"2023-07-07", color:"deepskyblue"},
      { id: 6, name: "海外旅行", start: "2023-07-08", end:"2023-07-11", color:"navy"},
      { id: 4, name: "有給", start: "2023-07-09", end:"2023-07-10", color:"dimgray"},
      { id: 5, name: "あべべべ", start: "2023-07-09", end:"2023-07-11", color:"dimgray"},
    ]);

    const getStartDate = ()=>{
      const date = currentDate.value.clone().startOf('month');
      const youbiNum = date.day();
      return date.subtract(youbiNum, 'days');
    }

    const getEndDate = ()=>{
      const date = currentDate.value.clone().endOf('month');
      const youbiNum = date.day();
      return date.add(6 - youbiNum, 'days');
    }

    const createCalendar = ()=>{
      console.log('createCalendar');
      let startDate = getStartDate();
      const endDate = getEndDate();
      const weekNumber = Math.ceil(endDate.diff(startDate, 'days') / 7);

      let calendars = [];
      for(let week = 0; week < weekNumber; week++){
        let weekRow = [];
        for (let youbiNum = 0; youbiNum < 7; youbiNum++) {
          let dayEvents = getDayEvents(startDate, youbiNum);
          weekRow.push({
            day: startDate.get('date'),
            month: startDate.format('YYYY-MM'),
            date: startDate.format('YYYY-MM-DD'),
            dayEvents
          });
          startDate.add(1, 'days');
        }
        calendars.push(weekRow);
      }
      console.log(calendars);
      return calendars;
    }

    const prevMonth = ()=>{
      currentDate.value = moment(currentDate.value).subtract(1, 'month');
    }
    
    const nextMonth = ()=>{
      currentDate.value = moment(currentDate.value).add(1, 'month');
    }

    const getDayEvents = (date: moment.Moment, youbiNum: number)=>{
      let stackIndex: number = 0;
      let dayEvents: Event[] = [];
      let startedEvents: Event[] = [];
      
      sortedEvents.value.forEach(event => { //完成らしいコード
        let eventStartDate = moment(event.start).format('YYYY-MM-DD');
        let eventEndDate = moment(event.end).format('YYYY-MM-DD');
        let Date = date.format('YYYY-MM-DD');
        if(eventStartDate <= Date && eventEndDate >= Date){
          if(eventStartDate === Date){
            [stackIndex, dayEvents] = getStackEvents(event, stackIndex, dayEvents, startedEvents);
            let width: number = getEventWidth(moment(event.start), moment(event.end), youbiNum);
            dayEvents.push({...event, width});
          }else if(youbiNum === 0){
            [stackIndex, dayEvents] = getStackEvents(event, stackIndex, dayEvents, startedEvents);
            let width: number = getEventWidth(date, moment(event.end), youbiNum);
            dayEvents.push({...event, width});
          }else{
            startedEvents.push(event)
          }
        }
      });
      return dayEvents;
    }

    const getEventWidth = (start: moment.Moment, end: moment.Moment, youbiNum: number)=>{
      let betweenDays = moment(end).diff(start, "days");
      if(betweenDays > 6 - youbiNum){
        return (6 - youbiNum) * 100 + 95; 
      }else{
        return betweenDays * 100 + 95;
      }
    }

    const getStackEvents = (event: Event, stackIndex: number, dayEvents: Event[], startedEvents: Event[]): [number, Event[]]=>{
      [stackIndex, dayEvents] = getStartedEvents(stackIndex, startedEvents, dayEvents);
      Object.assign(event,{
        stackIndex
      })
      stackIndex++;
      return [stackIndex,dayEvents];
    }
    
    const getStartedEvents = (stackIndex: number, startedEvents: Event[], dayEvents: Event[]): [number, Event[]]=>{
      let startedEvent;
      do{
        startedEvent = startedEvents.find(event => event.stackIndex === stackIndex)
        if(startedEvent) {
          dayEvents.push(startedEvent)　//ダミー領域として利用するため
          stackIndex++;
        }
      }while(typeof startedEvent !== 'undefined')
      return [stackIndex, dayEvents]
    }

    const dragStart = (event: DragEvent, eventId: number)=>{
      if (!event.dataTransfer) {
        return
      }
      const stringEventId = eventId.toString();
      event.dataTransfer.effectAllowed = "move";
      event.dataTransfer.dropEffect = "move";
      event.dataTransfer.setData("eventId", stringEventId);
    }

    const dragEnd = (event: DragEvent, date: string)=>{ 
      if (!event.dataTransfer) {
        return
      }
      const stringEventId: string = event.dataTransfer.getData("eventId");
      const parseIntEventId: number = parseInt(stringEventId);
      const dragEvent = events.value.find(event => event.id === parseIntEventId);
      if (!dragEvent) {
        return;
      }
      const betweenDays = moment(dragEvent.end).diff(moment(dragEvent.start), "days");
      dragEvent.start = date;
      dragEvent.end = moment(dragEvent.start).add(betweenDays, "days").format("YYYY-MM-DD");
    }

    const editCalendar = ()=>{
      calendarVisible.value = !calendarVisible.value;
    }

    const updateEvents = async ()=>{
      await axios.post('/updateSchedule', {events: events.value}).then(()=>{
        alert('更新完了しました。');
        calendarVisible.value = false;
      }).catch(()=>{
        alert('更新失敗しました');
      })
    }

    const getCalendar = async (currentMonth: string)=>{
      await axios.get('/googleCalendar?currentMonth=' + currentMonth).then((res)=>{
        console.log(res);
      });
		}

    const calendars = computed(()=>{
      return createCalendar();
    })

    const sortedEvents = computed(()=>{
      return events.value.slice().sort(function(a,b) {
        let startDate = moment(a.start).format('YYYY-MM-DD')
        let startDate_2 = moment(b.start).format('YYYY-MM-DD')
        if( startDate < startDate_2 ) return -1;
        if( startDate > startDate_2 ) return 1;
        return 0;
      })
    })

    const displayDate = computed(()=>{
      return currentDate.value.format('YYYY[年]M[月]');
    })

    const currentMonth = computed(()=>{
      getCalendar(currentDate.value.format('YYYY-MM'));
      return currentDate.value.format('YYYY-MM');
    })

    return {
      today,
      youbiArray,
      calendars,
      calendarVisible,
      displayDate,
      currentMonth,
      prevMonth,
      nextMonth,
      dragStart,
      dragEnd,
      editCalendar,
      updateEvents,
    }
  }
};
</script>

<style>
.content{
  margin: 2em auto;
  width: 900px;
}

.button-area{
  margin: 0.5em 0;
}

.button-area button{
  padding: 4px 8px;
  margin-right: 8px;
}

.calendar{
  max-width: 900px;
  border-top:1px solid #E0E0E0;
  font-size:0.8em;
}

.calendar-weekly{
  display:flex;
  border-left:1px solid #E0E0E0;
}

.calendar-youbi{
  flex:1;
  border-right:1px solid #E0E0E0;
  margin-right:-1px;
  text-align:center;
}

.calendar-daily{
  flex:1;
  min-height:125px;
  border-right:1px solid #E0E0E0;
  border-bottom:1px solid #E0E0E0;
  margin-right:-1px;
}

.calendar-day{
  text-align: center;
}
.today{
  color: white;
  background-color: rgb(124, 167, 253);
}

.calendar-event{
  color:white;
  margin-bottom:1px;
  height:25px;
  line-height:25px;
  position: relative;
  z-index:1;
  border-radius:4px;
  padding-left:4px;
  cursor: pointer;
}

.outside{
  background-color: #f7f7f7;
}
</style>