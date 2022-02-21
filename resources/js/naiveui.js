
// import css?
import 'vfonts/FiraCode.css'

// vue helper
import { h, resolveComponent } from 'vue'

// initialize naive ui shit?
import {
    create,
    // components
    NButton, NSpace, NDivider, NLayout, NLayoutSider, NLayoutHeader, NLayoutContent,
    NLayoutFooter, NMenu, NH1, NH2, NH3, NH4, NH5, NH6, NP, NBlockquote, NInput, NInputGroupLabel,
    NDrawer, NDrawerContent, NAvatar
} from 'naive-ui'

const components = [
    NButton, NSpace, NDivider, NLayout, NLayoutSider, NLayoutHeader, NLayoutContent,
    NLayoutFooter, NMenu, NH1, NH2, NH3, NH4, NH5, NH6, NP, NBlockquote, NInput, NInputGroupLabel,
    NDrawer, NDrawerContent, NAvatar
]

// Icon utils?
import {
    Icon
} from '@vicons/utils'

// icons 
import {
    MailOpen, Archive, TrashOutline, Trash, Pencil, Rocket
} from '@vicons/ionicons5'

const icons = [
    MailOpen, Archive, TrashOutline, Trash, Pencil, Rocket
]

//========================EXPORTS=====================================================

// naiveUiSetup plugin
export const naiveUiSetup = create({
    components: components
})

// register icon component
export const iconPlugin = {
    install: (app, options) => {
        app.component('Icon', Icon),

        // the icons
        icons.forEach(e => {
            // console.log(e.name, e)
            app.component(e.name, e)
        })
    }
}

export const renderIcon = (icon) => {
    return () => h(
        /* resolveComponent(icon) */
        icon
    )
}