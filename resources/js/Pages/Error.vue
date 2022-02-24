<script setup>
import { computed } from "@vue/runtime-core"
import { Link } from '@inertiajs/inertia-vue3'


const { status, message } = defineProps({
    status: [Number, String],
    message: String
})

const error_messages = {
    503: 'Service Unavailable',
    500: 'Internal Server Error',
    404: 'Not found',
    403: 'Forbidden'
}

const messageText = computed(() => {
    // console.log(status, message

    return message.length ? message : error_messages[status]
})

const goBack = function() {
    window.history.back()
}

</script>

<template>
    <div style="text-align: center; margin: auto">
        <h1>Error {{ status }}</h1>
        <div>{{ messageText }}</div>
        <div style="margin: 0.5rem auto">
            <Link href="#" @click="goBack" >Go Back</Link>
            |
            <Link href="/" >Go Home</Link>
        </div>
    </div>
</template>