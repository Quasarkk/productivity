<template>
      <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-8">Tasks</h2>
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <div class="mx-4 my-4">
            <h3 class="text-xl font-bold text-gray-900">Today</h3>
            <!-- Create a task -->
            <div class="flex">
              <input v-model="form_createTask.name" placeholder="Do the dishes" class="rounded-md border-gray-300 shadow-sm">
              <button @click="createtask()"
                class="ml-2 px-4 py-2 text-lg text-white bg-blue-500 rounded-full hover:bg-blue-700 transition duration-300 ease-in-out">Create</button>
            </div>
            <!-- Display tasks -->
            <draggable :list="tasks" @end="updateTaskOrder" @input="updateTasks" class="drag-area my-4">
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
            form_createTask: {
                name: null
            },
        }
    },


    methods: {
        updateTasks(newTasks) {
            this.tasks = newTasks;
        },

        createtask() {
            this.$inertia.post(route('tasks.store'), this.form_createTask, {
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
