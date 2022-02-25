
// import css?
import 'vfonts/FiraCode.css'

// vue helper
import { h } from 'vue'

// initialize naive ui shit?
import {
    create,
    // components
    NButton, NSpace, NDivider, NLayout, NLayoutSider, NLayoutHeader, NLayoutContent,
    NLayoutFooter, NMenu, NH1, NH2, NH3, NH4, NH5, NH6, NP, NBlockquote, NInput, NInputGroupLabel,
    NDrawer, NDrawerContent, NAvatar, NConfigProvider, NText, NPopover, NCard,
    NBreadcrumb, NBreadcrumbItem, NIcon
} from 'naive-ui'

const components = [
    NButton, NSpace, NDivider, NLayout, NLayoutSider, NLayoutHeader, NLayoutContent,
    NLayoutFooter, NMenu, NH1, NH2, NH3, NH4, NH5, NH6, NP, NBlockquote, NInput, NInputGroupLabel,
    NDrawer, NDrawerContent, NAvatar, NConfigProvider, NText, NPopover, NCard,
    NBreadcrumb, NBreadcrumbItem, NIcon
]

//========================EXPORTS=====================================================

// naiveUiSetup plugin
export const naiveUiSetup = create({
    components: components
})

export const renderIcon = (icon) => {
    return () => h(
        /* resolveComponent(icon) */
        icon
    )
}