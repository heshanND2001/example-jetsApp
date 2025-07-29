<template>
    <TransitionRoot as="template" :show="props.show">
        <Dialog class="relative z-10" @close="emit('close')">
            <ModalComponent>
                <AuthenticationCard>
                    <div class="text-center">
                        <AuthenticationCardLogo />
                        <h1 class="title font-semibold text-2xl">Show User</h1>
                    </div>

                    <div class="mb-4">
                        <p><strong>Name:</strong> {{ user.name }}</p>
                        <p><strong>Email:</strong> {{ user.email }}</p>
                        <p>
                            <strong>Roles:</strong>
                            <span
                                v-for="(role, index) in user.roles"
                                :key="role.id"
                                class="mr-1 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded"
                            >
                                {{ role.name
                                }}<span v-if="index < user.roles.length - 1"
                                    >,
                                </span>
                            </span>
                        </p>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <button
                            type="button"
                            @click="close"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                        >
                            Cancel
                        </button>
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
import ModalComponent from "@/Components/ModalComponent.vue";

const props = defineProps({
    show: Boolean,
    user: Object,
    role: Object,
});
// const emit = defineEmits(["close"]);

// defineProps({
//     show: Boolean,
//     roles: Array,
// });

const emit = defineEmits(["close"]);

const close = () => {
    emit("close");
};
</script>
