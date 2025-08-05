<template>
    <TransitionRoot as="template" :show="props.show">
        <Dialog class="relative z-10" @close="emit('close')">
            <ModelComponent>
                <div class="p-4">
                    <div class="text-center">
                        <h1 class="title font-semibold text-2xl">Edit User</h1>
                    </div>

                    <div class="mb-4">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="block text-sm font-medium"
                                    >Name</label
                                >
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full border px-3 py-2 rounded"
                                />
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium"
                                    >Email</label
                                >
                                <input
                                    v-model="form.email"
                                    type="email"
                                    class="mt-1 block w-full border px-3 py-2 rounded"
                                />
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium"
                                    >Password</label
                                >
                                <input
                                    v-model="form.password"
                                    type="password"
                                    class="mt-1 block w-full border px-3 py-2 rounded"
                                />
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium"
                                    >Confirm Password</label
                                >
                                <input
                                    v-model="form.password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full border px-3 py-2 rounded"
                                />
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium"
                                    >Role</label
                                >
                                <select
                                    v-model="form.role"
                                    class="mt-1 block w-full border px-3 py-2 rounded"
                                >
                                    <option
                                        v-for="role in props.roles"
                                        :disabled="isAdmin"
                                        :key="role.id"
                                        :value="role.name"
                                    >
                                        {{ role.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="flex justify-end gap-2">
                                <BaseButton variant="dark" @click="close">
                                    Cancel
                                </BaseButton>
                                <BaseButton
                                    variant="primary"
                                    @click="handleSubmit"
                                >
                                    Save
                                </BaseButton>
                            </div>
                        </form>
                    </div>
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
            </ModelComponent>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { Dialog, TransitionRoot } from "@headlessui/vue";
import { watch, reactive, computed } from "vue";
import BaseButton from "@/Components/BaseButton.vue";
import ModelComponent from "@/Components/ModelComponent.vue";

const props = defineProps({
    user: Object,
    show: Boolean,
    roles: Array,
});

const emit = defineEmits(["close", "submit"]);

const isAdmin = computed(() => {
    return props.user?.roles?.some((role) => role.name === "admin");
});

const form = reactive({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "",
});

watch(
    () => props.user,
    (user) => {
        if (user) {
            form.name = user.name;
            form.email = user.email;
            form.password = "";
            form.password_confirmation = "";
            form.role = user.roles.length ? user.roles[0].name : "";
        }
    },
    { immediate: true }
);

const handleSubmit = () => {
    emit("submit", { ...form });
};

const close = () => {
    emit("close");
};
</script>
