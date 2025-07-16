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
    <AppLayout title="Show Role">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Show Role
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
                <p><strong>Name:</strong> {{ role.name }}</p>
                <p>
                    <strong>Permissions:</strong>
                    <span
                        v-for="permission in rolePermissions"
                        key="1"
                        class="mr-1 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5"
                        style="display: flex; flex-direction: column"
                        >{{ permission }}</span
                    >
                </p>
            </div>
        </AuthenticationCard>
    </AppLayout>
</template>

<script setup>
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    role: Object,
    rolePermissions: Array,
});
</script>
