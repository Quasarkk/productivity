<template>
    <AppLayoutVertical>

        <div class="w-full h-screen bg-slate-100">

            <!-- Month/week/day + change button -->
            <div class="w-[95%] mx-auto flex justify-between">
                <!-- Calendar / todo button -->
                <div class="border-2 shadow-md py-1 rounded">
                    <button class="px-2 py-1 focus:bg-green-300 rounded">todo</button>
                    <button class="px-2 py-1 focus:bg-green-300 rounded">planning</button>
                </div>

                <!-- Month/week/day + prevuous and next buttons -->

                <!-- today + change buttons -->
                <div class="flex">
                    <button class="px-2 py-1 focus:bg-green-300 rounded shadow-md">Today</button>
                    <!-- Change buttons -->
                    <div class="border-2 shadow-md py-1 rounded">
                        <button @click="ShowMonthlyPlanning()" class="px-2 py-1 rounded"
                            :class="{ 'bg-sky-300': isMonthlyPlanning }">Month</button>
                        <button @click="ShowWeeklyPlanning()" class="px-2 py-1 rounded"
                            :class="{ 'bg-sky-300': isWeeklyPlanning }">Week</button>
                        <button @click="ShowDailyPlanning()" class="px-2 py-1 rounded"
                            :class="{ 'bg-sky-300': isDailyPlanning }">Day</button>
                    </div>
                </div>
            </div>

            <!-- Daily planning + todo -->
            <div v-if="isDailyPlanning" class="h-screen ">
                <div class="flex justify-center align-middle">
                    <button @click="goToPreviousDay()"><svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-10"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg></button>
                    <p class="text-2xl font-semibold my-auto">{{ selectedDay.format('Do MMM YYYY') }}</p>
                    <button @click="goToNextDay()"><svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-10"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 6l6 6l-6 6" />
                        </svg></button>
                </div>

                <div class="flex">
                    <div class="bg-pink-100 w-[5%] mt-12">
                        <div v-for="hour in hours" :key="hour"
                            class="h-24 border-black flex items-center justify-center box-border">
                            {{ hour }}
                        </div>
                    </div>
                    <div class="h-screen w-1/2">
                        <!-- Time slots for each hour in the day -->
                        <div class="grid grid-rows-9">
                            <div v-for="(hour, hourIndex) in hours" :key="`timeslot-${hourIndex}`"
                                class="h-24 border-b border-black flex items-center justify-center box-border">
                                <template v-for="task in getTasksForDayAndHour(currentDay, hour)" :key="task.id">
                                    <span>{{ task.name }}</span>
                                </template>
                            </div>

                        </div>
                    </div>
                    <div class="h-screen w-1/2">
                        <Tasks :tasks="tasks" :tasksNotDoneCount="tasksNotDoneCount" :tasksDoneCount="tasksDoneCount">
                        </Tasks>
                    </div>
                </div>
            </div>

            <!-- weekly planning -->
            <div v-if="isWeeklyPlanning" class=""> <!-- Hours column -->
                <div class="flex justify-center align-middle">
                    <button @click="goToPreviousWeek()"><svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-10"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg></button>
                    <p class="text-2xl font-semibold my-auto">
                        Week {{ weekNumberInMonth }} - {{ selectedWeek.format('MMMM YYYY') }}
                    </p>
                    <button @click="goToNextWeek()"><svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-10"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 6l6 6l-6 6" />
                        </svg></button>
                </div>

                <div class="flex">
                    <div class="bg-pink-100 w-[5%] mt-12">
                        <div v-for="hour in hours" :key="hour"
                            class="h-24  border-black flex items-center justify-center box-border">
                            {{ hour }}
                        </div>
                    </div>

                    <!-- Days and time slots grid -->
                    <div class="flex-grow grid grid-cols-7">
                        <!-- Afficher chaque jour de la semaine avec sa date -->
                        <div v-for="(day, index) in weekDaysWithDates" :key="index" class="border-l-2 border-black">
                            <div class="text-center font-bold text-xl h-24 border-b-2 border-black p-4"
                                 :class="{ 'text-orange-400': isCurrentDate(day)}">
                                {{ day.format('ddd D') }} <!-- Affiche le jour et le numéro du jour -->
                            </div>
                            <!-- Time slots for each hour in the day -->
                            <div class="grid grid-rows-9">
                                <div v-for="(hour, hourIndex) in hours" :key="`timeslot-${day}-${hourIndex}`"
                                    class="h-24 border-b border-black flex items-center justify-center box-border">
                                    <template v-for="task in getTasksForDayAndHour(day, hour)" :key="task.id">
                                        <span>{{ task.name }}</span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- monthly planning -->
            <div v-if="isMonthlyPlanning" class="h-20 border-2">
                <div class="flex justify-center align-middle">
                    <button @click="goToPreviousMonth()"><svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-10"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg></button>
                    <p class="text-2xl font-semibold my-auto">{{ selectedMonth.format('MMMM YYYY') }}</p>
                    <button @click="goToNextMonth()"><svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-10"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 6l6 6l-6 6" />
                        </svg></button>
                </div>


                <!-- Names of the week days -->
                <div class="grid grid-cols-7 gap-2 text-center w-[98%] mx-auto">
                    <div class="font-bold text-xl border-2 flex justify-center items-center" v-for=" day  in  days "
                        :key="day" :class="{ 'text-orange-600': day === currentDay }">
                        {{ day }}
                    </div>
                </div>
                <!-- Calendar's grid -->
                <div class="grid grid-cols-7 gap-2 text-center mt-2 w-[98%] mx-auto">
                    <!-- Boucle sur chaque semaine puis sur chaque jour de la semaine -->
                    <div v-for="( week, weekIndex ) in  weeksInMonth " :key="weekIndex" class="contents">
                        <div class="py-2 h-28 border-2 rounded-xl" v-for="( dayInfo, dayIndex ) in  week " :key="dayIndex"
                            :class="{
                                'bg-gray-200': !dayInfo.isInCurrentMonth,
                                'bg-slate-100': dayInfo.isInCurrentMonth,
                                'font-bold text-orange-600': dayInfo.date.isSame(new Date(), 'day')
                            }
                                ">
                            {{ dayInfo.date.format('D') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AppLayoutVertical>
</template>
<script>
import AppLayoutVertical from '@/Layouts/AppLayoutVertical.vue';
import Tasks from '@/Components/Custom/Tasks.vue'
import moment from 'moment';

export default {
    components: {
        AppLayoutVertical,
        Tasks,
    },

    props: {
        tasks: Array,
        tasksNotDoneCount: Number,
        tasksDoneCount: Number,
    },

    data() {
        return {
            isDailyPlanning: false,
            isWeeklyPlanning: false,
            isMonthlyPlanning: true,

            selectedMonth: moment(),
            selectedDay: moment(),
            selectedWeek: moment(),

            currentDay: moment().format('ddd'), // Ajoutez cette ligne

            days: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            hours: ['8', '8:30', '9', '9:30', '10', '10:30', '11', '11:30', '12', '12:30', '13', '13:30', '14', '14:30', '15', '15:30', '16', '16:30', '17']

            // isWeeklyTodo:false,
            // isMonthlyTodo:false,
        }
    },

    methods: {
        goToPreviousMonth() {
            this.selectedMonth = this.selectedMonth.clone().subtract(1, 'months');
        },

        goToNextMonth() {
            this.selectedMonth = this.selectedMonth.clone().add(1, 'months');
        },

        goToPreviousWeek() {
            this.selectedWeek = this.selectedWeek.clone().subtract(1, 'weeks');
        },

        goToNextWeek() {
            this.selectedWeek = this.selectedWeek.clone().add(1, 'weeks');
        },

        goToPreviousDay() {
            let newDay = this.selectedDay.clone().subtract(1, 'days');
            this.selectedDay = newDay;
            this.currentDay = newDay.format('ddd');
        },

        goToNextDay() {
            let newDay = this.selectedDay.clone().add(1, 'days');
            this.selectedDay = newDay;
            this.currentDay = newDay.format('ddd');
        },

        ShowMonthlyPlanning() {
            this.isDailyPlanning = false;
            this.isWeeklyPlanning = false;
            this.isMonthlyPlanning = true;
        },

        ShowWeeklyPlanning() {
            this.isDailyPlanning = false;
            this.isWeeklyPlanning = true;
            this.isMonthlyPlanning = false;
        },

        ShowDailyPlanning() {
            this.isDailyPlanning = true;
            this.isWeeklyPlanning = false;
            this.isMonthlyPlanning = false;
        },

        getTasksForDay(day) {
            // Format the day to match the date format of the tasks
            const formattedDay = moment(day, 'ddd').startOf('isoWeek').format('YYYY-MM-DD');
            // Filtrez les tâches en fonction de la date
            return this.tasks.filter(task => moment(task.dates).format('YYYY-MM-DD') === formattedDay);
        },

        getTasksForDayAndHour(day, hour) {
            const weekDay = this.selectedWeek.clone().day(day).format('YYYY-MM-DD');
            const hourTime = moment(`${weekDay} ${hour}`, 'YYYY-MM-DD HH:mm');

            return this.tasks.filter(task => {
                if (!task.dates || !task.begin_hour || !task.end_hour) {
                    return false;
                }
                const taskDateStr = moment(task.dates).format('YYYY-MM-DD');
                const taskStartTimeStr = `${taskDateStr} ${task.begin_hour}`;
                const taskEndTimeStr = `${taskDateStr} ${task.end_hour}`;

                if (!moment(taskStartTimeStr, 'YYYY-MM-DD HH:mm').isValid() || !moment(taskEndTimeStr, 'YYYY-MM-DD HH:mm').isValid()) {
                    console.warn('Invalid date format for task:', task);
                    return false;
                }

                const taskStart = moment(taskStartTimeStr, 'YYYY-MM-DD HH:mm');
                const taskEnd = moment(taskEndTimeStr, 'YYYY-MM-DD HH:mm');
                return taskStart.isSameOrBefore(hourTime) && taskEnd.isSameOrAfter(hourTime);
            });
        },

        isCurrentDate(day) {
            return day.isSame(moment(), 'day');
        },

        getWeekNumberInMonth(date) {
            // Clone la date pour éviter de modifier l'original
            let current = date.clone();

            // Trouver le premier jour de la semaine et le premier jour du mois
            let firstDayOfWeek = current.clone().startOf('isoWeek');
            let firstDayOfMonth = current.clone().startOf('month');

            // Calculer la différence en semaines
            let weekNumberInMonth = firstDayOfWeek.diff(firstDayOfMonth, 'weeks') + 1;

            return weekNumberInMonth;
        },


    },
    computed: {
        weeksInMonth() {
            let weeks = [];
            let startDay = this.selectedMonth.clone().startOf('month').startOf('isoWeek');
            let endDay = this.selectedMonth.clone().endOf('month').endOf('isoWeek');
            let currentDay = startDay.clone();

            while (currentDay.isBefore(endDay)) {
                let week = [];
                for (let i = 0; i < 7; i++) { // Une semaine a 7 jours
                    week.push({
                        date: currentDay.clone(),
                        isInCurrentMonth: currentDay.month() === this.selectedMonth.month(),
                        // ...autres propriétés comme les tâches
                    });
                    currentDay.add(1, 'day');
                }
                weeks.push(week);
            }
            return weeks;
        },

        weekNumberInMonth() {
            return this.getWeekNumberInMonth(this.selectedWeek);
        },

        weekDaysWithDates() {
            let days = [];
            let startOfWeek = this.selectedWeek.clone().startOf('isoWeek');

            for (let i = 0; i < 7; i++) {
                days.push(startOfWeek.clone().add(i, 'days'));
            }

            return days;
        },
    },
}
</script>
