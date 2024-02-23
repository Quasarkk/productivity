<template>
    <AppLayoutVertical>

        <div class="w-full min-h-full overflow-auto bg-slate-100  font-nunito text-[hsl(41deg,15%,20%)]">

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
                    <!-- Change view buttons with secondary action styling -->
                    <div class="flex space-x-1 bg-gray-100 p-1 rounded">
                        <button @click="ShowDailyPlanning()" class="px-4 py-2 text-gray-800 rounded shadow hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out"
                            :class="{ 'bg-blue-100 border border-blue-500 text-blue-800': isDailyPlanning, 'hover:bg-gray-200': !isDailyPlanning }">Day</button>
                        <button @click="ShowWeeklyPlanning()" class="px-4 py-2 text-gray-800 rounded shadow hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out"
                            :class="{ 'bg-blue-100 border border-blue-500 text-blue-800': isWeeklyPlanning, 'hover:bg-gray-200': !isWeeklyPlanning }">Week</button>
                        <button @click="ShowMonthlyPlanning()" class="px-4 py-2 text-gray-800 rounded shadow hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out"
                            :class="{ 'bg-blue-100 border border-blue-500 text-blue-800': isMonthlyPlanning, 'hover:bg-gray-200': !isMonthlyPlanning }">Month</button>
                    </div>
                </div>
            </div>

            <!-- DAILY PLANNING + TODO -->
            <div v-if="isDailyPlanning" class="h-screen ">
                <!-- CURRENT NEXT PREVIOUS DAY -->
                <div class="flex justify-center align-middle">
                    <button @click="goToPreviousDay()"><svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-8"
                            viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg></button>
                    <p class="text-3xl font-bold my-auto">{{ selectedDay.format('Do MMM YYYY') }}</p>
                    <button @click="goToNextDay()"><svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-8"
                            viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 6l6 6l-6 6" />
                        </svg>
                    </button>
                </div>

                <!-- PLANNING + TASKS -->
                <div class="flex justify-between">
                    <div class="flex w-[40%] pr-8">
                        <!-- PLANNING -->
                        <!-- HOURS -->
                        <div class="mt-6 w-20">
                            <div v-for="hour in hours" :key="hour"
                                class="h-12 border-gray-200 rounded-xl flex items-center justify-center box-border font-bold text-gray-600"
                                :class="{ 'text-orange-500 bg-orange-100': isCurrentTimeSlot(hour) }">
                                {{ hour }}
                            </div>
                        </div>

                        <div class="h-full w-full overflow-auto mt-12">
                            <div class="relative">
                                <!-- Displays tasks for the selected day -->
                                <div class="absolute top-0 left-0 right-0 ">
                                    <div v-for="task in getTasksForDay()" :key="task.id"
                                        class="bg-white border-gray-300 rounded-lg shadow-md absolute w-full"
                                        :class="BelongsToRoutine(task) ? 'task-stripe' : 'before:absolute before:bg-orange-400 before:w-[6px] before:rounded-l before:top-0 before:left-0 before:bottom-0'"
                                        :style="task.style">
                                        <span class="px-4 py-2 justify-center flex text-xl font-semibold text-gray-800">
                                            {{ task.name }}</span>
                                        <span class="px-4 py-2 justify-center flex text-xl font-semibold text-gray-800">
                                            {{ task.begin_hour }} - {{ task.end_hour }} </span>

                                        <span v-if="BelongsToRoutine(task)"
                                            class="px-4 py-2 justify-center flex text-xl font-semibold ">
                                            {{ task.relatedType }} <svg xmlns="http://www.w3.org/2000/svg" class="w-6"
                                                viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" />
                                                <path d="M20 4v5h-5" />
                                            </svg> </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- TODO -->
                    <div class="h-screen w-1/2 pl-8 mt-10">
                        <section class="bg-gray-50 rounded-xl border-2 border-gray-200 shadow-inner">
                            <h2 class="w-full text-center text-xl font-semibold text-gray-700 py-2">TASKS</h2>
                            <div class="mx-4 my-4">
                                <div class="flex justify-between">
                                    <h3 class="text-lg font-medium text-gray-600"> Today</h3>
                                    <button @click="isOpenCreateTask = true"
                                        class="ml-2 px-2 py-1 flex items-center justify-center bg-blue-100 rounded-xl border-blue-300 text-blue-600 hover:bg-blue-200">
                                        Add<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-1" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5v14" />
                                            <path d="M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- Display tasks -->
                                <draggable :list="getTasksForSelectedDay()" @end="updateTaskOrder" @input="updateTasks"
                                    class="drag-area">
                                    <template #item="{ element }">
                                        <div :key="element.id" @click="edit(element)"
                                            class="task-item flex items-center hover:bg-gray-100 focus:bg-gray-100 cursor-move px-4 py-2 rounded my-1">
                                            <span class="drag-handle text-gray-400 mr-2">☰</span> <!-- Icon for the drag -->
                                            <input class="form-checkbox h-5 w-5 text-blue-600" type="checkbox"
                                                :checked="element.status === 'done'"
                                                @change="changeCheck(element.id, $event.target.checked)">
                                            <p class="ml-2 text-gray-700"
                                                :class="{ 'text-gray-400 line-through': element.status === 'done' }">
                                                {{ element.name }}
                                            </p>
                                            <p class="ml-auto text-sm text-gray-500">{{ element.relatedType }} {{
                                                element.relatedName }}</p>
                                        </div>
                                    </template>
                                </draggable>
                            </div>
                        </section>

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
            </div>


            <!-- WEEKLY PLANNING-->
            <div v-if="isWeeklyPlanning" class=""> <!-- Hours column -->
                <div class="flex justify-center align-middle">
                    <button @click="goToPreviousWeek()"><svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-8"
                            viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg></button>
                    <p class="text-3xl font-bold my-auto">
                        Week {{ weekNumberInMonth }} - {{ selectedWeek.format('MMMM YYYY') }}
                    </p>
                    <button @click="goToNextWeek()"><svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-8"
                            viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 6l6 6l-6 6" />
                        </svg></button>
                </div>

                <div class="flex">
                    <div class="font-bold w-[5%] mt-12">
                        <div v-for="hour in hours" :key="hour"
                            class="h-24   border-[hsl(41deg,10%,80%)] flex items-center justify-center box-border">
                            {{ hour }}
                        </div>
                    </div>

                    <!-- Days and time slots grid -->
                    <div class="flex-grow grid grid-cols-7">
                        <!-- Afficher chaque jour de la semaine avec sa date -->
                        <div v-for="(day, index) in weekDaysWithDates" :key="index"
                            class="border-l-2  border-[hsl(41deg,10%,80%)]">
                            <div class="text-center font-extrabold text-xl h-24 border-b-2  border-[hsl(41deg,10%,80%)] p-4"
                                :class="{ 'text-orange-600': isCurrentDate(day) }">
                                {{ day.format('ddd D') }} <!-- Affiche le jour et le numéro du jour -->
                            </div>

                            <!-- Time slots for each hour in the day -->
                            <div class="grid grid-rows-9">
                                <div v-for="(hour, hourIndex) in hours" :key="`timeslot-${day}-${hourIndex}`"
                                    class="h-24 border-b-2  border-[hsl(41deg,10%,80%)] flex items-center justify-center box-border">
                                    <template v-for="task in getTasksWeekly(day, hour)" :key="task.id">
                                        <span class="bg-red-200 w-full h-full rounded shadow-xl">{{ task.name }}</span>
                                    </template>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>

            <!-- MONTHLY PLANNING-->
            <div v-if="isMonthlyPlanning" class="h-20">
                <div class="flex justify-center align-middle mb-8">
                    <button @click="goToPreviousMonth()"><svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-8"
                            viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg></button>
                    <p class="text-3xl font-bold my-auto">{{ selectedMonth.format('MMMM YYYY') }}</p>
                    <button @click="goToNextMonth()"><svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-8"
                            viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 6l6 6l-6 6" />
                        </svg></button>
                </div>


                <!-- Names of the week days -->
                <div class="grid grid-cols-7 gap-2 text-center w-[98%] mx-auto">
                    <div class="font-extrabold text-xl flex justify-center items-center" v-for=" day  in  days " :key="day"
                        :class="{ 'text-orange-600': day === currentDay }">
                        {{ day }}
                    </div>
                </div>
                <!-- Calendar's grid -->
                <div class="grid grid-cols-7 gap-2 text-center mt-2 w-[98%] mx-auto">
                    <!-- Loop over each week and then each day of the week -->
                    <div v-for="(week, weekIndex) in weeksInMonth" :key="weekIndex" class="contents">
                        <div v-for="(dayInfo, dayIndex) in week" :key="dayIndex"
                            class="py-2 h-28 border-2 border-[hsl(41deg,10%,80%)] rounded-xl"
                            :class="{ 'bg-gray-200': !dayInfo.isInCurrentMonth, 'bg-slate-100': dayInfo.isInCurrentMonth, ' text-orange-600': dayInfo.date.isSame(new Date(), 'day') }">
                            <div class="font-bold text-lg">{{ dayInfo.date.format('D') }}</div>
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

    created() {
        setInterval(() => {
            this.currentTime = new Date(); // met à jour l'heure actuelle chaque seconde
        }, 60000);
    },

    data() {
        return {
            isOpenCreateTask: false,
            isOpenEditTask: false,
            selectedTask: null,
            currentTime: new Date(), // stocke l'heure actuelle

            isDailyPlanning: true,
            isWeeklyPlanning: false,
            isMonthlyPlanning: false,

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

            currentDay: moment().format('dddd'), // Ajoutez cette ligne

            days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            hours: ['8', '8:30', '9', '9:30', '10', '10:30', '11', '11:30', '12', '12:30', '13', '13:30', '14', '14:30', '15', '15:30', '16', '16:30', '17', '17:30', '18', '18:30']

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
        getTasksForDay() {
            const selectedDayStr = moment(this.selectedDay).format('YYYY-MM-DD');

            return this.tasks.filter(task => {
                if (!task.dates || !task.begin_hour || !task.end_hour) {
                    return false;
                }

                const taskDateStr = moment(task.dates).format('YYYY-MM-DD');
                if (taskDateStr !== selectedDayStr) {
                    return false;
                }

                const taskStartTimeStr = `${taskDateStr} ${task.begin_hour}`;
                const taskEndTimeStr = `${taskDateStr} ${task.end_hour}`;

                if (!moment(taskStartTimeStr, 'YYYY-MM-DD HH:mm').isValid() || !moment(taskEndTimeStr, 'YYYY-MM-DD HH:mm').isValid()) {
                    console.warn('Invalid date format for task:', task);
                    return false;
                }

                // Ajout des propriétés de style à l'objet tâche pour l'affichage
                task.style = this.getTaskStyle(task);
                return true;
            });
        },

        // CHANGE HEIGHT DEPENDING ON THE DURATION AND TIMESLOT
        getTaskStyle(task) {
            if (!task.begin_hour || !task.end_hour) {
                // Gérer l'erreur ou retourner un style par défaut si les heures de début/fin ne sont pas définies
                return {
                    // Styles par défaut ou erreur
                };
            }

            // Calcul du nombre de timeslots depuis 8h00
            const startSlots = this.calculateTimeSlots(task.begin_hour);
            const endSlots = this.calculateTimeSlots(task.end_hour);

            // Calcul de la durée en nombre de timeslots
            const durationSlots = endSlots - startSlots;

            // Conversion des timeslots en 'rem'
            const startTopPosition = startSlots * 3; // 1 timeslot = 3rem
            const height = durationSlots * 3; // Durée en 'rem'

            // Retour des styles calculés
            return {
                height: `${height}rem`,
                top: `${startTopPosition}rem`,
                // Ajoutez ici d'autres propriétés de style si nécessaire
            };
        },

        calculateTimeSlots(timeString) {
            const [hours, minutes] = timeString.split(':').map(Number);
            // Calcul du nombre de timeslots depuis 8h00 (8h00 = 0 timeslot, 8h30 = 1 timeslot, etc.)
            const slotsFromEight = (hours - 8) * 2 + (minutes === 30 ? 1 : 0);
            return slotsFromEight;
        },

        // CHANGE CURRENT TIMESLOT COLOR
        isCurrentTimeSlot(hour) {
            const currentHour = this.currentTime.getHours();
            const currentMinutes = this.currentTime.getMinutes();
            const [planningHour, planningMinutes] = hour.split(':').map(Number);

            // Convertir l'heure et les minutes du planning en minutes depuis minuit
            const planningTimeInMinutes = planningHour * 60 + (planningMinutes || 0);
            // Convertir l'heure actuelle en minutes depuis minuit
            const currentTimeInMinutes = currentHour * 60 + currentMinutes;

            // Vérifier si l'heure actuelle est dans le timeslot courant
            return currentTimeInMinutes >= planningTimeInMinutes && currentTimeInMinutes < planningTimeInMinutes + 30;
        },

        // CHECK IF TASK IS ASSIGNED TO SOMETHING (ROUTINE, OBJECTIVE)
        BelongsToRoutine(task) {
            return task.relatedType === 'Routine';
        },

        // END TEST


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

        calculateTaskDuration(task) {
            const start = moment(`${task.dates} ${task.begin_hour}`, 'YYYY-MM-DD HH:mm');
            const end = moment(`${task.dates} ${task.end_hour}`, 'YYYY-MM-DD HH:mm');
            return end.diff(start, 'minutes');
        },

        calculateHeight(task) {
            const duration = this.calculateTaskDuration(task);
            // Supposons que 60 minutes équivalent à 100px de hauteur.
            return duration * (100 / 60);
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
