<style>
.user {
    margin-bottom: 10px;
    padding: 10px;
    background-color: #f1f1f1;
    border-left: 5px solid #2196f3;
    display: flex;
    justify-content: space-between;
    justify-content: center;
}

.completed {
    text-decoration: line-through;
    color: gray;
    border-left-color: #4caf50;
}

form {
    display: inline;
}

.actions {
    display: flex;
    gap: 10px;
}
</style>

<template>
    <!-- <div class="bg-red-500 text-white p-4 rounded">
  Tailwind is working!
</div> -->

    <!-- <Head title="Task" /> -->

    <AppLayout title="Roles">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
        </template>

        <div
            class="p-12 mx-auto sm:px-6 lg:px-8 border border-b border-gray-200 mt-4 rounded-lg shadow-lg ms-4 ml-4"
        >
            <Link
                v-if="can('roles.create')"
                :href="route('roles.create')"
                class="cursor-pointer px-3 py-1 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Create Role
            </Link>

            <hr class="my-4" />

            <table class="table-fixed w-auto">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th class="w-1/4">Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="role in roles" :key="role.id">
                        <td
                            class="px-6 py-2 text-gray-900 dark:text-gray-white text-center"
                        >
                            {{ role.id }}
                        </td>
                        <td
                            class="px-6 py-2 text-gray-800 dark:text-gray-600 text-center"
                        >
                            {{ role.name }}
                        </td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                            <span
                                v-for="permission in role.permissions"
                                key="1"
                                class="mr-1 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5"
                                >{{ permission.name }}</span
                            >
                        </td>
                        <td>
                            <div class="actions justify-center">
                                <Link
                                    v-if="can('roles.view')"
                                    :href="route('roles.show', role.id)"
                                    class="cursor-pointer px-3 py-1 text-sm font-medium text-white bg-gray-500 hover:bg-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                >
                                    Show
                                </Link>
                                <Link
                                    v-if="can('roles.edit')"
                                    :href="route('roles.edit', role.id)"
                                    class="cursor-pointer px-3 py-1 text-sm font-medium text-white bg-gray-500 hover:bg-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                    >Edit</Link
                                >
                                <button
                                    v-if="can('roles.delete')"
                                    @click="confirmDelete(role.id)"
                                    class="cursor-pointer px-3 py-1 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>

<script setup>
import { computed } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, usePage, router } from "@inertiajs/vue3";
import { can } from "@/lib/can";

const roles = computed(() => usePage().props.roles);

const confirmDelete = (id) => {
    if (confirm("Are you sure you want to delete this role?")) {
        router.delete(route("roles.destroy", id), {
            onSuccess: () => {
                console.log("Role deleted successfully.");
            },
            onError: (errors) => {
                console.error("Error deleting role:", errors);
            },
        });
    }
};
</script>
