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
    <AppLayout title="Show Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Show User
            </h2>
            <Link
                href="/users"
                class="cursor-pointer px-3 py-1 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Back to Users
            </Link>
        </template>
        <Head title="Show User" />

        <AuthenticationCard>
            <div class="text-center mb-4 mt-0">
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
                        }}<span v-if="index < user.roles.length - 1">, </span>
                    </span>
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
    user: Object,
    role: Object,
});
</script>
