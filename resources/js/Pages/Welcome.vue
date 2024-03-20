<template>
    <GuestLayout class="font-nunito">
        <h1 class="font-bold text-6xl text-center font-nunito">Finissez en avec la <br> <span class="">procrastination</span></h1>
        <p class="text-center text-2xl">Progressez dans chacun des domaines qui comptes pour vous</p>
        <div class="flex justify-center">
            <button class="bg-sky-600 text-sky-100 rounded-lg px-2 py-1 mx-auto text-2xl">
                S'inscrire
            </button>
        </div>
    </GuestLayout>
  </template>

  <script>
  import GuestLayout from '@/Layouts/GuestLayout.vue';

  export default {
    props:{

    },

    components: {
        GuestLayout,
    },
  };
  </script>
