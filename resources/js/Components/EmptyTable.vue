<template>
    <td colspan="100">
        <n-alert
            title="Empty Result"
            type="warning"
            class="w-96 mx-auto"
        >
            <template #icon>
                <n-icon :component="Search" />
            </template>
            The query doesn't produce any results
        </n-alert>
    </td>
</template>

<script>
import { Search } from '@vicons/ionicons5'
export default {
    setup() {
        return {
            Search
        }
    },
}
</script>