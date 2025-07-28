<template>
    <div class="overflow-x-auto max-h-96 overflow-y-auto border rounded">
        <table class="table-auto w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100 sticky top-0 z-10">
                <tr>
                    <th
                        v-for="col in columns"
                        :key="col.key"
                        class="border px-4 py-2 text-left"
                    >
                        {{ col.label }}
                    </th>
                    <th v-if="$slots.actions" class="border px-4 py-2">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in data" :key="row.id" class="hover:bg-gray-50">
                    <td
                        v-for="col in columns"
                        :key="col.key"
                        class="border px-4 py-1"
                    >
                        <slot :name="col.key" :row="row">
                            {{ row[col.key] }}
                        </slot>
                    </td>
                    <td
                        v-if="$slots.actions"
                        class="border px-4 py-1 text-center"
                    >
                        <slot name="actions" :row="row" />
                    </td>
                </tr>

                <tr v-if="!data.length">
                    <td
                        :colspan="columns.length + 1"
                        class="text-center py-4 text-gray-500"
                    >
                        No data available.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
defineProps({
    columns: { type: Array, required: true },
    data: { type: Array, required: true },
});
</script>

<style>
::-webkit-scrollbar {
    width: 6px;
}
::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}
</style>
