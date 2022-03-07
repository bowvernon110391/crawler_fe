<template>
    <Form :data="data" :can="can" />
</template>

<script>

import Form from '../../Components/CrawlingJobs/Form.vue'

export default {
    components: {
        Form
    },
    props: {
        data: Object,
        can: Object
    },
    setup() {
        
    },
}
</script>