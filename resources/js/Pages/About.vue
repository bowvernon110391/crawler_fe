<template>
    <div>
        <Head title="About Crawler" />
        <n-h1>About</n-h1>
        <div>
            This is about page, let's go back
            <Link href="/">Home</Link>
        </div>
        <pre>{{ JSON.stringify($page, null, 2) }}</pre>
    </div>
</template>

<script>
import { Link, Head } from '@inertiajs/inertia-vue3'
import AppLayout from '../Layouts/AppLayout.vue'

export default {
    components: {
        Link,
        Head
    },

    layout: AppLayout
};
</script>

<style scoped>
.margin-auto {
    margin: 0 1.2rem;
}
</style>
