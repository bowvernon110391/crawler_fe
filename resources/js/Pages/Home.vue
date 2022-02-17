<template>
    <div class="margin-auto">
        <Head title="Crawler Home"/>
        <h1>{{ title }}</h1>
        <p v-for="(p, id) in contents" :key="id">{{ p }}</p>

        <div>
            <div v-if="busy">
                getting api version...
            </div>
            <div v-else>
                <pre>{{ JSON.stringify(data, null, 2) }}</pre>
            </div>
        </div>

        <Link href="/abuud">About Page (shouldn't reload)</Link>
    </div>
</template>

<script>
import { Link, Head } from '@inertiajs/inertia-vue3'
import { getApiVersion } from '../Composables/api'

export default {
    components: {
        Link,
        Head
    },

    props: {
        title: String,
        contents: [Object, Array]
    },

    setup() {
        const { data, busy } = getApiVersion()

        return {
            data, busy
        }
    }
};
</script>

<style scoped>
.text-center {
    text-align: center;
}
.margin-auto {
    margin: 0 1.2rem;
}
</style>
