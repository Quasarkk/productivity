<template>
    <AppLayoutVertical>
        <Tasks  :tasks="tasks" :tasksNotDoneCount="tasksNotDoneCount" :tasksDoneCount="tasksDoneCount"></Tasks>
    </AppLayoutVertical>
</template>

<script>
import draggable from 'vuedraggable';
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
}
</script>
