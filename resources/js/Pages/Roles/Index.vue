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

    <AdminLayout title="Roles">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
        </template>

        <div
            class="p-12 max-w-7xl mx-auto sm:px-6 lg:px-8 border border-b border-gray-200 mt-4 rounded-lg shadow-lg"
        >
            <BaseButton
                variant="primary"
                v-if="can('roles.create')"
                @click="openCreateModal"
            >
                Create Role
            </BaseButton>

            <!-- <BaseButton variant="primary" @click="handleClick">
                Delete
            </BaseButton> -->

            <hr class="my-4" />

            <BaseTable
                :columns="[
                    { key: 'id', label: 'ID' },
                    { key: 'name', label: 'Name' },
                    { key: 'permissions', label: 'Permissions' },
                ]"
                :data="roles"
            >
                <!-- Custom cell for permissions -->
                <template #permissions="{ row }">
                    <div class="flex flex-wrap gap-1">
                        <span
                            v-for="p in row.permissions"
                            :key="p.id"
                            class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded"
                        >
                            {{ p.name }}
                        </span>
                    </div>
                </template>

                <!-- Action buttons -->
                <template #actions="{ row }">
                    <BaseButton
                        variant="green"
                        v-if="can('roles.view')"
                        @click="openShowModal(row)"
                        >Show</BaseButton
                    >
                    <BaseButton
                        variant="dark"
                        v-if="can('roles.edit')"
                        @click="openEditModal(row)"
                        >Edit</BaseButton
                    >
                    <!-- <BaseButton
                        variant="danger"
                        v-if="can('roles.delete')"
                        @click="confirmDelete(row)"
                    >
                        Delete
                    </BaseButton> -->
                </template>
            </BaseTable>
        </div>
    </AdminLayout>

    <EditRoleModal
        v-if="selectedRole"
        :show="showEditModal"
        :role="selectedRole"
        :permissions="allPermissions"
        :rolePermissions="selectedRolePermissions"
        @close="closeEditModal"
    />

    <ShowRolePermissionModal
        v-if="selectedRole"
        :show="showRoleModal"
        :role="selectedRole"
        @close="closeShowModal"
    />

    <CreateRoleModal
        :show="showCreateModal"
        :permissions="allPermissions"
        @close="closeCreateModal"
    />
</template>

<script setup>
import { ref, computed } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, usePage, router } from "@inertiajs/vue3";
import { can } from "@/lib/can";
import EditRoleModal from "./Components/EditRoleModal.vue";
import ShowRolePermissionModal from "./Components/ShowRolePermissionModal.vue";
import CreateRoleModal from "./Components/CreateRoleModal.vue";
import GreenButton from "@/Components/GreenButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import DarkButton from "@/Components/DarkButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import BaseButton from "@/Components/BaseButton.vue";
import TableComponent from "@/Components/TableComponent/TableComponent.vue";
import BaseTable from "@/Components/TableComponent/BaseTable.vue";

// function handleClick() {
//     alert("Button clicked!");
// }

const roles = computed(() => usePage().props.roles);
const allPermissions = computed(() => usePage().props.permissions);

const showEditModal = ref(false);
const selectedRole = ref(null);
const selectedRolePermissions = ref([]);

const openEditModal = (role) => {
    selectedRole.value = role;
    selectedRolePermissions.value = role.permissions.map((p) => p.name);
    showEditModal.value = true;
};

const closeEditModal = () => {
    showEditModal.value = false;
    selectedRole.value = null;
    selectedRolePermissions.value = [];
};

const showRoleModal = ref(false);

const openShowModal = (role) => {
    selectedRole.value = role;
    selectedRolePermissions.value = role.permissions.map((p) => p.name);
    showRoleModal.value = true;
};

const closeShowModal = () => {
    showRoleModal.value = false;
    selectedRole.value = null;
    selectedRolePermissions.value = [];
};

const showCreateModal = ref(false);

const openCreateModal = () => {
    showCreateModal.value = true;
};

const closeCreateModal = () => {
    showCreateModal.value = false;
};

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
