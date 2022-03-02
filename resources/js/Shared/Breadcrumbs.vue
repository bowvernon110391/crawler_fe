<template>
    <n-breadcrumb>
        <n-breadcrumb-item v-for="(l, id) in links" :key="id">
            <Link :href="l.url">
                <NIcon v-if="l.component" :component="l.component" />
                {{ l.title }}
            </Link>
        </n-breadcrumb-item>
        <!-- <n-breadcrumb-item>
            <Link href="/mail/2">
                <NIcon>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M22 11h-4.17l3.24-3.24l-1.41-1.42L15 11h-2V9l4.66-4.66l-1.42-1.41L13 6.17V2h-2v4.17L7.76 2.93L6.34 4.34L11 9v2H9L4.34 6.34L2.93 7.76L6.17 11H2v2h4.17l-3.24 3.24l1.41 1.42L9 13h2v2l-4.66 4.66l1.42 1.41L11 17.83V22h2v-4.17l3.24 3.24l1.42-1.41L13 15v-2h2l4.66 4.66l1.41-1.42L17.83 13H22z" fill="currentColor"></path></svg>
                </NIcon> Identity
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
        </n-breadcrumb-item> -->
    </n-breadcrumb>
</template>

<script>
import { computed, defineComponent } from 'vue'
import {
    MailOpen, Archive, Pencil, Home, Search
} from '@vicons/ionicons5'

export default defineComponent({
    components: {
        MailOpen, Archive, Pencil
    },
    props: {
        data: Array
    },
    setup(props) {
        const iconMap = {
            'home' : Home,
            'pencil' : Pencil,
            'browse' : Search
        }

        const links = computed(() => {
            console.log(`breadcrumbs change`, props.data)
            // generate new data from data
            return props.data.map(e => ({ 
                ...e, 
                component: iconMap[e.icon]
            }))
        })

        return {
            links
        }
    },
})
</script>


