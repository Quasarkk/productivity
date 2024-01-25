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
                        <section class="bg-slate-200 rounded-xl border-2 border-slate-400">
                            <h2 class="w-full text-center">TASKS</h2>
                            <div class="mx-4 my-4">
                                <div class="flex justify-between w-">
                                    <h3> Today</h3>
                                    <button @click="isOpenCreateTask = true"
                                        class="ml-2 px-2 py-1 flex bg-blue-200 rounded-xl border-blue-700 border-[1.8px]">Add<svg
                                            xmlns="http://www.w3.org/2000/svg" class="w-6" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg></button>
                                </div>
                                <!-- Create a task -->
                                <div class="flex">
                                    <!-- <input v-model="form_createTask.name" placeholder="Do the dishes" class="pl-2 rounded"> -->
                                </div>
                                <!-- Display tasks -->
                                <draggable :list="getTasksForSelectedDay()" @end="updateTaskOrder" @input="updateTasks"
                                    class="drag-area">
                                    <template #item="{ element }">
                                        <div :key="element.id" @click="edit(element)"
                                            class="task-item flex hover:bg-gray-200 focus:bg-slate-200 focus:cursor-move hover:cursor-move px-4 rounded">
                                            <span class="drag-handle">☰</span> <!-- Icône pour le drag -->
                                            <input class="my-auto" type="checkbox" :checked="element.status === 'done'"
                                                @change="changeCheck(element.id, $event.target.checked)">
                                            <p class="ml-2"
                                                :class="{ 'opacity-50 line-through decoration-2': element.status === 'done' }">
                                                {{ element.name }}
                                            </p>
                                            <p>{{ element.relatedType }} {{ element.relatedName }}</p>
                                        </div>
                                    </template>
                                </draggable>
                            </div>
                        </section>

                    </div>
                </div>
            </div>

            <!-- MODALE CREATE TASK -->
            <div v-if="isOpenCreateTask"
                class="fixed top-0 bg-black/20 w-full h-full justify-center flex backdrop-blur-md overflow-auto">
                <!-- CREATE CARD -->
                <div class=" w-6/12 p-6 bg-white my-auto rounded-lg">
                    <!-- CLOSE BUTTONS -->
                    <div class="flex items-center justify-end mb-3">
                        <button @click="closeCreateModale" class="">
                            <svg class="w-6 h-6  fill-red-700 hover:fill-red-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <path
                                    d="M 38.982422 6.9707031 A 2.0002 2.0002 0 0 0 37.585938 7.5859375 L 24 21.171875 L 10.414062 7.5859375 A 2.0002 2.0002 0 0 0 8.9785156 6.9804688 A 2.0002 2.0002 0 0 0 7.5859375 10.414062 L 21.171875 24 L 7.5859375 37.585938 A 2.0002 2.0002 0 1 0 10.414062 40.414062 L 24 26.828125 L 37.585938 40.414062 A 2.0002 2.0002 0 1 0 40.414062 37.585938 L 26.828125 24 L 40.414062 10.414062 A 2.0002 2.0002 0 0 0 38.982422 6.9707031 z" />
                            </svg>
                        </button>
                    </div>
                    <p>Create a task</p>
                    <!-- NAME -->
                    <div class="mt-3">
                        <label class="block font-medium text-gray-700 capitalize">Name</label>
                        <input
                            class="block mt-1 w-full rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                            v-model="form_createTask.name" type="text">
                    </div>

                    <!-- DATES -->
                    <label class="block  mt-3 font-medium text-gray-700 capitalize-first">dates</label>
                    <div class="flex items-center">
                        <input class="rounded mr-1 focus:ring-0 focus:ring-offset-0" type="date"
                            v-model="form_createTask.dates">
                    </div>

                    <!-- BEGIN AND END HOURS -->
                    <div class="mt-3 flex">
                        <!-- Begin -->
                        <div class="mr-16">
                            <label class="block font-medium text-gray-700 capitalize-first">Begin hour</label>
                            <input v-model="form_createTask.begin_hour" type="time">
                        </div>
                        <!-- END -->
                        <div class="">
                            <label class="block font-medium text-gray-700 capitalize-first">End hour</label>
                            <input v-model="form_createTask.end_hour" type="time">
                        </div>
                    </div>

                    <!-- CREATE BUTTON  -->
                    <button @click="createTask(form_createTask)"
                        class="mt-4 rounded border focus:ring-cyan-500 focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-50 active:bg-cyan-900 bg-cyan-800 hover:bg-cyan-700 font-medium w-full text-white px-2 py-1 uppercase">
                        Create a task
                    </button>

                </div>
            </div>

            <!-- MODALE EDIT TASK -->
            <div v-if="isOpenEditTask"
                class="fixed top-0 bg-black/20 w-full h-full justify-center flex backdrop-blur-md overflow-auto">
                <!-- CREATE CARD -->
                <div class=" w-6/12 p-6 bg-white my-auto rounded-lg">
                    <!-- CLOSE AND DELETE BUTTONS -->
                    <div class="flex items-center justify-end mb-3">
                        <!-- CLOSE BUTTON -->
                        <button @click="closeEditModale" class="">
                            <svg class="w-6 h-6  fill-red-700 hover:fill-red-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <path
                                    d="M 38.982422 6.9707031 A 2.0002 2.0002 0 0 0 37.585938 7.5859375 L 24 21.171875 L 10.414062 7.5859375 A 2.0002 2.0002 0 0 0 8.9785156 6.9804688 A 2.0002 2.0002 0 0 0 7.5859375 10.414062 L 21.171875 24 L 7.5859375 37.585938 A 2.0002 2.0002 0 1 0 10.414062 40.414062 L 24 26.828125 L 37.585938 40.414062 A 2.0002 2.0002 0 1 0 40.414062 37.585938 L 26.828125 24 L 40.414062 10.414062 A 2.0002 2.0002 0 0 0 38.982422 6.9707031 z" />
                            </svg>
                        </button>
                        <!-- DELETE BUTTON -->
                        <button @click="destroy(selectedTask)"><svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg></button>
                    </div>
                    <p>Edit a task</p>
                    <!-- NAME -->
                    <div class="mt-3">
                        <label class="block font-medium text-gray-700 capitalize">Name</label>
                        <input
                            class="block mt-1 w-full rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                            v-model="form_editTask.name" type="text">
                    </div>

                    <!-- DATES -->
                    <label class="block  mt-3 font-medium text-gray-700 capitalize-first">dates</label>
                    <div class="flex items-center">
                        <input class="rounded mr-1 focus:ring-0 focus:ring-offset-0" type="date"
                            v-model="form_editTask.dates">
                    </div>

                    <!-- BEGIN AND END HOURS -->
                    <div class="mt-3 flex">
                        <!-- Begin -->
                        <div class="mr-16">
                            <label class="block font-medium text-gray-700 capitalize-first">Begin hour</label>
                            <input v-model="form_editTask.begin_hour" type="time">
                        </div>
                        <!-- END -->
                        <div class="">
                            <label class="block font-medium text-gray-700 capitalize-first">End hour</label>
                            <input v-model="form_editTask.end_hour" type="time">
                        </div>
                    </div>

                    <!-- UPDATE BUTTON  -->
                    <button @click="updateTask(form_editTask)"
                        class="mt-4 rounded border focus:ring-cyan-500 focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-50 active:bg-cyan-900 bg-cyan-800 hover:bg-cyan-700 font-medium w-full text-white px-2 py-1 uppercase">
                        Update the task
                    </button>

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
                                :class="{ 'text-orange-400': isCurrentDate(day) }">
                                {{ day.format('ddd D') }} <!-- Affiche le jour et le numéro du jour -->
                            </div>
                            <!-- Time slots for each hour in the day -->
                            <div class="grid grid-rows-9">
                                <div v-for="(hour, hourIndex) in hours" :key="`timeslot-${day}-${hourIndex}`"
                                    class="h-24 border-b border-black flex items-center justify-center box-border">
                                    <template v-for="task in getTasksWeekly(day, hour)" :key="task.id">
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
                    <!-- Loop over each week and then each day of the week -->
                    <div v-for="(week, weekIndex) in weeksInMonth" :key="weekIndex" class="contents">
                        <div v-for="(dayInfo, dayIndex) in week" :key="dayIndex" class="py-2 h-28 border-2 rounded-xl"
                            :class="{ 'bg-gray-200': !dayInfo.isInCurrentMonth, 'bg-slate-100': dayInfo.isInCurrentMonth, 'font-bold text-orange-600': dayInfo.date.isSame(new Date(), 'day') }">
                            <div>{{ dayInfo.date.format('D') }}</div>
                            <!-- Display tasks for each day -->
                            <div v-for="task in getTasksMonthly(dayInfo.date)" :key="task.id" class="task-item">
                                <!-- Display task details here -->
                                {{ task.name }}
                            </div>
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
import draggable from 'vuedraggable';

export default {
    components: {
        AppLayoutVertical,
        Tasks,
        draggable,
    },

    props: {
        tasks: Array,
        tasksNotDoneCount: Number,
        tasksDoneCount: Number,
    },

    data() {
        return {
            isOpenCreateTask: false,
            isOpenEditTask: false,
            selectedTask: null,

            isDailyPlanning: false,
            isWeeklyPlanning: false,
            isMonthlyPlanning: true,

            form_createTask: {
                name: null,
                dates: null,
                begin_hour: null,
                end_hour: null,
                taskable_type: null,
                taskable_id: null,
            },

            form_editTask: {
                name: null,
                dates: null,
                begin_hour: null,
                end_hour: null,
                taskable_type: null,
                taskable_id: null,
            },

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

    watch: {
        selectedTask: {
            handler() {
                if (this.selectedTask) {
                    this.form_editTask.name = this.selectedTask.name;
                    this.form_editTask.dates = this.selectedTask.dates;
                    this.form_editTask.begin_hour = this.selectedTask.begin_hour;
                    this.form_editTask.end_hour = this.selectedTask.end_hour;
                    this.form_editTask.taskable_type = this.selectedTask.taskable_type;
                    // this.form_editTask.taskable_id = this.selectedTask.taskable_id;
                }
            },
            deep: true,
            immediate: true
        }
    },

    methods: {
        // MODALE AND CRUD TASK
        closeCreateModale() {
            this.resetCreateForm();
            this.isOpenCreateTask = false;
        },
        closeEditModale() {
            this.isOpenEditTask = false;
        },
        resetCreateForm() {
            // reinitialize form
            this.form_createTask.name = null;
            this.form_createTask.dates = null;
            this.form_createTask.begin_hour = null;
            this.form_createTask.end_hour = null;
            this.form_createTask.taskable_type = null;
            this.form_createTask.taskable_id = null;
        },
        edit(element) {
            this.selectedTask = element;
            this.isOpenEditTask = true;
        },
        destroy(task) {
            this.isOpenEditTask = false;
            this.$inertia.delete(route('tasks.destroy', task));
        },



        // CALENDAR NAVIGATION
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

        // TASKS
        getTasksForSelectedDay() {
            const selectedDate = this.selectedDay.format('YYYY-MM-DD'); // Obtient la date d'aujourd'hui
            return this.tasks.filter(task => moment(task.dates).format('YYYY-MM-DD') === selectedDate);
        },

        // CALENDAR
        getTasksForDay(day) {
            // Format the day to match the date format of the tasks
            const formattedDay = moment(day, 'ddd').startOf('isoWeek').format('YYYY-MM-DD');
            // Filtrez les tâches en fonction de la date
            return this.tasks.filter(task => moment(task.dates).format('YYYY-MM-DD') === formattedDay);
        },

        // DISPLAY TASKS FOR THE MONTHLY PLANNING
        getTasksMonthly(day) {
            const formattedDay = moment(day).format('YYYY-MM-DD');

            return this.tasks.filter(task => {
                const taskDateStr = moment(task.dates).format('YYYY-MM-DD');
                return taskDateStr === formattedDay;
            });
        },

        // DISPLAY TASKS IN THE WEEKLY PLANNING
        getTasksWeekly(day, hour) {
            const formattedDay = moment(day).format('YYYY-MM-DD');
            const hourTime = moment(`${formattedDay} ${hour}`, 'YYYY-MM-DD HH:mm');

            return this.tasks.filter(task => {
                const taskDateStr = moment(task.dates).format('YYYY-MM-DD');
                const taskStartTimeStr = `${taskDateStr} ${task.begin_hour}`;
                const taskEndTimeStr = `${taskDateStr} ${task.end_hour}`;

                const taskStart = moment(taskStartTimeStr, 'YYYY-MM-DD HH:mm');
                const taskEnd = moment(taskEndTimeStr, 'YYYY-MM-DD HH:mm');

                return taskStart.isSameOrBefore(hourTime) && taskEnd.isSameOrAfter(hourTime);
            });
        },


        // DISPLAY TASKS IN THE DAILY PLANNING
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

        //TASKS FUNCTIONS
        updateTask() {
            this.$inertia.put(route('tasks.update', { task: this.selectedTask.id }), this.form_editTask, {
                onSuccess: () => this.isOpenEditTask = false,
            })
        },

        createTask() {
            this.$inertia.post(route('tasks.store'), this.form_createTask, {
                onSuccess: () => this.isOpenCreateTask = false,
            });
        },

        changeCheck(taskId, isChecked) {
            this.$inertia.post(route('tasks.update', { id: taskId }), {
                status: isChecked ? 'done' : 'not done'
            });
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
