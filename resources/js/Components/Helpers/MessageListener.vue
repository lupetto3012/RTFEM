<template>
    <!-- Message Listener -->
</template>

<script>

export default {
    mounted() {
        var message;
        emitter.on('message', e => {
            if (typeof e.options === 'undefined') {
                e.options = {};
            }
            switch (e.type) {
                case "info":
                    message.info(e.msg, e.options);
                    break;
                case "success":
                    message.success(e.msg, e.options);
                    break;
                case "error":
                    message.error(e.msg, e.options);
                    break;
                case "warning":
                    message.warning(e.msg, e.options);
                    break;
                case "loading":
                    message.loading(e.msg, e.options);
                    break;
            }
        });
    },
    components: {
    }
}
</script>