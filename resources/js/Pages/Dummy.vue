<template>
    <n-h1>The ID of the data is {{ id }}</n-h1>
    <n-p>
        Should have some dummy #{{ id }} data here
    </n-p>
</template>

<script setup>
defineProps({
    id: Number
})
</script>