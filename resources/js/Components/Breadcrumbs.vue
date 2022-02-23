<template>
    <n-breadcrumb>
        <n-breadcrumb-item>
            <Link href="/mail/2">
                <Icon><MailOpen/></Icon> Identity
            </Link>
        </n-breadcrumb-item>
        <n-breadcrumb-item>
            <Link href="/mail/2/boost">
                <Icon><Archive/></Icon> Boost
            </Link>
        </n-breadcrumb-item>
        <n-breadcrumb-item>
            <Link href="#">
                <Icon><Pencil/></Icon> Boost
            </Link>
        </n-breadcrumb-item>
    </n-breadcrumb>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'

export default defineComponent({
    components: {
        Link
    },
    setup() {
        
    },
})
</script>


