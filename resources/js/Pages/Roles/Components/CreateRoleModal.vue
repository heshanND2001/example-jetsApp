<template>
    <TransitionRoot as="template" :show="show">
        <Dialog class="relative z-10" @close="emit('close')">
            <ModelComponent>
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
                                    type="submit"
                                    variant="primary"
                                    class="ms-4"
                                >
                                    Submit
                                </BaseButton>
                            </div>
                        </form>
                    </div>
                </AuthenticationCard>
            </ModelComponent>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref } from "vue";
import { Dialog, TransitionRoot } from "@headlessui/vue";

import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import BaseButton from "@/Components/BaseButton.vue";
import ModelComponent from "@/Components/ModelComponent.vue";

const props = defineProps({
    show: Boolean,
    permissions: Array,
});

const emit = defineEmits(["close", "create"]);

const form = ref({
    name: "",
    permissions: [],
});

const submit = () => {
    emit("create", { ...form.value });
    reset();
};

const close = () => {
    emit("close");
    reset();
};

const reset = () => {
    form.value.name = "";
    form.value.permissions = [];
};
</script>
