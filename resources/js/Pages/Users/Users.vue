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
                <base-table>
                    <table-header>
                        <table-header-row>
                            <table-header-item>User Name</table-header-item>
                            <table-header-item>Email</table-header-item>
                            <table-header-item>Roles</table-header-item>

                            <table-header-item v-if="can('users.status')">
                                Status
                            </table-header-item>
                            <table-header-item v-if="can('users.block_status')">
                                Block Status
                            </table-header-item>

                            <table-header-item>Actions</table-header-item>
                        </table-header-row>
                    </table-header>

                    <table-body>
                        <table-row v-for="user in users" :key="user.id">
                            <table-item>{{ user.name }}</table-item>
                            <table-item>{{ user.email }}</table-item>

                            <table-item>
                                <span
                                    v-for="role in user.roles"
                                    :key="role.id"
                                    class="mr-1 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded"
                                >
                                    {{ role.name }}
                                </span>
                            </table-item>

                            <table-item v-if="can('users.status')">
                                <span
                                    v-if="user.is_online"
                                    class="text-green-600 font-bold"
                                >
                                    Online
                                </span>
                                <span v-else class="text-gray-400 font-bold">
                                    Offline
                                </span>
                            </table-item>

                            <table-item v-if="can('users.block_status')">
                                <label
                                    class="ms-2 inline-flex items-center cursor-pointer relative"
                                >
                                    <input
                                        type="checkbox"
                                        class="sr-only peer"
                                        :checked="!user.is_blocked"
                                        :disabled="
                                            user.roles.some(
                                                (role) => role.name === 'admin'
                                            )
                                        "
                                        @change="toggleBlockUser(user)"
                                    />
                                    <div
                                        class="w-11 h-6 bg-blue-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 relative"
                                    ></div>
                                </label>
                            </table-item>

                            <table-item>
                                <BaseButton
                                    variant="green"
                                    v-if="can('users.view')"
                                    @click="openShowModal(user)"
                                >
                                    Show
                                </BaseButton>

                                <BaseButton
                                    variant="dark"
                                    v-if="can('users.edit')"
                                    @click="editUser(user)"
                                >
                                    Edit
                                </BaseButton>

                                <!-- <DangerButton
                                    v-if="can('users.delete')"
                                    @click="confirmDelete(user)"
                                >
                                    Delete
                                </DangerButton> -->
                            </table-item>
                        </table-row>
                    </table-body>
                </base-table>
            </div>
        </div>
    </AdminLayout>

    <EditUserModal
        v-if="selectedUser"
        :user="selectedUser"
        :show="isEditModalOpen"
        :roles="props.roles"
        @close="isEditModalOpen = false"
        @submit="handleEditUserSubmit"
    />

    <!-- <EditUserModal
        v-if="selectedUser"
        :user="selectedUser"
        :show="isEditModalOpen"
        :roles="props.roles"
        @close="isEditModalOpen = false"
        @updated="handleUserUpdate"
    /> -->

    <CreateUserModal
        :show="isTestModalOpen"
        :roles="props.roles"
        @close="isTestModalOpen = false"
        @submit="handleCreateUser"
    />

    <ShowUserModal
        v-if="selectedUser"
        :show="showUserModal"
        :user="selectedUser"
        @close="closeShowModal"
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
// import BaseTable from "@/Components/TableComponent/BaseTable.vue";

import BaseTable from "@/Components/TableComponent/BaseTable.vue";
import TableHeader from "@/Components/TableComponent/TableHeader.vue";
import TableHeaderRow from "@/Components/TableComponent/TableHeaderRow.vue";
import TableHeaderItem from "@/Components/TableComponent/TableHeaderItem.vue";
import TableBody from "@/Components/TableComponent/TableBody.vue";
import TableRow from "@/Components/TableComponent/TableRow.vue";
import TableItem from "@/Components/TableComponent/TableItem.vue";
import ShowUserModal from "./Components/ShowUserModal.vue";

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

onMounted(() => {
    loadUsers();
});

// Utility function to format users with is_online flag
const formatUsers = (allUsers) => {
    const loggedInIds = loggedInUsers.value.map((u) => u.id);
    return allUsers.map((user) => ({
        ...user,
        is_online: loggedInIds.includes(user.id),
    }));
};

const loadUsers = async () => {
    try {
        const response = await axios.get("/api/users");
        users.value = formatUsers(response.data.data);
    } catch (error) {
        console.error("Error loading users:", error);
    }
};

const searchUsers = async (query) => {
    try {
        const response = await axios.get("/api/users", {
            params: { search: query },
        });
        users.value = formatUsers(response.data.data);
    } catch (error) {
        console.error("Error searching users:", error);
    }
};

watch(
    search,
    debounce((q) => {
        if (q) {
            searchUsers(q);
        } else {
            loadUsers();
        }
    }, 500)
);

// watch(
//     search,
//     debounce((q) => {
//         loadUsers(q);
//     }, 500)
// );

// const loadUsers = async (searchQuery = "") => {
//     try {
//         const response = await axios.get("/api/users", {
//             params: { search: searchQuery },
//         });

//         const allUsers = response.data.data;

//         const loggedInIds = loggedInUsers.value.map((u) => u.id);

//         users.value = allUsers.map((user) => ({
//             ...user,
//             is_online: loggedInIds.includes(user.id),
//         }));
//     } catch (error) {
//         console.error("Error loading users:", error);
//     }
// };

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

const showUserModal = ref(false);
const openShowModal = (user) => {
    selectedUser.value = user;
    showUserModal.value = true;
};
const closeShowModal = () => {
    showUserModal.value = false;
    selectedUser.value = null;
};

const handleCreateUser = async (formData) => {
    try {
        const response = await axios.post(route("users.store"), formData);
        alert("User created successfully!");
        loadUsers();
        isTestModalOpen.value = false;
    } catch (error) {
        console.error("Error creating user:", error);

        if (error.response && error.response.status === 422) {
            alert("Validation failed. Please check your input.");
        } else {
            alert("An unexpected error occurred.");
        }
    }
};

const handleEditUserSubmit = async (formData) => {
    if (!selectedUser.value || !selectedUser.value.id) {
        console.error("User ID is missing", selectedUser.value);
        alert("User ID not found.");
        return;
    }

    const url = `/users/${selectedUser.value.id}`;

    try {
        await axios.put(url, formData);
        alert("User updated successfully!");

        isEditModalOpen.value = false;
        selectedUser.value = null;
        loadUsers();
    } catch (error) {
        console.error("Error updating user:", error);
        if (error.response && error.response.status === 422) {
            alert("Validation failed. Please check your input.");
        } else {
            alert("Failed to update user.");
        }
    }
};
</script>
