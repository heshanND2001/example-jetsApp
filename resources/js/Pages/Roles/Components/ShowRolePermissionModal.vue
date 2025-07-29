<template>
    <TransitionRoot as="template" :show="props.show">
        <Dialog class="relative z-10" @close="emit('close')">
            <ModalComponent>
                <AuthenticationCard>
                    <div class="text-center mb-4 mt-0">
                        <AuthenticationCardLogo />
                        <DialogTitle class="title font-semibold text-2xl">
                            Show Role
                        </DialogTitle>
                    </div>

                    <div class="mb-4">
                        <p><strong>ID:</strong> {{ role.id }}</p>
                        <p><strong>Name:</strong> {{ role.name }}</p>
                        <p><strong>Permissions:</strong></p>
                        <div class="mt-1">
                            <span
                                v-for="permission in role.permissions"
                                :key="permission.id"
                                class="inline-block mr-1 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded"
                            >
                                {{ permission.name }}
                            </span>
                        </div>
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
