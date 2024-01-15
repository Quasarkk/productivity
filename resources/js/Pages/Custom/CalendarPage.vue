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
                <div class="flex">
                    <button class="">prev</button>
                    <p class=" text-2xl font-semibold">July</p>
                    <button>next</button>
                </div>
                <!-- today + change buttons -->
                <div class="flex">
                    <button class="px-2 py-1 focus:bg-green-300 rounded shadow-md">Today</button>
                    <!-- Change buttons -->
                    <div class="border-2 shadow-md py-1 rounded">
                        <button @click="isMonthlyPlanning = true"
                            class="px-2 py-1 focus:bg-green-300 rounded">Month</button>
                        <button @click="isWeeklyPlanning = true" class="px-2 py-1 focus:bg-green-300 rounded">Week</button>
                        <button @click="isDailyPlanning = true" class="px-2 py-1 focus:bg-green-300 rounded">Day</button>
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

                <!-- day 1 -->
                <div class="h-screen w-[13.5714%] border-x-2 border-black">
                    <p class="text-center border-y-2 border-black">
                        Lundi <span class="bg-blue-400 px-2 py-1 rounded text-white ">15</span>
                    </p>
                    <!-- Heures -->
                    <div class="h-screen">
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

                        <div class="h-[10%] border-b-2 border-black">

                        </div>
                    </div>
                </div>

                <!-- day 2 -->
                <div class="h-screen w-[13.5714%] border-r-2 border-black">
                    <p class="text-center border-y-2 border-black">
                        Mardi 16
                    </p>
                    <!-- Heures -->
                    <div class="h-screen">
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

                        <div class="h-[10%] border-b-2 border-black">

                        </div>
                    </div>
                </div>

                <!-- day 3 -->
                <div class="h-screen w-[13.5714%] border-r-2 border-black">
                    <p class="text-center border-y-2 border-black">
                        Mecredi 17
                    </p>
                    <!-- Heures -->
                    <div class="h-screen">
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

                        <div class="h-[10%] border-b-2 border-black">

                        </div>
                    </div>
                </div>

                <!-- day 4 -->
                <div class="h-screen w-[13.5714%] border-r-2 border-black">
                    <p class="text-center border-y-2 border-black">
                        Jeudi 18
                    </p>
                    <!-- Heures -->
                    <div class="h-screen">
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

                        <div class="h-[10%] border-b-2 border-black">

                        </div>
                    </div>
                </div>

                <!-- day 5 -->
                <div class="h-screen w-[13.5714%] border-r-2 border-black">
                    <p class="text-center border-y-2 border-black">
                        Vendredi 19
                    </p>
                    <!-- Heures -->
                    <div class="h-screen">
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

                        <div class="h-[10%] border-b-2 border-black">

                        </div>
                    </div>
                </div>

                <!-- day 6 -->
                <div class="h-screen w-[13.5714%] border-r-2 border-black">
                    <p class="text-center border-y-2 border-black">
                        Samedi 20
                    </p>
                    <!-- Heures -->
                    <div class="h-screen">
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

                        <div class="h-[10%] border-b-2 border-black">

                        </div>
                    </div>
                </div>

                <!-- day 7 -->
                <div class="h-screen w-[13.5714%] border-r-2 border-black">
                    <p class="text-center border-y-2 border-black">
                        Dimanche 21
                    </p>
                    <!-- Heures -->
                    <div class="h-screen">
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

                        <div class="h-[10%] border-b-2 border-black">

                        </div>
                    </div>
                </div>
            </div>

            <!-- monthly planning -->
            <div v-if="isMonthlyPlanning" class="h-screen ">
                monthly
                <!-- Grille du calendrier -->
                <div class="grid grid-cols-7 gap-2 text-center h-full">
                    <div class="font-bold">MON</div>
                    <div class="font-bold">TUE</div>
                    <div class="font-bold">WED</div>
                    <div class="font-bold">THU</div>
                    <div class="font-bold">FRI</div>
                    <div class="font-bold">SAT</div>
                    <div class="font-bold">SUN</div>
                    <!-- Jours et tâches -->
                    <!-- Répétez cette partie pour chaque jour du mois -->
                    <!-- Day 1 -->
                    <div class="py-2 border rounded">
                        1
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 2 -->
                    <div class="py-2 border rounded">
                        2
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 3 -->
                    <div class="py-2 border rounded">
                        3
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 4 -->
                    <div class="py-2 border rounded">
                        4
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 5 -->
                    <div class="py-2 border rounded">
                        5
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 6 -->
                    <div class="py-2 border rounded">
                        6
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 7 -->
                    <div class="py-2 border rounded">
                        7
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 8 -->
                    <div class="py-2 border rounded">
                        8
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 9 -->
                    <div class="py-2 border rounded">
                        9
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 10 -->
                    <div class="py-2 border rounded">
                        10
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 11 -->
                    <div class="py-2 border rounded">
                        11
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 12 -->
                    <div class="py-2 border rounded">
                        12
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 13 -->
                    <div class="py-2 border rounded">
                        13
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 14 -->
                    <div class="py-2 border rounded">
                        14
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 15 -->
                    <div class="py-2 border rounded">
                        15
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 16 -->
                    <div class="py-2 border rounded">
                        16
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 17 -->
                    <div class="py-2 border rounded">
                        17
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 18 -->
                    <div class="py-2 border rounded">
                        18
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 19 -->
                    <div class="py-2 border rounded">
                        19
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 20 -->
                    <div class="py-2 border rounded">
                        20
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 21 -->
                    <div class="py-2 border rounded">
                        21
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 22 -->
                    <div class="py-2 border rounded">
                        22
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 23 -->
                    <div class="py-2 border rounded">
                        23
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 24 -->
                    <div class="py-2 border rounded">
                        24
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 25 -->
                    <div class="py-2 border rounded">
                        25
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 26 -->
                    <div class="py-2 border rounded">
                        26
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 27 -->
                    <div class="py-2 border rounded">
                        27
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 28 -->
                    <div class="py-2 border rounded">
                        28
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 29 -->
                    <div class="py-2 border rounded">
                        29
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 30 -->
                    <div class="py-2 border rounded">
                        30
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 31 -->
                    <div class="py-2 border rounded">
                        31
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 32 -->
                    <div class="py-2 border rounded">
                        32
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 33 -->
                    <div class="py-2 border rounded">
                        33
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 34 -->
                    <div class="py-2 border rounded">
                        34
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                    <!-- Day 35 -->
                    <div class="py-2 border rounded">
                        35
                        <!-- Tasks here -->
                        <div class="text-xs mt-1 bg-blue-100 rounded p-1">Task 1</div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayoutVertical>
</template>
<script>
import AppLayoutVertical from '@/Layouts/AppLayoutVertical.vue';
import Tasks from '@/Components/Custom/Tasks.vue'

export default {
    props: {
        tasks: Array,
        tasksNotDoneCount: Number,
        tasksDoneCount: Number,
    },

    components: {
        AppLayoutVertical,
        Tasks,
    },

    data() {
        return {
            isDailyPlanning: false,
            isWeeklyPlanning: false,
            isMonthlyPlanning: false,

            // isWeeklyTodo:false,
            // isMonthlyTodo:false,
        }
    }

}
</script>
