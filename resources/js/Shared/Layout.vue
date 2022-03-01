<template>
    <n-layout
        :has-sider="!isMobile"
        :class="['m-d', { 'mobile': isMobile }]"
    >
        <!-- menu goes here -->
        <Menu
            :menuCollapsed="menuCollapsed"
            :isMobile="isMobile"
            :menu="appMenu"
            :handleDrawerMenuClick="handleDrawerMenuClick"
            @menu-toggle="(e) => menuCollapsed = e"
            :activeItem="activeItem"
            :expandedKeys="expandedKeys"
        />

        <!-- content goes here -->
        <n-layout
            style="height: 100vh"
            class="appbg"
            scroll-region
        >

            <n-layout-header
                style="top: 0; position: sticky; z-index: 13;"
                bordered
                class="shadow-md"
            >
                <!-- navbar -->
                <NavBar
                    @menu-toggle="menuCollapsed = !menuCollapsed"
                    @login="gotoLoginPage"
                    :menu="userMenu"
                    :isMobile="isMobile"
                />

                <!-- page title + breadcrumbs -->
                <div
                    v-if="!isMobile"
                    style="padding: var(--default-margin); border-top: 1px solid var(--n-border-color);"
                    class="flexed"
                >
                    <template v-if="$page.props.title">
                        <div style="font-size: 1.2rem; font-weight: 500;">
                            {{ $page.props.title }}
                        </div>
                        <n-divider vertical />
                    </template>
                    <Breadcrumbs />
                </div>
            </n-layout-header>

            <n-layout-content :style="{
                    padding: isMobile ? 0 : 'var(--default-margin)',
                    background: 'inherit'
                }">
                <!-- if mobile, show header+breadcrumb here instead -->
                <!-- wrap contents in card -->
                <n-card
                    header-style="padding: var(--default-margin)"
                    :content-style="isMobile ? {
                        padding: 'var(--default-margin)',
                    } : {}"
                >
                    <template
                        #header
                        v-if="isMobile"
                    >
                        <div style="padding: 0;">
                            <div
                                style="font-size: 1.2rem; font-weight: 500;"
                                v-if="$page.props.title"
                            >
                                {{ $page.props.title }}
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
import { ref, toRef, toRefs, unref, watchEffect } from "vue";

import { useScreen } from "../Composables/screen";
import { useMenu } from "../Composables/menu";

import Breadcrumbs from "./Breadcrumbs.vue";
import Menu from "./Menu.vue";
import NavBar from "./NavBar.vue";

import { MenuSharp } from "@vicons/ionicons5";
import { useMessage } from 'naive-ui';

export default {
    props: {
        sso_login_url: {
            type: String,
            default: "",
        },
        user: {
            type: Object,
            default: null,
        },
        message: {
            type: String,
            default: "",
        },
        messageType: {
            type: String,
            default: null
        }
    },

    components: {
        Breadcrumbs,
        MenuSharp,
        Menu,
        NavBar,
    },
    setup(props) {
        const { isMobile } = useScreen();
        const menuCollapsed = ref(false);

        const { appMenu, userMenu, activeItem, expandedKeys } = useMenu();

        const handleDrawerMenuClick = () => {
            menuCollapsed.value = !menuCollapsed.value;
        };

        const { sso_login_url } = toRefs(props);

        const gotoLoginPage = () => {
            console.log(`login_url`, sso_login_url.value);
            if (sso_login_url.value) window.location.href = sso_login_url.value;
        };

        const message = useMessage()

        watchEffect(() => {
            console.log('flash-message: ', props.message)
            // flash it (if one exists)
            let type = props.messageType ?? 'info'
            if (props.message)
                message[type](props.message)
        })

        return {
            isMobile,
            menuCollapsed,
            appMenu,
            userMenu,
            activeItem,
            expandedKeys,

            handleDrawerMenuClick,
            gotoLoginPage,
        };
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

.n-layout-sider {
    /* --n-text-color: rgba(255, 255, 255, 0.82), */

    /* background-color: rgb(10, 10, 50); */
    /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#27272f+0,0a0a14+100 */
    background: rgb(39, 39, 47); /* Old browsers */
    background: -moz-linear-gradient(
        -45deg,
        rgba(39, 39, 47, 1) 0%,
        rgba(10, 10, 20, 1) 100%
    ); /* FF3.6-15 */
    background: -webkit-linear-gradient(
        -45deg,
        rgba(39, 39, 47, 1) 0%,
        rgba(10, 10, 20, 1) 100%
    ); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(
        135deg,
        rgba(39, 39, 47, 1) 0%,
        rgba(10, 10, 20, 1) 100%
    ); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#27272f', endColorstr='#0a0a14',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}
</style>
