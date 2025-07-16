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

    <AppLayout title="Task">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div
            class="p-12 max-w-7xl mx-auto sm:px-6 lg:px-8 border border-b border-gray-200 mt-4 rounded-lg shadow-lg"
        >
            <div class="flex justify-between mb-4 mt-4">
                <input
                    type="search"
                    placeholder="Search"
                    v-model="search"
                    class="w-1/4 border rounded px-2 py-1"
                />
            </div>

            <hr class="my-4" />

            <Link
                v-if="can('users.create')"
                href="/users/create"
                class="cursor-pointer px-3 py-1 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Create User
            </Link>

            <div class="mt-4">
                <table class="table-fixed w-full">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th v-if="can('users.status')">Status</th>
                            <th v-if="can('users.block_status')">
                                Block Status
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody v-if="loggedInUsers && users">
                        <tr
                            v-for="user in users"
                            :key="user.id"
                            class="p-12 max-w-7xl mx-auto sm:px-6 lg:px-8 border border-b border-gray-200 mt-4 rounded-lg shadow-lg h-10"
                        >
                            <td class="text-center">{{ user.name }}</td>
                            <td class="text-center">{{ user.email }}</td>

                            <td
                                class="px-6 py-2 text-gray-600 dark:text-gray-300 text-center"
                            >
                                <span
                                    v-for="role in user.roles"
                                    :key="role.id"
                                    class="mr-1 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5"
                                    >{{ role.name }}</span
                                >
                            </td>

                            <td v-if="can('users.status')" class="text-center">
                                <span
                                    v-if="user.is_online"
                                    class="text-green-600 font-bold"
                                    >Online
                                </span>
                                <span v-else class="text-gray-400 font-bold"
                                    >Offline
                                </span>
                            </td>
                            <td
                                v-if="can('users.block_status')"
                                class="text-center"
                            >
                                <label
                                    class="ms-2 inline-flex items-center cursor-pointer"
                                >
                                    <input
                                        type="checkbox"
                                        class="sr-only peer"
                                        :checked="!user.is_blocked"
                                        @change="toggleBlockUser(user)"
                                    />

                                    <!-- <td class="text-center">
                                        <input
                                            type="checkbox"
                                            :checked="user.blocked"
                                            @change="toggleBlockUser(user)"
                                            class="form-checkbox"
                                        />
                                    </td> -->

                                    <div
                                        class="w-11 h-6 bg-blue-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 relative"
                                    ></div>
                                </label>
                            </td>
                            <td
                                class="text-center flex justify-center gap-2 p-1"
                            >
                                <button
                                    v-if="can('users.view')"
                                    @click="viewUser(user)"
                                    class="cursor-pointer px-3 py-1 text-sm font-medium text-white bg-gray-500 hover:bg-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                >
                                    Show
                                </button>
                                <button
                                    v-if="can('users.edit')"
                                    @click="editUser(user)"
                                    class="cursor-pointer px-3 py-1 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                >
                                    Edit
                                </button>
                                <button
                                    v-if="can('users.delete')"
                                    @click="confirmDelete(user.id)"
                                    class="cursor-pointer px-3 py-1 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <!-- <tr
                        v-for="user in users"
                        :key="user.id"
                        class="p-12 max-w-7xl mx-auto sm:px-6 lg:px-8 border border-b border-gray-200 mt-4 rounded-lg shadow-lg h-10"
                    >
                        <td class="text-center">{{ user.name }}</td>
                        <td class="text-center">{{ user.email }}</td>
                        <td class="text-center">
                            <span
                                v-if="user.is_online"
                                class="text-green-600 font-bold"
                                >Online</span
                            >
                            <span v-else class="text-gray-400 font-bold"
                                >Offline</span
                            >
                        </td>
                    </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import { debounce } from "lodash";
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { can } from "@/lib/can";

const loggedInUsers = ref([]);

const fetchLoggedInUsers = async () => {
    const response = await axios.get("/logged-in-users");
    loggedInUsers.value = response.data.data;
};

onMounted(() => {
    fetchLoggedInUsers();
});

const users = ref([]);
const search = ref("");
const loading = ref(false);

// Load users on component mount
onMounted(() => {
    loadUsers();
});

// Watch for search changes
watch(
    search,
    debounce((q) => {
        loadUsers(q);
    }, 500)
);

const loadUsers = async (searchQuery = "") => {
    try {
        const response = await axios.get("/api/users", {
            params: { search: searchQuery },
        });

        const allUsers = response.data.data;

        // Create list of logged-in user IDs
        const loggedInIds = loggedInUsers.value.map((u) => u.id);

        // Add `is_online` property
        users.value = allUsers.map((user) => ({
            ...user,
            is_online: loggedInIds.includes(user.id),
        }));
    } catch (error) {
        console.error("Error loading users:", error);
    }
};

const toggleBlockUser = async (user) => {
    try {
        if (!user.is_blocked) {
            await axios.post(`/users/${user.id}/block`);
            user.is_blocked = true;
            alert(`${user.name} has been blocked and logged out.`);
            user.is_online = false; // Update online status
        } else {
            await axios.post(`/users/${user.id}/unblock`);
            user.is_blocked = false;
            alert(`${user.name} has been unblocked.`);
        }
    } catch (error) {
        console.error("Error blocking user:", error);
    }
};

const viewUser = (user) => {
    // Redirect to the user show page
    window.location.href = `/users/${user.id}`;
};

const editUser = (user) => {
    // Redirect to the edit user page
    window.location.href = `/users/${user.id}/edit`;
};

const confirmDelete = (userId) => {
    if (confirm("Are you sure you want to delete this user?")) {
        deleteUser(userId);
    }
};

// Add this function to handle user deletion
const deleteUser = async (userId) => {
    try {
        await axios.delete(`/api/users/${userId}`);
        users.value = users.value.filter((user) => user.id !== userId);
        alert("User deleted successfully.");
    } catch (error) {
        console.error("Error deleting user:", error);
        alert("Failed to delete user.");
    }
};
</script>
