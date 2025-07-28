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
    <TransitionRoot as="template" :show="props.show">
        <Dialog class="relative z-10" @close="emit('close')">
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                        >
                            <div class="p-4">
                                <h2 class="fw-bold">Edit Task</h2>
                                <form @submit.prevent="submit">
                                    <input
                                        v-model="form.title"
                                        type="text"
                                        required
                                        class="taskInput"
                                    />
                                    <div class="p-2">
                                        <BaseButton
                                            variant="green"
                                            :disabled="loading"
                                        >
                                            {{
                                                loading
                                                    ? "Updating..."
                                                    : "Update"
                                            }}
                                        </BaseButton>
                                        <BaseButton
                                            variant="danger"
                                            @click="$emit('close')"
                                            :disabled="loading"
                                        >
                                            Cancel
                                        </BaseButton>
                                    </div>
                                </form>
                            </div>

                            <!-- <div
                                class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                            >
                                <button
                                    type="button"
                                    class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto"
                                    @click="emit('close')"
                                >
                                    Deactivate
                                </button>
                                <button
                                    type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="emit('close')"
                                >
                                    Cancel
                                </button>
                            </div> -->
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { ExclamationTriangleIcon } from "@heroicons/vue/24/outline";

import BaseButton from "@/Components/BaseButton.vue";
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
