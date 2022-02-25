<template>
    <!-- menu goes here -->
    <n-config-provider :theme="theme">
        <n-layout-sider
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
                />
            </n-drawer-content>
        </n-drawer>
    </n-config-provider>
</template>

<script setup>
import { darkTheme } from "naive-ui"
import { ref, watchEffect } from "vue"
import AppBadge from './AppBadge.vue'

const props = defineProps({
    handleDrawerMenuClick: Function,
    isMobile: Boolean,
    menuCollapsed: Boolean,
    menu: Array,
})

// theme
const theme = ref(darkTheme)

</script>