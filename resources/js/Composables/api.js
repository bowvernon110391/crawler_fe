import { ref } from 'vue'

const axios = require('axios')

export function getApiVersion() {
    const data = ref({})
    const busy = ref(true)

    // request directly
    axios.get('/api/version')
        .then((res) => {
            busy.value = false
            data.value = res.data
        })
        .catch(e => {
            busy.value = false
        })

    return { data, busy }
}