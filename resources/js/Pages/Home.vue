<template>
    <div class="margin-auto">
        <Head title="Crawler Home"/>
        <h1>{{ title }} => {{ $page.props.token }}</h1>
        <p v-for="(p, id) in contents" :key="id">{{ p }}</p>

        <div v-if="$page.props.token">
            <div v-if="busy">
                getting api version...
            </div>
            <div v-else>
                <pre>{{ JSON.stringify(data, null, 2) }}</pre>
            </div>
        </div>

        <div style="text-align: center">
            <Link href="/abuud">About Page (shouldn't reload)</Link>
            |
            <Link href="/test">Test Error</Link>
            |
            <Link href="/logout" method="post" as="button">Log Out</Link>
        </div>
    </div>
</template>

<script>
import { Link, Head } from '@inertiajs/inertia-vue3'
import { getUser } from '../Composables/api'

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
        const { data, busy } = getUser()

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
