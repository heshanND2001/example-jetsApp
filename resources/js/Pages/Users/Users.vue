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

    <AdminLayout title="Users">
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

            <!-- <Link
                v-if="can('users.create')"
                @click="isTestModalOpen = true"
                class="cursor-pointer px-3 py-1 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Create User
            </Link> -->

            <div>
                <BaseButton
                    variant="primary"
                    v-if="can('users.create')"
                    @click="isTestModalOpen = true"
                >
                    Create User
                </BaseButton>
            </div>

            <div class="mt-4">
                <BaseTable :columns="userColumns" :data="users">
                    <!-- Roles column -->
                    <template #roles="{ row }">
                        <span
                            v-for="role in row.roles"
                            :key="role.id"
                            class="mr-1 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded"
                        >
                            {{ role.name }}
                        </span>
                    </template>

                    <!-- Online/Offline status -->
                    <template #is_online="{ row }">
                        <span
                            v-if="row.is_online"
                            class="text-green-600 font-bold"
                            >Online</span
                        >
                        <span v-else class="text-gray-400 font-bold"
                            >Offline</span
                        >
                    </template>

                    <!-- Block toggle -->
                    <template #is_blocked="{ row }">
                        <label
                            class="ms-2 inline-flex items-center cursor-pointer"
                        >
                            <input
                                type="checkbox"
                                class="sr-only peer"
                                :checked="!row.is_blocked"
                                :disabled="
                                    row.roles.some(
                                        (role) => role.name === 'admin'
                                    )
                                "
                                @change="toggleBlockUser(row)"
                            />
                            <div
                                class="w-11 h-6 bg-blue-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 relative"
                            ></div>
                        </label>
                    </template>

                    <!-- Actions column -->
                    <template #actions="{ row }">
                        <BaseButton
                            variant="green"
                            v-if="can('users.view')"
                            @click="viewUser(row)"
                            >Show</BaseButton
                        >
                        <BaseButton
                            variant="dark"
                            v-if="can('users.edit')"
                            @click="editUser(row)"
                            >Edit</BaseButton
                        >
                        <!-- <DangerButton
                            v-if="can('users.delete')"
                            @click="confirmDelete(row)"
                        >
                            Delete
                        </DangerButton> -->
                    </template>
                </BaseTable>
            </div>
        </div>
    </AdminLayout>

    <EditUserModal
        v-if="selectedUser"
        :user="selectedUser"
        :show="isEditModalOpen"
        :roles="props.roles"
        @close="isEditModalOpen = false"
        @updated="handleUserUpdate"
    />

    <CreateUserModal
        :show="isTestModalOpen"
        :roles="props.roles"
        @close="isTestModalOpen = false"
        @created="handleUserUpdate"
    />
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import { debounce } from "lodash";
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { can } from "@/lib/can";
import AdminLayout from "@/Layouts/AdminLayout.vue";

import EditUserModal from "./Components/EditUserModal.vue";
import CreateUserModal from "./Components/CreateUserModal.vue";
import TestModal from "./Components/CreateUserModal.vue";
import GreenButton from "@/Components/GreenButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import DarkButton from "@/Components/DarkButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseTable from "@/Components/TableComponent/BaseTable.vue";

const isTestModalOpen = ref(false);

const props = defineProps({
    roles: Array,
});

const userColumns = [
    { key: "name", label: "User Name" },
    { key: "email", label: "Email" },
    { key: "roles", label: "Roles" },
    ...(can("users.status") ? [{ key: "is_online", label: "Status" }] : []),
    ...(can("users.block_status")
        ? [{ key: "is_blocked", label: "Block Status" }]
        : []),
];

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

        const loggedInIds = loggedInUsers.value.map((u) => u.id);

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

// const editUser = (user) => {
//     // Redirect to the edit user page
//     window.location.href = `/users/${user.id}/edit`;
// };

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

const isEditModalOpen = ref(false);
const selectedUser = ref(null);

const handleUserUpdate = () => {
    loadUsers();
};

const editUser = (user) => {
    selectedUser.value = user;
    isEditModalOpen.value = true;
};

const isCreateModalOpen = ref(false);

const CreateUser = () => {
    isCreateModalOpen.value = true;
};
</script>
