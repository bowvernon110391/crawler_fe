import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'

const axios = require('axios')
const token = computed(() => usePage().props.value.token)
const client = computed(() => axios.create({
    headers: {
        Authorization: `Bearer ${token.value}`
    }
}))

export function getApiVersion() {
    const data = ref({})
    const busy = ref(true)

    // request directly
    client.value.get('/api/version')
        .then((res) => {
            busy.value = false
            data.value = res.data
        })
        .catch(e => {
            busy.value = false
        })

    return { data, busy }
}

export function getUser() {
    const data = ref({})
    const busy = ref(true)

    client.value.get('/api/check-token')
        .then((res) => {
            busy.value = false
            data.value = res.data
        })
        .catch(e => {
            busy.value = false
        })

    return { data, busy }
}