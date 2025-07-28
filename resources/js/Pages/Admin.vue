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

            <nav class="mt-4">
                <ul>
                    <li>
                        <a
                            href="#"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-200 hover:text-gray-900"
                        >
                            <span class="w-5 h-5 mr-3 font-bold">
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </NavLink>
                            </span>
                        </a>
                        <a
                            href="#"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-200 hover:text-gray-900"
                        >
                            <span class="w-5 h-5 mr-3 font-bold">
                                <NavLink
                                    :href="route('task')"
                                    :active="route().current('task')"
                                >
                                    Task
                                </NavLink>
                            </span>
                        </a>
                        <a
                            href="#"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-200 hover:text-gray-900"
                        >
                            <span class="w-5 h-5 mr-3 font-bold">
                                <NavLink
                                    :href="route('users.index')"
                                    :active="route().current('users.index')"
                                >
                                    Users
                                </NavLink>
                            </span>
                        </a>
                        <a
                            href="#"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-200 hover:text-gray-900"
                        >
                            <span class="w-5 h-5 mr-3 font-bold">
                                <NavLink
                                    v-if="can('roles.view')"
                                    :href="route('roles.index')"
                                    :active="route().current('roles.index')"
                                >
                                    Roles
                                </NavLink>
                            </span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- <h1>Admin Dashboard</h1> -->
        </aside>

        <header v-if="$slots.header" class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
</template>

<script setup>
import ApplicationMark from "@/Components/ApplicationMark.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import { can } from "@/lib/can";
</script>
