<style>
.user {
    margin-bottom: 10px;
    padding: 10px;
    background-color: #f1f1f1;
    border-left: 5px solid #2196f3;
    display: flex;
    justify-content: space-between;
    justify-content: center;
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
    <AppLayout title="Edit Role">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Role
            </h2>
            <Link
                href="/roles"
                class="cursor-pointer px-3 py-1 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Back to Roles
            </Link>
        </template>
        <Head title="Create Role" />

        <AuthenticationCard>
            <div class="text-center mb-4 mt-0">
                <AuthenticationCardLogo />
                <h1 class="title font-semibold text-2xl">Create Role</h1>
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
                        <InputError class="mt-2" :message="form.errors.name" />
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
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit"
                        >
                            Submit
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </AuthenticationCard>
    </AppLayout>
</template>

<script setup>
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

const props = defineProps({
    role: Object,
    permissions: Array,
    rolePermissions: Array,
});

const form = useForm({
    name: props.role.name,
    permissions: props.rolePermissions || [],
});

const submit = () => {
    form.put(route("roles.update", props.role.id), {
        onFinish: () => form.reset("name", "permissions"),
    });
};
</script>
