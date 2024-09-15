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
            })
        }
    },
    methods: {
        init() {

        },
        submit() {
            this.form.put("/create", {
                onSuccess: () => {
                    emitter.emit("message", { type: "success", msg: "Successfully created " + this.form.name });
                    this.$emit("done", "success");
                },
                onError: () => {

                }
            });
        },
        selectHighlight() {
            const textarea = this.$refs.log;
            this.form.highlights.push(this.form.log.slice(textarea.selectionStart, textarea.selectionEnd));
        },
        reset() {
            this.form.reset();
        }
    },
    computed: {

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