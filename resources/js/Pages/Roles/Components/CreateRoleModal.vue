<template>
    <TransitionRoot as="template" :show="props.show">
        <Dialog class="relative z-10" @close="emit('close')">
            <ModalComponent>
                <AuthenticationCard class="p-3">
                    <div class="text-center mb-4 mt-0">
                        <AuthenticationCardLogo />
                        <h1 class="title font-semibold text-2xl">
                            Create Role
                        </h1>
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

                            <div class="flex items-center justify-end mt-4">
                                <BaseButton variant="dark" @click="close">
                                    Cancel
                                </BaseButton>
                                <BaseButton
                                    variant="primary"
                                    class="ms-4"
                                    :class="{
                                        'opacity-25': form.processing,
                                    }"
                                    :disabled="form.processing"
                                >
                                    Submit
                                </BaseButton>
                            </div>
                        </form>
                    </div>
                </AuthenticationCard>
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
import BaseButton from "@/Components/BaseButton.vue";
import ModalComponent from "@/Components/ModalComponent.vue";

const props = defineProps({
    show: Boolean,
    permissions: Array,
});
// const emit = defineEmits(["close"]);

// defineProps({
//     show: Boolean,
//     roles: Array,
// });

const emit = defineEmits(["close", "Create"]);

const form = useForm({
    name: "",
    permissions: [],
});

const submit = () => {
    form.post(route("roles.store"), {
        onSuccess: () => {
            emit("close"); // Close modal on success
        },
        onFinish: () => form.reset("name", "permissions"),
    });
};

const close = () => {
    emit("close");
};
</script>
