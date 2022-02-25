<template>
    <n-breadcrumb>
        <n-breadcrumb-item>
            <Link href="/mail/2">
                <NIcon><MailOpen/></NIcon> Identity
            </Link>
        </n-breadcrumb-item>
        <n-breadcrumb-item>
            <Link href="/about">
                <NIcon><Archive/></NIcon> About
            </Link>
        </n-breadcrumb-item>
        <n-breadcrumb-item>
            <Link href="#">
                <NIcon><Pencil/></NIcon> Boost
            </Link>
        </n-breadcrumb-item>
    </n-breadcrumb>
</template>

<script>
import { defineComponent } from 'vue'
import {
    MailOpen, Archive, Pencil
} from '@vicons/ionicons5'

export default defineComponent({
    components: {
        MailOpen, Archive, Pencil
    },
    setup() {
        
    },
})
</script>


