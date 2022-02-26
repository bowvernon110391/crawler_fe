<template>
    <div>
        <Head title="#"/>
        <n-h1>{{ title }}</n-h1>
        <n-p v-for="(c, id) in contents" :key="id">
            {{ c }}
        </n-p>
        <div class="flex flex-wrap justify-around gap-y-2">
            <Link href="/about" class="btn btn-blue">About Page</Link>
            <Link href="/dummy/1" class="btn btn-blue">Flash Info</Link>
            <Link href="/dummy/2" class="btn btn-blue">Flash Warning</Link>
            <Link href="/dummy/3" class="btn btn-blue">Flash Success</Link>
            <Link href="/dummy/4" class="btn btn-blue">Flash Error</Link>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: String,
    contents: Array
})
</script>