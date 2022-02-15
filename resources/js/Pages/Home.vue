<template>
    <div class="text-center">
        <Head title="Crawler Home"/>
        <h1>{{ title }}</h1>
        <p v-for="(p, id) in contents" :key="id">{{ p }}</p>

        <Link href="/abuud">About Page (shouldn't reload)</Link>
    </div>
</template>

<script>
import { Link, Head } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link,
        Head
    },

    props: {
        title: String,
        contents: [Object, Array]
    }
};
</script>

<style scoped>
.text-center {
    text-align: center;
}
</style>
