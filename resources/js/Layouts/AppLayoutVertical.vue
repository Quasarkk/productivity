<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>

        <Head :title="title" />
        <Banner />
        <div class=" flex">
            <nav class="bg-white h-screen w-1/12 border-r border-gray-300 fixed">
                <div class="flex flex-col space-y-2 p-4">
                    <!-- Logo or Application Mark here -->
                    <!-- <ApplicationMark class="mb-6" /> -->

                    <!-- Navigation Links -->
                    <NavLink :href="route('home')" :active="route().current('home')"
                        class="flex items-center p-2 space-x-2 rounded hover:bg-blue-100"
                        :class="{ 'bg-blue-200': route().current('home') }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 stroke-gray-500" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                        <span class="text-gray-600">Home</span>
                    </NavLink>

                    <NavLink :href="route('tasks')" :active="route().current('tasks')"
                        class="flex items-center p-2 space-x-2 rounded hover:bg-blue-100"
                        :class="{ 'bg-blue-200': route().current('tasks') }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 stroke-gray-500" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M9 12l2 2l4 -4" /></svg>
                        <span class="text-gray-600">Tasks</span>
                    </NavLink>

                    <NavLink :href="route('calendar')" :active="route().current('calendar')"
                        class="flex items-center p-2 space-x-2 rounded hover:bg-blue-100"
                        :class="{ 'bg-blue-200': route().current('calendar') }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 stroke-gray-500" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M7 14h.013" /><path d="M10.01 14h.005" /><path d="M13.01 14h.005" /><path d="M16.015 14h.005" /><path d="M13.015 17h.005" /><path d="M7.01 17h.005" /><path d="M10.01 17h.005" /></svg>
                        <span class="text-gray-600">Calendar</span>
                    </NavLink>

                    <NavLink :href="route('routines')" :active="route().current('routines')"
                        class="flex items-center p-2 space-x-2 rounded hover:bg-blue-100"
                        :class="{ 'bg-blue-200': route().current('routines') }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 stroke-gray-500" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" /><path d="M20 4v5h-5" /></svg>
                        <span class="text-gray-600">Routines</span>
                    </NavLink>

                    <NavLink :href="route('goals')" :active="route().current('goals')"
                    class="flex items-center p-2 space-x-2 rounded hover:bg-blue-100"
                    :class="{ 'bg-blue-200': route().current('goals') }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 stroke-gray-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 21l8 0" /><path d="M12 17l0 4" /><path d="M7 4l10 0" /><path d="M17 4v8a5 5 0 0 1 -10 0v-8" /><path d="M5 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /></svg>                    <span class="text-gray-600">Goals</span>
                </NavLink>

                </div>
            </nav>


            <!-- Page Content -->
            <main class="w-11/12 ml-auto min-h-max">
                <slot />
            </main>
        </div>
    </div>
</template>
