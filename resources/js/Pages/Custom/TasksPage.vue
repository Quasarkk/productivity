<template>
    <section class="bg-orange-50">
        <h2 class="w-full text-center">TASKS</h2>
        <div class="mx-4 my-4">
            <h3>Today</h3>
            <!-- Create a task -->
            <div class="flex">
                <input v-model="form_create.name" placeholder="Do the dishes" class=" rounded">
                <button @click="create()"
                    class="ml-2 px-2 py-1 bg-blue-200 rounded-xl border-blue-700 border-[1.8px]">Create</button>

                <!-- <input v-for="pillar in pillard" type="checkbox"> -->
            </div>

            <!-- Display tasks -->
            <!-- task to do -->
            <div class="mt-4">
                <h3>Todo - {{ tasksNotDoneCount }}</h3>
                <div v-for="task in tasks" :key="task.id" class="flex hover:bg-gray-200 focus:bg-slate-200 px-4 rounded w-1/3">
                    <div v-if="task.status === 'not done'" class="flex">
                        <input class="my-auto" type="checkbox" :checked="task.status === 'done'"
                            @change="changeCheck(task.id, $event.target.checked)">
                        <p class="ml-2"> {{ task.name }} </p>
                        <p> {{ task.relatedType }}  {{ task.relatedName }} </p>
                        <p> {{ task.taskable }} </p>
                    </div>
                </div>
            </div>

            <!-- tasks done -->
            <div class="mt-4">
                <h3>Done - {{ tasksDoneCount }}</h3>
                <div v-for="task in tasks" :key="task.id" class="flex">
                    <div v-if="task.status === 'done'" class="flex">
                        <input checked type="checkbox" :checked="task.status === 'not done'"
                            @change="changeCheck(task.id, $event.target.checked)">
                        <p class="ml-2 opacity-50 line-through decoration-2"> {{ task.name }} </p>
                        <p> {{ task.taskable }} </p>
                    </div>
                </div>
            </div>


        </div>


    </section>
</template>

<script>
export default {
    props: {
        tasks: Array,
        tasksNotDoneCount: Number,
        tasksDoneCount: Number,
    },

    data() {
        return {
            form_create: {
                name: null
            },
        }
    },


    methods: {
        create() {
            this.$inertia.post(route('tasks.store'), this.form_create, {
                preserveState: (page) => Object.keys(page.props.errors).length,
            })
        },

        changeCheck(taskId, isChecked) {
            this.$inertia.post(route('tasks.update', { id: taskId }), {
                status: isChecked ? 'done' : 'not done'
            });
        },
    }
}
</script>
