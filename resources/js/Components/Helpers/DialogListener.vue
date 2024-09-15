<template>
    <!-- Dialog Listener -->
</template>

<script>

export default {
    mounted() {
        const dialog = null;
        emitter.on('dialog', e => {
            if (typeof e.options === 'undefined') {
                return;
            }
            switch (e.type) {
                case "info":
                    dialog.info(e.options);
                    break;
                case "success":
                    dialog.success(e.options);
                    break;
                case "error":
                    dialog.error(e.options);
                    break;
                case "warning":
                    dialog.warning(e.options);
                    break;
            }
        });
    },
    components: {
    }
}
</script>