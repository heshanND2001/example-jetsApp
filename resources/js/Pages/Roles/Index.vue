<template>
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

            <hr class="my-4" />

            <base-table>
                <table-header>
                    <table-header-row>
                        <table-header-item>ID</table-header-item>
                        <table-header-item>Name</table-header-item>
                        <table-header-item>Permissions</table-header-item>
                        <table-header-item>Actions</table-header-item>
                    </table-header-row>
                </table-header>

                <table-body>
                    <table-row v-for="role in roles" :key="role.id">
                        <table-item>{{ role.id }}</table-item>
                        <table-item>{{ role.name }}</table-item>

                        <table-item>
                            <div class="flex flex-wrap gap-1">
                                <span
                                    v-for="p in role.permissions"
                                    :key="p.id"
                                    class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded"
                                >
                                    {{ p.name }}
                                </span>
                            </div>
                        </table-item>

                        <table-item>
                            <BaseButton
                                variant="green"
                                v-if="can('roles.view')"
                                @click="openShowModal(role)"
                                >Show</BaseButton
                            >

                            <BaseButton
                                variant="dark"
                                v-if="can('roles.edit')"
                                @click="openEditModal(role)"
                                >Edit</BaseButton
                            >
                            <!-- <BaseButton
                        variant="danger"
                        v-if="can('roles.delete')"
                        @click="confirmDelete(row)"
                    >
                        Delete
                    </BaseButton> -->
                        </table-item>
                    </table-row>
                </table-body>
            </base-table>
        </div>
    </AdminLayout>

    <EditRoleModal
        v-if="selectedRole"
        :show="showEditModal"
        :role="selectedRole"
        :permissions="allPermissions"
        :rolePermissions="selectedRolePermissions"
        @close="closeEditModal"
        @update="handleUpdateRole"
    />

    <!-- <EditRoleModal
        v-if="selectedRole"
        :show="showEditModal"
        :role="selectedRole"
        :permissions="allPermissions"
        :rolePermissions="selectedRolePermissions"
        @close="closeEditModal"
    /> -->

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
        @create="handleCreateRole"
    />

    <!-- <CreateRoleModal
        :show="showCreateModal"
        :permissions="allPermissions"
        @close="closeCreateModal"
    /> -->
</template>

<script setup>
import { ref, computed } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { usePage, router } from "@inertiajs/vue3";
import { can } from "@/lib/can";
import EditRoleModal from "./Components/EditRoleModal.vue";
import ShowRolePermissionModal from "./Components/ShowRolePermissionModal.vue";
import CreateRoleModal from "./Components/CreateRoleModal.vue";
import BaseButton from "@/Components/BaseButton.vue";

import { useForm } from "@inertiajs/vue3";

import BaseTable from "@/Components/TableComponent/BaseTable.vue";
import TableHeader from "@/Components/TableComponent/TableHeader.vue";
import TableHeaderRow from "@/Components/TableComponent/TableHeaderRow.vue";
import TableHeaderItem from "@/Components/TableComponent/TableHeaderItem.vue";
import TableBody from "@/Components/TableComponent/TableBody.vue";
import TableRow from "@/Components/TableComponent/TableRow.vue";
import TableItem from "@/Components/TableComponent/TableItem.vue";

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
            onSuccess: () => console.log("Role deleted successfully."),
            onError: (errors) => console.error("Error deleting role:", errors),
        });
    }
};

const handleCreateRole = (data) => {
    const form = useForm({
        name: data.name,
        permissions: data.permissions,
    });

    form.post(route("roles.store"), {
        onSuccess: () => {
            closeCreateModal();
        },
    });
};

const handleUpdateRole = (data) => {
    const form = useForm({
        name: data.name,
        permissions: data.permissions,
    });

    form.put(route("roles.update", data.id), {
        onSuccess: () => {
            closeEditModal();
        },
        onError: (errors) => {
            console.error("Error updating role:", errors);
        },
    });
};
</script>
