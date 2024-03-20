<template>
    <AppLayoutVertical>
            <Tasks class="h-screen">
            </Tasks>
    </AppLayoutVertical>
  </template>

  <script>
  import AppLayoutVertical from '@/Layouts/AppLayoutVertical.vue';
  import Tasks from '@/Components/Custom/Tasks.vue';


  export default {
    props:{

    },

    components: {
        AppLayoutVertical,
        Tasks,
    },
  };
  </script>
