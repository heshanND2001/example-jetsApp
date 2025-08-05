<template>
    <nav class="mt-4">
        <ul>
            <li>
                <NavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                >
                    Dashboard
                </NavLink>
            </li>
            <li>
                <NavLink
                    :href="route('task')"
                    :active="route().current('task')"
                >
                    Task
                </NavLink>
            </li>
            <li>
                <NavLink
                    v-if="can('users.view')"
                    :href="route('users.index')"
                    :active="route().current('users.index')"
                >
                    Users
                </NavLink>
            </li>
            <li>
                <NavLink
                    v-if="can('roles.view')"
                    :href="route('roles.index')"
                    :active="route().current('roles.index')"
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
