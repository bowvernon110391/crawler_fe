<template>
    <template v-if="!isProgress">
        <n-text :type="statusText == 'CANCELLED' ? 'warning' : 'default'">
            {{ statusText }}
        </n-text>
    </template>
    <template v-else>
        Oh shit, spawn progress bar here please
    </template>
</template>

<script>
import { onMounted, onUnmounted, computed, ref } from 'vue'

const axios = require('axios').default

export default {
    props: {
        status: [String],
        id: [Number,String]
    },
    setup(props) {
        // when status is in the format of PROCESSING :percentage, do something
        const isProgress = ref(false)
        const progress = ref(0.0)
        const currentStatus = ref(props.status)

        const statusText = computed(() => {
            let matches = currentStatus.value.match(/processing\s(.+)/i)
            if (matches) {
                progress.value = Number(matches[1])
                isProgress.value = progress.value < 100
                return "PROCESSING"
            } else {
                isProgress.value = false
                return currentStatus.value
            }
        })

        // our poll timer
        let timerId = null
        const refresh = () => {
            timerId = setTimeout(async () => {
                // do something here?
                if (statusText.value == 'PROCESSING' || statusText.value == 'CREATED') {
                    // call api here
                    console.log(`Time to poll job #${props.id}`, timerId)

                    try {
                        let result = await axios.get(route('jobs.status', props.id))
                        console.log('result', result)
                        // set current status
                        currentStatus.value = result.data
                    } catch (error) {
                        console.log('Error polling status: ', error)
                    }
                } else {
                    clearTimeout(timerId)
                    return
                }

                refresh()
            }, 3000)
        }

        // poll when status is not [DONE,CANCELLED]
        onMounted(() => {
            refresh()
        })

        onUnmounted(() => {
            // statusText.value = 'UNMOUNTING'
            console.log('Unmounting Status', timerId)
            if (timerId) {
                clearTimeout(timerId)
            }
        })

        return { statusText, isProgress, progress }
    },
}
</script>