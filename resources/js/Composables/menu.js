import { ref, h, watchEffect, toRef, computed, unref, isRef, isReactive, toRaw } from 'vue';
import { renderIcon } from '../naiveui'
import { Link } from '@inertiajs/inertia-vue3'
import { IdCard, Power } from '@vicons/ionicons5'
import { usePage } from '@inertiajs/inertia-vue3'

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

function processItem(json, fnCheck) {
    // check first, if we can't pass 
    // return null
    if (fnCheck && fnCheck(json) === false) {
        return null
    }

    // check type
    if (json.href) {
        // if it's a simple href
        return mi_Link(
            json.text, json.key, json.href, json.icon, json.props
        )
    } else if (json.url) {
        // it's a simple url
        return mi_Url(
            json.text, json.key, json.href, json.icon
        )
    } else if (json.children) {
        let children = generateMenu(json.children, fnCheck)

        return mi_Group(
            json.text, json.key, json.icon, children
        )
    }

    return null
}

/**
 * 
 * @param {Array} json 
 * @param {Function} fnCheck 
 * @returns 
 */
function generateMenu(json, fnCheck) {
    let items = []

    json.forEach(e => {
        let item = processItem(e, fnCheck)
        if (item) {
            items.push(
                item
            )
        }
    })

    return items
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

const traverse = (menu, fn) => {
    // root or group
    if (Array.isArray(menu)) {
        menu.forEach(e => traverse(e, fn))
        return
    }

    fn(menu)
    if (menu.children) {
        traverse(menu.children, fn)
    }
}

const userCheck = (item, user) => {
    // console.log(`checking item: `, item, `against user roles`, user)
    if (item && item.role && user) {
        let result = user.filter(e => item.role.includes(e)).length
        // console.log('intersection_test', item.role, user, 'result', result)
        
        // if resulting intersection contain something, mark as pass
        return result > 0
    }
    // by default, allow it
    return true
}

export const useMenu = () => {
    const { 
        url, 
        props
    } = usePage()
    // console.log(`Got User `, user, `is it a ref #${user.id}? `, isRef(user), 'roles? ', user.roles, 'isreadtive?', isReactive(user))
    // console.log(`username`, user.username, `1st roles? `, user.roles[0], 'roles? ', toRaw( user.roles) )

    let menuConfig = require('../Configs/menu').default
    // console.log(`menuConfig`, menuConfig)
    // const userRef = toRef(user)

    // const appMenu = computed(()_=> generateMenu( menuConfig, (item) => userCheck(item, userRef.value) ) )
    const appMenu = computed(() => {
        // console.log('User exist? ', props.value.user)
        return generateMenu(
            menuConfig, 
            item => userCheck(
                item, 
                toRaw(props.value.user.roles)
            )
        )
    })
    // console.log(appMenu.value) 
    

    const activeItem = ref(null)
    const expandedKeys = ref([])
    
    watchEffect(() => {
        // watch url change
        // console.log(`Page Url`, url.value)

        // reset data
        activeItem.value = null
        expandedKeys.value = []

        // ok, search for menu with correct spec
        traverse(menuConfig, (e) => {
            if (e.href && url.value.startsWith(e.href)) {
                activeItem.value = e.key
            }
        })

        // double traversal for now BAD!!!!
        traverse(menuConfig, (e) => {
            if (e.children) {
                // filter children?
                let filtered = e.children.filter(e => activeItem.value == e.key)
                // console.log('filtered: ', filtered)
                if (filtered.length > 0) {
                    expandedKeys.value.push(e.key)
                }
            }
        })

        // console.log('activeItem', activeItem.value)
        // console.log('expandedKeys', expandedKeys.value)
    })
    
    const userMenu = ref([
        mi_Url('Profile', 'profile', 'https://intra.siroleg.xyz', IdCard),
        mi_Divider('div-user'),
        mi_Link('Logout', 'logout', '/logout', Power, { as: 'div', method: 'post' })
    ])

    return {
        appMenu,
        userMenu,
        activeItem,
        expandedKeys
    }
}