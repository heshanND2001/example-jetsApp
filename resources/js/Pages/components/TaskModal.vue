<style scoped>
.topic {
    align-items: center;
}

.taskInput {
    width: 100%;
    padding: 3px;
    font-size: 15px;
    font-family: inherit;
    border: 1px solid #d1d5db;
    border-radius: 5px;
    background-color: #fff;
    color: #111827;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    box-sizing: border-box;
    margin-bottom: 10px;
}
.modal-backdrop {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}
.modal {
    background: white;
    padding: 20px;
    border-radius: 8px;
}

.updatebtn {
    background-color: greenyellow;
    color: #000;
    padding: 3px;
    font-size: 15px;
    border: none;
    border-radius: 5px;
    margin: 5px;
}

.cancelbtn {
    background-color: red;
    color: #000;
    padding: 3px;
    font-size: 15px;
    border: none;
    border-radius: 5px;
    margin: 5px;
}
</style>

<template>
    <div v-if="show" class="modal-backdrop">
        <div class="modal">
            <h2 class="fw-bold">Edit Task</h2>
            <form @submit.prevent="submit">
                <input
                    v-model="form.title"
                    type="text"
                    required
                    class="taskInput"
                />
                <div class="p-2">
                    <button
                        type="submit"
                        class="bg-green-400 rounded p-1 text-white"
                        :disabled="loading"
                    >
                        {{ loading ? "Updating..." : "Update" }}
                    </button>
                    <button
                        @click="$emit('close')"
                        class="bg-red-500 rounded p-1 ms-3 text-white"
                        :disabled="loading"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { defineProps, watch, reactive, ref } from "vue";

const props = defineProps({
    show: Boolean,
    task: Object,
});

const emit = defineEmits(["close", "update"]);

const form = reactive({
    title: "",
});

const loading = ref(false);
watch(
    () => props.task,
    (task) => {
        if (task) {
            form.title = task.title;
        }
    }
);

const submit = async () => {
    if (!form.title.trim()) return;

    loading.value = true;
    try {
        // Emit the update event to parent component
        emit("update", {
            id: props.task.id,
            title: form.title,
        });
    } catch (error) {
        console.error("Error updating task:", error);
    } finally {
        loading.value = false;
    }
};
</script>
