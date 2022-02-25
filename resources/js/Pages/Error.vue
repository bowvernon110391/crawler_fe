<script setup>
import { computed } from "@vue/runtime-core"

const { status, message } = defineProps({
    status: [Number, String],
    message: String
})

const error_messages = {
    503: 'Service Unavailable',
    500: 'Internal Server Error',
    404: 'Not found',
    403: 'Forbidden',
    400: 'Bad Request'
}

const messageText = computed(() => {
    // console.log(status, message

    return message.length ? message : error_messages[status]
})

const goBack = function() {
    window.history.back()
}

</script>

<script>
// make sure it doesn't use default layout
export default {
    layout: null
}
</script>

<template>
    <div style="text-align: center; margin: auto">
        <n-h1>Error {{ status }}</n-h1>
        <n-p>{{ messageText }}</n-p>
        <div style="margin: 0.5rem auto">
            <Link href="#" @click="goBack" >Go Back</Link>
            |
            <Link href="/" >Go Home</Link>
        </div>
    </div>
</template>