<template>
    <!-- menu goes here -->
    <n-config-provider :theme="theme" :theme-overrides="themeOverrides">
        <n-layout-sider
            class="slider"

            v-if="!isMobile"
            bordered
            collapse-mode="width"
            :collapsed-width="64"
            :width="240"
            :native-scrollbar="false"
            style="height: 100vh"
            :show-trigger="!isMobile"
            :collapsed="menuCollapsed"
            @collapse="$emit('menu-toggle', true)"
            @expand="$emit('menu-toggle', false)"
        >
            <div v-if="!menuCollapsed">
                <!-- app badge here -->
                <AppBadge />
            </div>
            <n-menu
                :collapsed-width="64"
                :collapsed-icon-size="22"
                :options="menu"
                :collapsed="menuCollapsed"
                accordion
                :value="activeItem"
                v-model:expanded-keys="localKeys"
            />
        </n-layout-sider>

        <!-- otherwise? use drawer :) -->
        <n-drawer
            v-if="isMobile"
            :show="menuCollapsed"
            @update:show="e => handleDrawerMenuClick(e)"
            :width="240"
            placement="left"
        >
            <n-drawer-content body-content-style="padding:0;">
                <!-- Put badge too? -->
                <div>
                    <AppBadge />
                </div>
                <!-- the menu on drawer. close drawer on select -->
                <n-menu
                    :options="menu"
                    @update:value="handleDrawerMenuClick"
                    accordion
                    :value="activeItem"
                    v-model:expanded-keys="localKeys"
                />
            </n-drawer-content>
        </n-drawer>
    </n-config-provider>
</template>

<style lang="postcss" scoped>
/* .slider {
    @apply bg-gray-900 !important;
} */
.n-menu-item-content {
    @apply bg-slate-100 hover:bg-gray-100 !important; 
}
</style>

<script>
import { darkTheme } from "naive-ui"
import { defineComponent, ref, watchEffect } from "vue"
import AppBadge from "./AppBadge.vue"

export default defineComponent({
    components: {
        AppBadge
    },

    props: {
        handleDrawerMenuClick: Function,
        isMobile: Boolean,
        menuCollapsed: Boolean,
        menu: Array,
        activeItem: String,
        expandedKeys: Array
    },

    setup(props) {
        // theme
        const theme = ref(darkTheme)

        console.log('theme', darkTheme)

        // const appTheme = useThemeVars()

        // for the expanded keys, just copy and manage it ourselves
        const localKeys = ref(props.expandedKeys)

        // overrides
        const themeOverrides = require('@/themes/sidenav.json')

        // gotta watch props then
        watchEffect(() => {
            localKeys.value = props.expandedKeys
        })

        return {
            theme, localKeys, themeOverrides
        }
    }
})

</script>