<template id="my-component-template">
    <div>
        <!-- <div> -->
        <!-- <Calendar borderless /> -->
        <!-- <DatePicker v-model="date" mode="dateTime" :rules="rules" /> -->
        <!-- </div> -->
        <h1>{{ displayDate }}</h1>
        <div class="content">
            <div class="button-area">
                <button @click="prevMonth()">前の月</button>
                <button @click="nextMonth()">次の月</button>
                <button v-if="!calendarVisible" @click="editCalendar()">
                    編集
                </button>
                <button v-else @click="editCalendar()">キャンセル</button>
            </div>
            <div class="calendar">
                <div class="calendar-weekly">
                    <div
                        class="calendar-youbi"
                        v-for="youbi in youbiArray"
                        :key="youbi"
                    >
                        {{ youbi }}
                    </div>
                </div>
                <div
                    class="calendar-weekly"
                    v-for="(week, index) in calendars"
                    :key="index"
                >
                    <div
                        class="calendar-daily"
                        :class="{ outside: currentMonth !== day.month }"
                        v-for="(day, index) in week"
                        :key="index"
                        @dragenter="setDragDate(day.date)"
                        @drop="dragEnd($event)"
                        @dragover.prevent
                        :disabled="calendarVisible"
                    >
                        <div class="calendar-day">
                            {{ day.day }}
                        </div>
                        <!-- <div v-for="dayEvent in day.dayEvents" :key="dayEvent.id">
            <div
              class="calendar-event"
              :style="`background-color:${dayEvent.color};`"
              draggable="true"
              @dragstart="dragStart($event, dayEvent.id)"
            >
              {{ dayEvent.name }}
              {{ dayEvent.width }}
            </div>
          </div> -->
                        <div
                            v-for="dayEvent in day.dayEvents"
                            :key="dayEvent.id"
                        >
                            <div
                                v-if="dayEvent.width"
                                class="calendar-event"
                                :style="`width:${dayEvent.width}%;background-color:${dayEvent.color};`"
                                draggable="true"
                                @dragstart="dragStart($event, dayEvent.id)"
                            >
                                {{ dayEvent.name }}
                                {{ dayEvent.width }}
                            </div>
                            <div v-else style="height: 26px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <button @click="updateEvents()" :disabled="calendarVisible">
                更新
            </button>
        </div>
    </div>
</template>

<script>
import { watch, ref, reactive, onMounted, computed } from "vue";
import { Calendar, DatePicker } from "v-calendar";
import "v-calendar/style.css";
// import CalendarEvents from './CalendarEvents';
import axios from "axios";
import moment from "moment";

export default {
    components: {
        // CalendarEvents,
        Calendar,
        DatePicker,
    },
    name: "Calendar",
    setup() {
        let defaultDateTime = new Date();
        defaultDateTime.setHours(10);
        defaultDateTime.setMinutes(0);
        const date = ref(defaultDateTime);

        const currentDate = ref(moment());
        const calendarVisible = ref(false);

        const youbiArray = ["日", "月", "火", "水", "木", "金", "土"];

        const events = ref([
            {
                id: 1,
                name: "ミーティング",
                start: "2023-06-01",
                end: "2023-06-01",
                color: "blue",
            },
            {
                id: 2,
                name: "イベント",
                start: "2023-06-02",
                end: "2023-06-03",
                color: "limegreen",
            },
            {
                id: 3,
                name: "会議",
                start: "2023-06-06",
                end: "2023-06-06",
                color: "deepskyblue",
            },
            {
                id: 6,
                name: "海外旅行",
                start: "2023-06-08",
                end: "2023-06-11",
                color: "navy",
            },
            {
                id: 4,
                name: "有給",
                start: "2023-06-09",
                end: "2023-06-10",
                color: "dimgray",
            },
            {
                id: 5,
                name: "あべべべ",
                start: "2023-06-09",
                end: "2023-06-11",
                color: "dimgray",
            },
        ]);
        const dragDate = ref(null);

        const getStartDate = () => {
            const date = currentDate.value.clone().startOf("month");
            const youbiNum = date.day();
            return date.subtract(youbiNum, "days");
        };

        const getEndDate = () => {
            const date = currentDate.value.clone().endOf("month");
            const youbiNum = date.day();
            return date.add(6 - youbiNum, "days");
        };

        const createCalendar = () => {
            console.log("createCalendar");
            let startDate = getStartDate();
            const endDate = getEndDate();
            const weekNumber = Math.ceil(endDate.diff(startDate, "days") / 7);

            let calendars = [];
            for (let week = 0; week < weekNumber; week++) {
                let weekRow = [];
                for (let youbiNum = 0; youbiNum < 7; youbiNum++) {
                    let dayEvents = getDayEvents(startDate, youbiNum);
                    weekRow.push({
                        day: startDate.get("date"),
                        month: startDate.format("YYYY-MM"),
                        date: startDate.format("YYYY-MM-DD"),
                        dayEvents,
                    });
                    startDate.add(1, "days");
                }
                calendars.push(weekRow);
            }
            console.log(calendars);
            return calendars;
        };

        const prevMonth = () => {
            currentDate.value = moment(currentDate.value).subtract(1, "month");
        };

        const nextMonth = () => {
            currentDate.value = moment(currentDate.value).add(1, "month");
        };

        const getDayEvents = (date, youbiNum) => {
            let stackIndex = 0;
            let dayEvents = [];
            let startedEvents = [];

            // return events.value.filter(event => { //元コード
            //   let startDate = moment(event.start).format('YYYY-MM-DD')
            //   let endDate = moment(event.end).format('YYYY-MM-DD')
            //   let Date = date.format('YYYY-MM-DD')
            //   if(startDate <= Date && endDate >= Date) return true;
            // });

            // events.value.filter(event => { //変更点
            //   let startDate = moment(event.start).format('YYYY-MM-DD')
            //   let endDate = moment(event.end).format('YYYY-MM-DD')
            //   let Date = date.format('YYYY-MM-DD')
            //   if(startDate <= Date && endDate >= Date){
            //     [stackIndex, dayEvents] = getStackEvents(event, youbiNum, stackIndex, dayEvents, startedEvents, date);
            //     dayEvents.push({...event})
            //   };
            // });
            // return dayEvents;

            sortedEvents.value.forEach((event) => {
                //完成らしいコーdosdss
                let eventStartDate = moment(event.start).format("YYYY-MM-DD");
                let eventEndDate = moment(event.end).format("YYYY-MM-DD");
                let Date = date.format("YYYY-MM-DD");
                if (eventStartDate <= Date && eventEndDate >= Date) {
                    if (eventStartDate === Date) {
                        [stackIndex, dayEvents] = getStackEvents(
                            event,
                            youbiNum,
                            stackIndex,
                            dayEvents,
                            startedEvents,
                            date
                        );
                        let width = getEventWidth(
                            eventStartDate,
                            eventEndDate,
                            youbiNum
                        );
                        console.log("eventStartDate === Date");
                        console.log(width);
                        dayEvents.push({ ...event, width });
                    } else if (youbiNum === 0) {
                        [stackIndex, dayEvents] = getStackEvents(
                            event,
                            youbiNum,
                            stackIndex,
                            dayEvents,
                            startedEvents,
                            date
                        );
                        let width = getEventWidth(date, eventEndDate, youbiNum);
                        console.log("youbiNum === 0");
                        console.log(width);
                        dayEvents.push({ ...event, width });
                    } else {
                        startedEvents.push(event);
                    }
                }
            });
            return dayEvents;
        };

        const getEventWidth = (start, end, youbiNum) => {
            let betweenDays = moment(end).diff(start, "days");
            if (betweenDays > 6 - youbiNum) {
                return (6 - youbiNum) * 100 + 95;
            } else {
                return betweenDays * 100 + 95;
            }
        };
        const getEventSize = (start, end, youbiNum) => {
            let betweenDays = moment(end).diff(start, "days");
            if (betweenDays > 6 - youbiNum) {
                return 6 - youbiNum;
            } else {
                return betweenDays;
            }
        };

        const getStackEvents = (
            event,
            youbiNum,
            stackIndex,
            dayEvents,
            startedEvents,
            start
        ) => {
            // console.log(event);
            [stackIndex, dayEvents] = getStartedEvents(
                stackIndex,
                startedEvents,
                dayEvents
            );
            Object.assign(event, {
                stackIndex,
            });
            stackIndex++;
            return [stackIndex, dayEvents];
        };

        const getStartedEvents = (stackIndex, startedEvents, dayEvents) => {
            console.log(stackIndex);
            console.log(startedEvents);
            console.log(dayEvents);
            let startedEvent;
            do {
                startedEvent = startedEvents.find(
                    (event) => event.stackIndex === stackIndex
                );
                if (startedEvent) {
                    dayEvents.push(startedEvent); //ダミー領域として利用するため
                    stackIndex++;
                }
            } while (typeof startedEvent !== "undefined");
            return [stackIndex, dayEvents];
        };

        const dragStart = (event, eventId) => {
            event.dataTransfer.effectAllowed = "move";
            event.dataTransfer.dropEffect = "move";
            event.dataTransfer.setData("eventId", eventId);
        };

        const dragEnd = (event) => {
            const date = dragDate.value;
            let eventId = event.dataTransfer.getData("eventId");
            let dragEvent = events.value.find((event) => event.id == eventId);
            let betweenDays = moment(dragEvent.end).diff(
                moment(dragEvent.start),
                "days"
            );
            dragEvent.start = date;
            dragEvent.end = moment(dragEvent.start)
                .add(betweenDays, "days")
                .format("YYYY-MM-DD");
        };

        const setDragDate = (date) => {
            dragDate.value = date;
        };

        const editCalendar = () => {
            calendarVisible.value = !calendarVisible.value;
        };

        const updateEvents = async () => {
            await axios
                .post("/updateSchedule", { events: events.value })
                .then(() => {
                    alert("更新完了しました。");
                    calendarVisible.value = false;
                })
                .catch(() => {
                    alert("更新失敗しました");
                });
        };

        const calendars = computed(() => {
            return createCalendar();
        });

        const sortedEvents = computed(() => {
            return events.value.slice().sort(function (a, b) {
                let startDate = moment(a.start).format("YYYY-MM-DD");
                let startDate_2 = moment(b.start).format("YYYY-MM-DD");
                if (startDate < startDate_2) return -1;
                if (startDate > startDate_2) return 1;
                return 0;
            });
        });

        const displayDate = computed(() => {
            return currentDate.value.format("YYYY[年]M[月]");
        });

        const currentMonth = computed(() => {
            return currentDate.value.format("YYYY-MM");
        });

        const rules = reactive({
            hours: { min: 7, max: 23 },
            minutes: { interval: 5 },
        });
        watch(date, () => {
            console.log(defaultDateTime);
            console.log(date.value);
        });

        // onMounted(()=>{
        // createCalendar();
        // });

        return {
            youbiArray,
            date,
            rules,
            calendars,
            calendarVisible,
            displayDate,
            prevMonth,
            nextMonth,
            currentMonth,
            dragStart,
            dragEnd,
            setDragDate,
            editCalendar,
            updateEvents,
            clickCalendarDaily,
            clickCalendarEvent,
        };
    },
};
</script>

<style>
.content {
    margin: 2em auto;
    width: 900px;
}

.button-area {
    margin: 0.5em 0;
}

.button-area button {
    padding: 4px 8px;
    margin-right: 8px;
}

.calendar {
    max-width: 900px;
    border-top: 1px solid #e0e0e0;
    font-size: 0.8em;
}

.calendar-weekly {
    display: flex;
    border-left: 1px solid #e0e0e0;
    /* background-color: black; */
}

.calendar-youbi {
    flex: 1;
    border-right: 1px solid #e0e0e0;
    margin-right: -1px;
    text-align: center;
}

.calendar-daily {
    flex: 1;
    min-height: 125px;
    border-right: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
    margin-right: -1px;
}

.calendar-day {
    text-align: center;
}

.calendar-event {
    color: white;
    background-color: aqua;
    margin-bottom: 1px;
    height: 25px;
    line-height: 25px;
    position: relative;
    z-index: 1;
    border-radius: 4px;
    padding-left: 4px;
}

.outside {
    background-color: #f7f7f7;
}
</style>
