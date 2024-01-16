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

            <!-- daily planning + todo -->
            <div v-if="isDailyPlanning" class="h-screen flex">
                <div class="bg-pink-100 w-[5%]">
                    <p class="mt-6">8</p>
                    <p class="my-14">9</p>
                    <p class="my-14">10</p>
                    <p class="my-14">11</p>
                    <p class="my-14"> 12</p>
                    <p class="my-14">13</p>
                    <p class="my-14">14</p>
                    <p class="my-14">15</p>
                    <p class="my-14">16</p>
                    <p class="my-14">17</p>
                </div>
                <div class="h-screen w-1/2">
                    <div class="h-[10%] border-b-2 border-black">
                        aa
                    </div>

                    <div class="h-[10%] border-b-2 border-black">

                    </div>

                    <div class="h-[10%] border-b-2 border-black">

                    </div>

                    <div class="h-[10%] border-b-2 border-black">

                    </div>

                    <div class="h-[10%] border-b-2 border-black">

                    </div>

                    <div class="h-[10%] border-b-2 border-black">

                    </div>

                    <div class="h-[10%] border-b-2 border-black">

                    </div>

                    <div class="h-[10%] border-b-2 border-black">

                    </div>

                    <div class="h-[10%] border-b-2 border-black">

                    </div>
                </div>

                <div class="h-screen w-1/2 bg-green-200">
                    <Tasks :tasks="tasks" :tasksNotDoneCount="tasksNotDoneCount" :tasksDoneCount="tasksDoneCount">
                    </Tasks>
                </div>

                <div>
                </div>
            </div>

            <!-- weekly planning -->
            <div v-if="isWeeklyPlanning" class="h-screen flex">
                <!-- Hours -->
                <div class="bg-pink-100 w-[5%]">
                    <div v-for="hour in hours" :key="hour" class="h-[10%] border-b-2 border-black">{{ hour }}</div>
                </div>

                <!-- Name of the days + calendar -->
                <div class="w-full">
                    <!-- Names of the week days -->
                    <div class="grid grid-cols-7 gap-2 text-center w-[98%] mx-auto">
                        <div class="font-bold text-xl border-2 flex justify-center items-center"
                            v-for="day in ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']" :key="day"
                            :class="{ 'text-orange-600': day === currentDay }">
                            {{ day }}
                        </div>
                        <!-- Time slot -->
                        <div v-for="hour in hours" :key="hour" class="h-[10%] relative">
                            <!-- Tasks for each time slot -->


                            <!-- <div v-for="task in getTasksForDay(day)" :key="task.id" class="absolute" :style="getTaskStyle(task)">
                                <span class="px-2 py-1 rounded bg-blue-400 text-white">{{ task.name }}</span>
                            </div> -->

                            
                        </div>

                    </div>
                    <!-- Calendar's grid -->
                    <div class="grid grid-cols-7 gap-2 text-center mt-2 w-[98%] mx-auto">

                    </div>
                </div>
            </div>

            <!-- monthly planning -->
            <div v-if="isMonthlyPlanning" class="h-20 border-2">
                <div class="flex justify-center align-middle">
                    <button @click="goToPreviousMonth"><svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-10"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg></button>
                    <p class="text-2xl font-semibold my-auto">{{ selectedMonth.format('MMMM YYYY') }}</p>
                    <button @click="goToNextMonth"><svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-10"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 6l6 6l-6 6" />
                        </svg></button>
                </div>


                <!-- Names of the week days -->
                <div class="grid grid-cols-7 gap-2 text-center w-[98%] mx-auto">
                    <div class="font-bold text-xl border-2 flex justify-center items-center"
                        v-for="day in days" :key="day"
                        :class="{ 'text-orange-600': day === currentDay }">
                        {{ day }}
                    </div>
                </div>
                <!-- Calendar's grid -->
                <div class="grid grid-cols-7 gap-2 text-center mt-2 w-[98%] mx-auto">
                    <!-- Boucle sur chaque semaine puis sur chaque jour de la semaine -->
                    <div v-for="(week, weekIndex) in weeksInMonth" :key="weekIndex" class="contents">
                        <div class="py-2 h-28 border-2 rounded-xl" v-for="(dayInfo, dayIndex) in week" :key="dayIndex"
                            :class="{
                                'bg-gray-200': !dayInfo.isInCurrentMonth,
                                'bg-slate-100': dayInfo.isInCurrentMonth,
                                'font-bold text-orange-600': dayInfo.date.isSame(new Date(), 'day')
                            }">
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
            currentDay: moment().format('ddd'), // Ajoutez cette ligne

            days: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            hours : ['8', '8:30', '9', '9:30', '10', '10:30', '11', '11:30', '12', '12:30', '13', '13:30', '14', '14:30', '15', '15:30', '16', '16:30', '17']

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

    },
}
</script>
