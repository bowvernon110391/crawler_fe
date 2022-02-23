<template>
    <div>
        <n-h1>{{ title }}</n-h1>
        <n-p v-for="(c, id) in contents" :key="id">
            {{ c }}
        </n-p>
        <Link href="http://localhost:8000/about">About Page</Link>
    </div>
</template>

<script>
import AppLayout from "../Layouts/AppLayout.vue";
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        AppLayout,
        Link
    },

    layout: AppLayout,

    props: {
        title: String,
        contents: [Object, Array],
    },

    setup() {
    },
};
</script>