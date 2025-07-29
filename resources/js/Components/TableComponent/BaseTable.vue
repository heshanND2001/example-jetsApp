<template>
    <div
        class="overflow-x-auto max-h-96 overflow-y-auto rounded-lg border border-gray-200 shadow-sm"
    >
        <table class="min-w-full divide-y divide-gray-200">
            <slot />
        </table>
    </div>
</template>

<script setup></script>
<style>
::-webkit-scrollbar {
    width: 6px;
}
::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}
</style>
