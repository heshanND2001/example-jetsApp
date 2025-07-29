<template>
    <TransitionRoot as="template" :show="props.show">
        <Dialog class="relative z-10" @close="emit('close')">
            <ModalComponent>
                <AuthenticationCard class="p-3">
                    <div class="text-center mb-4 mt-0">
                        <h1 class="title font-semibold text-2xl">Edit Role</h1>
                    </div>

                    <div class="mb-4">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    name="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>
                            <InputLabel
                                for="permissions"
                                value="Permissions"
                                class="mt-4"
                            />

                            <div
                                class="mt-4"
                                v-for="permission in permissions"
                                :key="permission"
                            >
                                <input
                                    type="checkbox"
                                    :value="permission"
                                    v-model="form.permissions"
                                    class="w-4 h-4 mt-1"
                                    :id="`permission-${permission}`"
                                />
                                <label
                                    :for="`permission-${permission}`"
                                    class="ml-2 text-gray-800"
                                >
                                    {{ permission }}
                                </label>
                            </div>

                            <!-- <div class="mt-4" v-for="permission in permissions">
                        <TextInput
                            :value="permission"
                            v-model="form.permissions"
                            type="checkbox"
                            class="w-4 h-4 mt-1"
                        />
                        <span class="ml-2 text-gray-800">{{ permission }}</span>
                        <InputError
                            class="mt-2"
                            :message="form.errors.permissions"
                        />
                    </div> -->

                            <div class="flex items-center justify-end mt-4">
                                <button
                                    type="button"
                                    @click="close"
                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                                >
                                    Cancel
                                </button>
                                <PrimaryButton
                                    class="ms-4"
                                    :class="{
                                        'opacity-25': form.processing,
                                    }"
                                    :disabled="form.processing"
                                    type="submit"
                                >
                                    Submit
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </AuthenticationCard>

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
            </ModalComponent>
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

import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/DarkButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import ModalComponent from "@/Components/ModalComponent.vue";

const props = defineProps({
    show: Boolean,
    role: Object,
    permissions: Array,
    rolePermissions: Array,
});
// const emit = defineEmits(["close"]);

// defineProps({
//     show: Boolean,
//     roles: Array,
// });

const emit = defineEmits(["close", "Create"]);

const form = useForm({
    name: props.role.name,
    permissions: props.rolePermissions || [],
});

const submit = () => {
    form.put(route("roles.update", props.role.id), {
        onSuccess: () => {
            emit("close");
        },
        onFinish: () => form.reset("name", "permissions"),
    });
};

const close = () => {
    emit("close");
};
</script>
