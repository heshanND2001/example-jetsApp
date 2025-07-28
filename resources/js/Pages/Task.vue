<style>
.task {
    margin-bottom: 10px;
    padding: 10px;
    background-color: #f1f1f1;
    border-left: 5px solid #2196f3;
    display: flex;
    justify-content: space-between;
    align-items: center;
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

    <AdminLayout title="Task">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Task
            </h2>
        </template>

        <div
            class="p-12 max-w-7xl mx-auto sm:px-6 lg:px-8 border border-b border-gray-200 mt-4 rounded-lg shadow-lg"
        >
            <div class="text-center mb-4 mt-0">
                <h1 class="title font-bold text-2xl mt-0">New Task</h1>
            </div>

            <div class="w-2/4 mb-2 mt-0">
                <form @submit.prevent="submit">
                    <div class="flex flex-col md:flex-row mb-3">
                        <h1 class="w-1/4 text-lg">Task Name :-</h1>
                        <input
                            type="text"
                            v-model="form.title"
                            required
                            class="ms-2 border rounded px-2 py-1"
                        />
                        <small
                            v-if="form.errors.title"
                            class="text-red-500 ms-2"
                            >{{ form.errors.title[0] }}</small
                        >

                        <PrimaryButton class="ms-2" :disabled="loading">
                            {{ loading ? "Adding..." : "Add Task" }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>

            <hr />

            <div class="flex justify-between mb-4 mt-4">
                <input
                    type="search"
                    placeholder="Search"
                    v-model="search"
                    class="w-1/4 border rounded px-2 py-1"
                />
            </div>

            <!-- </div> -->

            <base-table>
                <table-header>
                    <table-header-row>
                        <table-header-item>ID</table-header-item>
                        <table-header-item>Task Title</table-header-item>
                        <table-header-item>Actions</table-header-item>
                    </table-header-row>
                </table-header>

                <table-body>
                    <table-row v-for="task in tasks" :key="task.id">
                        <table-item>{{ task.id }}</table-item>
                        <table-item>{{ task.title }}</table-item>

                        <table-item>
                            <BaseButton
                                variant="green"
                                @click="openEditModal(task)"
                            >
                                Update
                            </BaseButton>
                            <BaseButton
                                variant="danger"
                                @click="deleteTask(task.id)"
                                :disabled="deleting === task.id"
                            >
                                {{
                                    deleting === task.id
                                        ? "Deleting..."
                                        : "Delete"
                                }}
                            </BaseButton>
                        </table-item>
                    </table-row>
                </table-body>
            </base-table>

            <!-- Update Modal -->
            <TaskModal
                :show="showModal"
                :task="selectedTask"
                @close="showModal = false"
                @update="updateTask"
            />
        </div>
    </AdminLayout>
</template>

<script setup>
import { reactive, ref, watch, onMounted } from "vue";

import { debounce } from "lodash";

import TaskModal from "./components/TaskModal.vue";

import axios from "axios";

import AppLayout from "@/Layouts/AppLayout.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
// import BaseTable from "@/Components/TableComponent/BaseTable.vue";
import BaseButton from "@/Components/BaseButton.vue";

import BaseTable from "@/Components/TableComponent/BaseTable.vue";
import TableHeader from "@/Components/TableComponent/TableHeader.vue";
import TableHeaderRow from "@/Components/TableComponent/TableHeaderRow.vue";
import TableHeaderItem from "@/Components/TableComponent/TableHeaderItem.vue";
import TableBody from "@/Components/TableComponent/TableBody.vue";
import TableRow from "@/Components/TableComponent/TableRow.vue";
import TableItem from "@/Components/TableComponent/TableItem.vue";

const tasks = ref([]);
const search = ref("");

const loading = ref(false);
const deleting = ref(null);

// Load tasks on component mount
onMounted(() => {
    loadTasks();
});
// Watch for search changes

watch(
    search,
    debounce((q) => {
        loadTasks(q);
    }, 500)
);

const loadTasks = async (searchQuery = "") => {
    try {
        const response = await axios.get("/api/tasks", {
            params: { search: searchQuery },
        });
        tasks.value = response.data.data;
    } catch (error) {
        console.error("Error loading tasks:", error);
    }
};

const form = reactive({
    title: "",
    errors: {},
});
const submit = async () => {
    if (!form.title.trim()) return;

    loading.value = true;
    try {
        const response = await axios.post("/api/tasks", {
            title: form.title,
        });

        // Add new task to the list
        tasks.value.unshift(response.data.data);
        form.title = "";
        form.errors = {};
    } catch (error) {
        if (error.response?.data?.errors) {
            form.errors = error.response.data.errors;
        }
        console.error("Error creating task:", error);
    } finally {
        loading.value = false;
    }
};

const deleteTask = async (id) => {
    if (!confirm("Delete this task?")) return;

    deleting.value = id;
    try {
        await axios.delete(`/api/tasks/${id}`);
        // Remove task from the list
        tasks.value = tasks.value.filter((task) => task.id !== id);
    } catch (error) {
        console.error("Error deleting task:", error);
    } finally {
        deleting.value = null;
    }
};

// const deleteTask = async (id) => {
//   if (confirm('Delete this task?')) {
//     try {
//       const response = await axios.delete(`/api/task/${id}`);
//       alert(response.data.message);
//       router.reload({ only: ['tasks'] });
//     } catch (error) {
//       console.error(error);
//     }
//   }
// };

const showModal = ref(false);
const selectedTask = ref(null);

const openEditModal = (task) => {
    selectedTask.value = task;
    showModal.value = true;
};

const updateTask = async (updatedTask) => {
    try {
        const response = await axios.put(`/api/tasks/${updatedTask.id}`, {
            title: updatedTask.title,
        });

        // Update task in the list
        const index = tasks.value.findIndex(
            (task) => task.id === updatedTask.id
        );
        if (index !== -1) {
            tasks.value[index] = response.data.data;
        }

        showModal.value = false;
    } catch (error) {
        console.error("Error updating task:", error);
    }
};
</script>
