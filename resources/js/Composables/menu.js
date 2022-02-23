import { ref, h } from 'vue';
import { renderIcon } from '../naiveui'
import { Link } from '@inertiajs/inertia-vue3'
import {
    IdCard,
    Power
} from '@vicons/ionicons5'

/**
 * 
 * @param {String} text teks menu
 * @param {String} key key of menu
 * @param {String} href link to go to
 * @param {Component|any} icon icon
 * @param {object|null} props any additional props (optional)
 * @returns an object representing a Link menu item
 */
function mi_Link(text, key, href, icon, props) {
    props = props || {}

    return {
        label: () => h(Link, { href: href, ...props }, { default: () => text }),
        key: key,
        icon: renderIcon(icon)
    }
}

/**
 * 
 * @param {*} text 
 * @param {*} key 
 * @param {*} href 
 * @param {*} icon 
 * @returns 
 */
function mi_Url(text, key, href, icon) {
    return {
        label: () => h('a', { href: href }, { default: () => text }),
        key: key,
        icon: renderIcon(icon)
    }
}

/**
 * 
 * @param {*} key 
 * @param {*} props 
 * @returns 
 */
function mi_Divider(key, props) {
    return {
        key: key,
        type: 'divider',
        props: props
    }
}

/**
 * 
 * @param {String} text 
 * @param {String} key 
 * @param {Component} icon 
 * @param {Array} children 
 * @returns
 */
function mi_Group(text, key, icon, children) {
    children = children || []

    return {
        label: text,
        key: key,
        icon: renderIcon(icon),
        children: children
    }
}

function mi_Container(text, key, icon, children) {
    return {
        label: text,
        key: key,
        type: 'group',
        icon: icon ? renderIcon(icon) : icon,
        children: children || []
    }
}

export const useMenu = (user) => {
    let menuItems = [
        mi_Link('Edit Profile', 'edit-profile', '/user/2/edit', IdCard),
        mi_Link('Matikan Service', 'shutdown', '/shutdown', Power)
    ]

    let tmpItems = []
    for (var i=0; i<20; i++) {
        
        tmpItems.push(
            mi_Link(`Artikel #${i}`, `article-${i}`, `/article/${i}`, IdCard)
        )

        if (i % 5 == 4) {
            menuItems.push(
                mi_Group(`Batch Items`, `batch-${i}`, Power, tmpItems)
            )
            tmpItems = []
        }
    }

    const appMenu = ref(menuItems);

    const userMenu = ref([
        mi_Container('User Management', 'u-1', null, [
            mi_Url('Profile', 'profile', 'https://intra.siroleg.xyz', IdCard),
            mi_Divider('div-user'),
            mi_Link('Logout', 'logout', '/logout', Power, { as: 'div', method: 'post' })        
        ])
    ])

    return {
        appMenu,
        userMenu
    }
}