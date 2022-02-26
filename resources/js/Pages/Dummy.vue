<template>
    <n-h1>The ID of the data is {{ id }}</n-h1>
    <n-p>
        Should have some dummy #{{ id }} data here
    </n-p>
    <div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Button
        </button>
    </div>
</template>

<script setup>
defineProps({
    id: Number,
});
</script>