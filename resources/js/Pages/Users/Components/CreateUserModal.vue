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
                                <div class="text-center">
                                    <h1 class="title font-semibold text-2xl">
                                        Create User
                                    </h1>
                                </div>

                                <div class="mb-4">
                                    <form @submit.prevent="submit">
                                        <div>
                                            <InputLabel
                                                for="name"
                                                value="Name"
                                            />
                                            <TextInput
                                                id="name"
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

                                        <div class="mt-4">
                                            <InputLabel
                                                for="email"
                                                value="Email"
                                            />
                                            <TextInput
                                                id="email"
                                                v-model="form.email"
                                                type="email"
                                                class="mt-1 block w-full"
                                                required
                                                autocomplete="username"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.email"
                                            />
                                        </div>

                                        <div class="mt-4">
                                            <InputLabel
                                                for="password"
                                                value="Password"
                                            />
                                            <TextInput
                                                id="password"
                                                v-model="form.password"
                                                type="password"
                                                class="mt-1 block w-full"
                                                required
                                                autocomplete="new-password"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.password"
                                            />
                                        </div>

                                        <div class="mt-4">
                                            <InputLabel
                                                for="password_confirmation"
                                                value="Confirm Password"
                                            />
                                            <TextInput
                                                id="password_confirmation"
                                                v-model="
                                                    form.password_confirmation
                                                "
                                                type="password"
                                                class="mt-1 block w-full"
                                                required
                                                autocomplete="new-password"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="
                                                    form.errors
                                                        .password_confirmation
                                                "
                                            />
                                        </div>

                                        <div
                                            v-if="
                                                $page.props.jetstream
                                                    .hasTermsAndPrivacyPolicyFeature
                                            "
                                            class="mt-4"
                                        >
                                            <InputLabel for="terms">
                                                <div class="flex items-center">
                                                    <Checkbox
                                                        id="terms"
                                                        v-model:checked="
                                                            form.terms
                                                        "
                                                        name="terms"
                                                        required
                                                    />

                                                    <div class="ms-2">
                                                        I agree to the
                                                        <a
                                                            target="_blank"
                                                            :href="
                                                                route(
                                                                    'terms.show'
                                                                )
                                                            "
                                                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                            >Terms of Service</a
                                                        >
                                                        and
                                                        <a
                                                            target="_blank"
                                                            :href="
                                                                route(
                                                                    'policy.show'
                                                                )
                                                            "
                                                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                            >Privacy Policy</a
                                                        >
                                                    </div>
                                                </div>
                                                <InputError
                                                    class="mt-2"
                                                    :message="form.errors.terms"
                                                />
                                            </InputLabel>
                                        </div>

                                        <!-- Example select -->
                                        <div class="mt-4">
                                            <InputLabel
                                                for="role"
                                                value="Role"
                                            />
                                            <select
                                                id="role"
                                                v-model="form.role"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                            >
                                                <option disabled value="">
                                                    Select a role
                                                </option>
                                                <option
                                                    v-for="role in props.roles"
                                                    :key="role.id"
                                                    :value="role.name"
                                                >
                                                    {{ role.name }}
                                                </option>
                                            </select>
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.role"
                                            />
                                        </div>

                                        <div
                                            class="flex items-center justify-end mt-4"
                                        >
                                            <BaseButton
                                                variant="dark"
                                                @click="close"
                                            >
                                                Cancel
                                            </BaseButton>
                                            <BaseButton
                                                variant="primary"
                                                class="ms-4"
                                                :class="{
                                                    'opacity-25':
                                                        form.processing,
                                                }"
                                                :disabled="form.processing"
                                            >
                                                Submit
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

import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/DarkButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import BaseButton from "@/Components/BaseButton.vue";

const props = defineProps({
    show: Boolean,
    roles: Array,
});
// const emit = defineEmits(["close"]);

// defineProps({
//     show: Boolean,
//     roles: Array,
// });

const emit = defineEmits(["close", "Create"]);

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
    role: "", // ✅ corrected
});

const submit = () => {
    form.post(route("users.store"), {
        onSuccess: () => {
            emit("created");
            emit("close");
        },
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};

const close = () => {
    emit("close");
};
</script>
