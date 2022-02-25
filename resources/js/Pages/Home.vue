<template>
    <div>
        <n-h1>{{ title }}</n-h1>
        <n-p v-for="(c, id) in contents" :key="id">
            {{ c }}
        </n-p>
        <div style="display: flex; justify-content: space-around;">
            <Link href="/about">About Page</Link>
            <Link href="/dummy/1">Flash Info</Link>
            <Link href="/dummy/2">Flash Warning</Link>
            <Link href="/dummy/3">Flash Success</Link>
            <Link href="/dummy/4">Flash Error</Link>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: String,
    contents: Array
})
</script>