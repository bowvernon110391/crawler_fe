<template>
    <Form :createMode="true" />
</template>

<script>

import Form from '../../Components/CrawlingJobs/Form.vue'

export default {
    components: {
        Form
    },
    props: {
        data: Object
    },
    setup() {
        
    },
}
</script>