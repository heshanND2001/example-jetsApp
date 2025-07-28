<template>
    <div class="flex h-screen bg-gray-100">
        <aside
            class="h-full flex flex-col bg-white shadow-md transition-all duration-300 ease-in-out w-64 border-2 border-solid border-l"
        >
            <div class="flex items-center p-4 border-b">
                <div class="flex items-center">
                    <Link :href="route('dashboard')">
                        <ApplicationMark class="block h-9 w-auto" />
                    </Link>
                </div>
                <span class="text-4xl font-bold ms-3">Admin</span>
            </div>

            <AppSidebar />

            <!-- <h1>Admin Dashboard</h1> -->
        </aside>

        <div class="w-full">
            <!-- Page Content -->
            <AppHeader>
                <template #header>
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        {{ title }}
                    </h2>
                </template>
            </AppHeader>
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

import AppHeader from "./Header/AppHeader.vue";
import AppSidebar from "./Header/AppSidebar.vue";

import { can } from "@/lib/can";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const logout = () => {
    router.post(route("logout"));
};
</script>
