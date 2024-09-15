<template>
    <!-- Loading Listener -->
</template>

<script>

export default {
    mounted() {
        emitter.on('loading-start', () => {

        });
        emitter.on('loading-end', () => {

        });
        emitter.on('loading-error', () => {

        });
    },
    components: {
    }
}
</script>