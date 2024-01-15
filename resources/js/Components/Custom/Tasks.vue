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
            </div>


            <!-- Display tasks -->
            <draggable :list="tasks" @end="updateTaskOrder" @input="updateTasks" class="drag-area">
                <template #item="{ element }">
                    <div :key="element.id"
                        class="task-item flex hover:bg-gray-200 focus:bg-slate-200 focus:cursor-move hover:cursor-move px-4 rounded">
                        <span class="drag-handle">☰</span> <!-- Icône pour le drag -->
                        <input class="my-auto" type="checkbox" :checked="element.status === 'done'"
                            @change="changeCheck(element.id, $event.target.checked)">
                        <p class="ml-2" :class="{ 'opacity-50 line-through decoration-2': element.status === 'done' }">
                            {{ element.name }}
                        </p>
                        <p>{{ element.relatedType }} {{ element.relatedName }}</p>
                    </div>
                </template>
            </draggable>
        </div>



    </section>
</template>

<script>
import draggable from 'vuedraggable';
import AppLayoutVertical from '@/Layouts/AppLayoutVertical.vue';


export default {
    props: {
        tasks: Array,
        tasksNotDoneCount: Number,
        tasksDoneCount: Number,
    },

    components: {
        draggable, AppLayoutVertical,
    },

    data() {
        return {
            form_create: {
                name: null
            },
        }
    },


    methods: {
        updateTasks(newTasks) {
            this.tasks = newTasks;
        },

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
