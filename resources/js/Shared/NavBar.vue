<template>
    <!-- this is the nav header -->
    <div style="display: flex; flex-direction: row; flex-wrap: nowrap; align-items: center;">
        <!-- hamburger menu -->
        <n-button
            v-if="isMobile"
            @click="$emit('menu-toggle')"
            tertiary
            style="margin: var(--default-margin)"
        >
            <template #icon>
                <NIcon>
                    <MenuSharp />
                </NIcon>
            </template>
        </n-button>
        <div style="flex-grow: 1; text-align: right;">

            <!-- Popover for user menu (only if logged in) -->
            <n-popover
                v-if="$page.props.user"
                trigger="click"
                placement="bottom-end"
                style="padding: 0; margin-right: var(--default-margin, 0.5rem);"
            >
                <!-- the trigger -->
                <template #trigger>
                    <div style="padding: 1rem 1rem; display: inline-flex; justify-content: flex-end; align-items: center; cursor: pointer;">
                        <div style="font-weight: 400; margin-right: var(--default-margin);">
                            {{ $page.props.user.nama }}
                            <NIcon>
                                <ChevronDown />
                            </NIcon>
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
                    :options="menu"
                    :root-indent="12"
                    style="min-width: 160px;"
                />
            </n-popover>

            <!-- Login button otherwise -->
            <div
                v-else
                style="margin: var(--default-margin, 0.5rem);"
            >
                <n-button
                    type="info"
                    tertiary
                    @click="$emit('login')"
                >Login</n-button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { MenuSharp, ChevronDown } from '@vicons/ionicons5'

defineProps({
    menu: Array,
    isMobile: Boolean,

})
</script>