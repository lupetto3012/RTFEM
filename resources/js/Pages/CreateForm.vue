<template>
    <Layout>
        <div class="row flex-center">
            <div class="col-6 col">
                <div class="form-group">
                    <label>Create new entry</label>
                    <textarea ref="log" class="input-block no-resize" v-model="form.log" rows="15"
                        placeholder="Error message..." @select="selectHighlight()" />
                </div>
            </div>
            <div class="col-2 col">
                <div class="form-group">
                    <label for="paperInputs1">Highlights</label>
                    <input v-for="highlight in form.highlights" class="input-block" :value="highlight" type="text" />
                </div>
            </div>
        </div>
        <div class="row flex-center">
            <div class="col-8 col">
                <button class="btn-block btn-secondary" @click=submit()>Create</button>
            </div>
        </div>
        <input class="modal-state" id="modal-1" v-model="showModal" type="checkbox">
        <div class="modal">
            <label class="modal-bg" for="modal-1"></label>
            <div class="modal-body">
                <label class="btn-close" for="modal-1">X</label>
                <h4 class="modal-title">Here's your link...</h4>
                <input class="input-block" :value="viewUrl" disabled type="text" size="50" />
                <button class="btn-block btn-primary mt-2" @click="copyToClipboard()">Copy to clipboard</button>
            </div>
        </div>
    </Layout>
</template>

<script>

import { useForm } from '@inertiajs/vue3'
import Layout from '@/Layouts/Layout.vue';

export default {
    components: {
        Layout
    },
    data() {
        return {
            form: useForm({
                log: null,
                highlights: []
            }),
            random: null,
            showModal: false
        }
    },
    methods: {
        init() {

        },
        submit() {
            this.form.put("/", {
                onSuccess: (response) => {
                    this.random = response.props.random;
                    this.showModal = true;
                    this.reset();
                },
                onError: () => {
                    alert("Error...");
                }
            });
        },
        selectHighlight() {
            const textarea = this.$refs.log;
            const highlight = this.form.log.slice(textarea.selectionStart, textarea.selectionEnd);
            if (!this.form.highlights.includes(highlight)) {
                this.form.highlights.push(highlight);
            }
        },
        copyToClipboard() {
            copyToClipboard(this.viewUrl);
        },
        reset() {
            this.form.reset();
        }
    },
    computed: {
        viewUrl() {
            return window.location + this.random;
        }
    },
    mounted() {
        this.init();
        emitter.on('keypress-ctrl-s', e => {
            e.preventDefault();
            this.submit();
        });
    },
    watch: {

    }
}
</script>