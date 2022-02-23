import { ref, h } from 'vue';
import { renderIcon } from '../naiveui'
import { Link } from '@inertiajs/inertia-vue3'
import {
    IdCard,
    Power
} from '@vicons/ionicons5'

function menuItem(href, icon, text, key, internal) {
    internal = internal || false

    return {
        label: () => h( internal ? Link : 'a', { href: href }, { default: () => text }),
        key: key,
        icon: renderIcon(icon)
    }
}

export const useMenu = (user) => {
    let appMenu = ref([
        menuItem('/ids', IdCard, 'Identitas', 'identity', true),
        menuItem('/shutdown', Power, 'Matikan Service', 'service-down', true),
        // menuItem('https://app.siroleg.xyz', IdCard, 'User Manajemen', 'user-mgmt', false),
    ]);

    let userMenu = ref([
        {
            label: () => 
                h(
                    'a',
                    {
                        href: 'https://intra.siroleg.xyz/'
                    },
                    { default: () => `Profile` }
                )
            ,
            key: 'user-profile',
            icon: renderIcon(IdCard)
        },
        {
            key: 'divider-1',
            type: 'divider'
        },
        {
            label: () => 
                h(
                    Link,
                    {
                        href: `/logout`,
                        method: 'post',
                        as: 'div'
                    },
                    { default: () => `Logout` }
                )
            ,
            key: 'user-logout',
            icon: renderIcon(Power)
        }
        
    ])

    return {
        appMenu,
        userMenu
    }
}