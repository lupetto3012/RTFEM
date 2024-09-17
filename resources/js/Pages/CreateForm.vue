<template>
    <Layout>
        <div class="row flex-center child-borders child-shadows">
            <div :class="'col-6 col border-dashed ' + dropClass" @drop="ocr" @dragover="handleFileDragOver"
                @dragleave="handleFileDragLeave">
                <div class="form-group">
                    <label>Error message</label>
                    <textarea ref="log" class="input-block no-resize p-5" v-model="form.log" rows="15"
                        @select="selectHighlight()"></textarea>
                </div>
                <div class="progress" v-if="uploading">
                    <div :class="'bar striped w-' + uploadProgress + ''" role="progressbar">{{ uploadProgress }}%
                    </div>
                </div>
                <div v-if="uploading">OCR processing...</div>
            </div>
            <div class="col-2 col border-dashed ml-2">
                <div class="form-group h-100">
                    <label for="paperInputs1">Highlights</label>
                    <input v-for="highlight in form.highlights" class="input-block" :value="highlight" type="text" />
                </div>
                <button v-if="form.highlights.length > 0" class="btn-block btn-small btn-danger-outline"
                    @click="clearHighlights()">Clear
                    highlights</button>
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
            showModal: false,
            uploading: false,
            uploadProgress: 0,
            isDragging: false
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
        clearHighlights() {
            window.getSelection().removeAllRanges();
            this.form.highlights = [];
        },
        reset() {
            this.form.reset();
        },
        ocr(e) {
            e.preventDefault();
            this.isDragging = false;
            this.uploading = true;
            let formData = new FormData();
            for (const file of e.dataTransfer.files) {
                formData.append(file.name, file);
            }
            axios.post('/ocr',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: e => {
                        this.uploadProgress = Math.ceil((e.loaded / e.total * 100) / 5) * 5;
                    }
                })
                .then(response => {
                    this.form.log = response.data.text;
                })
                .catch(error => {
                    alert("Error during OCR processing...");
                })
                .finally(response => {
                    this.uploading = false;
                });
        },
        handleFileDragOver(e) {
            e.preventDefault();
            this.isDragging = true;
        },
        handleFileDragLeave(e) {
            e.preventDefault();
            this.isDragging = false;
        },
    },
    computed: {
        viewUrl() {
            return window.location + this.random;
        },
        dropClass() {
            if (this.isDragging) {
                return 'border-success';
            }
            return '';
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