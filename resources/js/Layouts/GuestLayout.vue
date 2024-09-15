<template>
    <n-config-provider :theme="theme" :theme-overrides="themeOverrides">
        <n-layout position="absolute">
            <n-space justify="center">
                <n-space vertical>
                    <ApplicationLogo :size="300" class="mb-5" />
                    <slot />
                </n-space>
            </n-space>
        </n-layout>
    </n-config-provider>
</template>

<script>
import { darkTheme } from 'naive-ui';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { themeSettings } from '@/Layouts/ThemeSettings.js';

export default {
    data() {
        return {
            theme: darkTheme,
            themeOverrides: themeSettings
        }
    },
    components: {
        darkTheme,
        ApplicationLogo
    }
}
</script>