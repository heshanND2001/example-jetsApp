<template>
    <nav class="mt-4">
        <ul>
            <li>
                <NavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    class="flex w-full items-center px-4 py-3 text-gray-700 hover:bg-gray-200 hover:text-gray-900"
                >
                    Dashboard
                </NavLink>
            </li>
            <li>
                <NavLink
                    :href="route('task')"
                    :active="route().current('task')"
                    class="flex w-full items-center px-4 py-3 text-gray-700 hover:bg-gray-200 hover:text-gray-900"
                >
                    Task
                </NavLink>
            </li>
            <li>
                <NavLink
                    :href="route('users.index')"
                    :active="route().current('users.index')"
                    class="flex w-full items-center px-4 py-3 text-gray-700 hover:bg-gray-200 hover:text-gray-900"
                >
                    Users
                </NavLink>
            </li>
            <li>
                <NavLink
                    v-if="can('roles.view')"
                    :href="route('roles.index')"
                    :active="route().current('roles.index')"
                    class="flex w-full items-center px-4 py-3 text-gray-700 hover:bg-gray-200 hover:text-gray-900"
                >
                    Roles
                </NavLink>
            </li>
        </ul>
    </nav>
</template>

<script setup>
import NavLink from "@/Components/NavLink.vue";

import { can } from "@/lib/can";
</script>
