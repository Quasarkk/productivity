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
        <div class=" bg-gray-100 flex">
            <nav class="bg-zinc-300 h-screen w-1/12">
                <!-- Primary Navigation Menu -->
                <div>
                    <!-- Navigation Links -->
                    <div>

                    </div>

                </div>
            </nav>





            <!-- Page Content -->
            <main class="w-11/12">
                <slot />
            </main>
        </div>
    </div>
</template>
