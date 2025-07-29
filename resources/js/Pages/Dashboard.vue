<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import HeaderTopic from "@/Components/HeaderTopic.vue";
</script>

<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <HeaderTopic> Dashboard </HeaderTopic>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
