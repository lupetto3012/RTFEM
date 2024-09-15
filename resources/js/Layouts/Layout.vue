<template>
    <LoadingListener />
    <MessageListener />
    <DialogListener />
    <Header></Header>
    <slot></slot>
    <Footer></Footer>
</template>

<script>
import Header from '@/Layouts/Header.vue';
import Footer from '@/Layouts/Footer.vue';
import LoadingListener from '@/Components/Helpers/LoadingListener.vue';
import MessageListener from '@/Components/Helpers/MessageListener.vue';
import DialogListener from '@/Components/Helpers/DialogListener.vue';

export default {
    components: {
        Header,
        Footer,
        LoadingListener,
        MessageListener,
        DialogListener
    },
    data() {
        return {

        }
    },
    methods: {

    },
    mounted() {
        
    }
}

</script>
