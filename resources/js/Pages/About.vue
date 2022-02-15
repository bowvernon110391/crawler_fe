<template>
    <div class="text-center">
        <Head title="About Crawler" />
        <h1>About</h1>
        <div>
            This is about page, let's go back

            <Link href="/">Home</Link>
        </div>
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
.text-center {
    text-align: center;
}
</style>
