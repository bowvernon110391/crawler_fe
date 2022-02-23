<template>
    <n-layout
        :has-sider="!isMobile"
        :class="['m-d', { 'mobile': isMobile }]"
    >
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
                @collapse="menuCollapsed = true"
                @expand="menuCollapsed = false"
            >
                <div v-if="!menuCollapsed">
                    <!-- app badge here -->
                    <AppBadge/>
                </div>
                <n-menu
                    :collapsed-width="64"
                    :collapsed-icon-size="22"
                    :options="appMenu"
                    :collapsed="menuCollapsed"
                    accordion
                />
            </n-layout-sider>

            <!-- otherwise? use drawer :) -->
            <n-drawer
                v-if="isMobile"
                v-model:show="menuCollapsed"
                :width="240"
                placement="left"
            >
                <n-drawer-content body-content-style="padding:0;">
                    <!-- Put badge too? -->
                    <div>
                        <AppBadge/>
                    </div>
                    <!-- the menu on drawer. close drawer on select -->
                    <n-menu
                        :options="appMenu"
                        @update:value="handleDrawerMenuClick"
                        accordion
                    />
                </n-drawer-content>
            </n-drawer>
        </n-config-provider>

        <!-- content goes here -->
        <n-layout style="height: 100vh">

            <n-layout-header
                style="top: 0; position: sticky; z-index: 1;"
                bordered
            >
                <div style="display: flex; flex-direction: row; flex-wrap: nowrap; align-items: center;">
                    <!-- hamburger menu -->
                    <n-button
                        v-if="isMobile"
                        @click="menuCollapsed = !menuCollapsed"
                        tertiary
                        style="margin: var(--default-margin)"
                    >
                        <Icon>
                            <MenuSharp />
                        </Icon>
                    </n-button>
                    <div style="flex-grow: 1; text-align: right;">
                        <n-popover
                            trigger="click"
                            placement="bottom-end"
                            style="padding: 0; margin-right: var(--default-margin, 0.5rem);"
                        >
                            <!-- the trigger -->
                            <template #trigger>
                                <div style="padding: 1rem 1rem; display: inline-flex; justify-content: flex-end; align-items: center; cursor: pointer;">
                                    <div style="font-weight: 400; margin-right: var(--default-margin);">
                                        Bow Vernon
                                        <Icon>
                                            <ChevronDown />
                                        </Icon>
                                    </div>
                                    <n-avatar
                                        src="https://i.pravatar.cc/48"
                                        :size="32"
                                        round
                                    />
                                </div>
                            </template>
                            <!-- the content -->
                            <n-menu
                                :options="userMenu"
                                :root-indent="12"
                                style="min-width: 160px;"
                            />
                        </n-popover>
                    </div>
                </div>
                <div
                    v-if="!isMobile"
                    style="padding: var(--default-margin); border-top: 1px solid var(--n-border-color);"
                    class="flexed"
                >
                    <div style="font-size: 1.2rem; font-weight: 500;">
                        Home Page
                    </div>
                    <n-divider vertical />
                    <Breadcrumbs />
                </div>
            </n-layout-header>

            <n-layout-content
                :style="{
                    padding: isMobile ? 0 : 'var(--default-margin)'
                }"
                class="appbg"
            >
                <!-- if mobile, show header+breadcrumb here instead -->
                <!-- wrap contents in card -->
                <n-card
                    header-style="padding: var(--default-margin)"
                    :content-style="isMobile ? {
                        padding: 'var(--default-margin)'
                    } : {}"
                >
                    <template
                        #header
                        v-if="isMobile"
                    >
                        <div style="padding: 0;">
                            <div style="font-size: 1.2rem; font-weight: 500;">
                                Home Page
                            </div>
                            <Breadcrumbs />
                        </div>
                    </template>

                    <!-- default goes here -->
                    <slot></slot>

                </n-card>
            </n-layout-content>
        </n-layout>
    </n-layout>
</template>

<script>
import { ref } from 'vue'
import { darkTheme } from "naive-ui"

import { useScreen } from '../Composables/screen'
import { useMenu } from '../Composables/menu'

import Breadcrumbs from '../Components/Breadcrumbs.vue'
import AppBadge from '../Components/AppBadge.vue'

import {
    MenuSharp
} from '@vicons/ionicons5'

export default {
    components: {
        Breadcrumbs,
        MenuSharp,
        AppBadge
    },
    setup() {

        const { isMobile } = useScreen()
        const menuCollapsed = ref(false)

        const { appMenu, userMenu } = useMenu()

        const theme = ref(darkTheme)

        const handleDrawerMenuClick = () => {
            menuCollapsed.value = !menuCollapsed.value
        }

        // console.log('image', app_icon)

        return {
            isMobile,
            menuCollapsed,
            appMenu, 
            userMenu,
            theme,
            handleDrawerMenuClick,
        }
    },
};
</script>

<style scoped>
.m-d {
    --default-margin: 1rem;
}

.mobile {
    --default-margin: 0.5rem;
}
.appbg {
    /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#eeeeee+0,cccccc+100;Gren+3D */
    background: rgb(238, 238, 238); /* Old browsers */
    background: -moz-linear-gradient(
        -45deg,
        rgba(238, 238, 238, 1) 0%,
        rgba(204, 204, 204, 1) 100%
    ); /* FF3.6-15 */
    background: -webkit-linear-gradient(
        -45deg,
        rgba(238, 238, 238, 1) 0%,
        rgba(204, 204, 204, 1) 100%
    ); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(
        135deg,
        rgba(238, 238, 238, 1) 0%,
        rgba(204, 204, 204, 1) 100%
    ); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#cccccc',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}
.flexed {
    display: flex;
    align-items: center;
}
</style>

<style scoped>
.n-layout-sider {
    /* --n-text-color: rgba(255, 255, 255, 0.82), */

    /* background-color: rgb(10, 10, 50); */
    /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#27272f+0,0a0a14+100 */
    background: rgb(39,39,47); /* Old browsers */
    background: -moz-linear-gradient(-45deg,  rgba(39,39,47,1) 0%, rgba(10,10,20,1) 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(-45deg,  rgba(39,39,47,1) 0%,rgba(10,10,20,1) 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(135deg,  rgba(39,39,47,1) 0%,rgba(10,10,20,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#27272f', endColorstr='#0a0a14',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}
</style>