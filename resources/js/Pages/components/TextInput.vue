<script setup>

const model = defineModel({
    type: null,
    required: true
})

defineProps({
    name: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: 'text'
    },
    message: String
})
</script>

<template>
    <div class="mb-6">
            <label>{{ title }}</label>
            <input :type="type" v-model="form.title" />
            <small class="error" v-if="message">{{ message }}</small>
        </div>
</template>
