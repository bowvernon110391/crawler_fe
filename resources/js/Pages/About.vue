<template>
    <div class="margin-auto">
        <Head title="About Crawler" />
        <h1>About</h1>
        <div>
            This is about page, let's go back

            <Link href="/">Home</Link>
        </div>
        <pre>{{ JSON.stringify($page, null, 2) }}</pre>
    </div>
</template>

<script>
import { Link, Head } from '@inertiajs/inertia-vue3'
export default {
    components: {
        Link,
        Head
    }
};
</script>

<style scoped>
.margin-auto {
    margin: 0 1.2rem;
}
</style>
