<template>
    <Layout>
        <div class="row flex-center">
            <div class="col-8 col">
                <pre class="border"
                    style="word-wrap: break-word; white-space: pre-wrap; overflow-wrap: break-word; line-height: 2"><component v-for="(part, index) in textParts" :key="index" :is="part.component" v-html="part.content"></component></pre>
            </div>
        </div>
    </Layout>
</template>

<script>

import { h } from 'vue'
import Layout from '@/Layouts/Layout.vue'
import Highlight from '../Components/Highlight.vue'
import Text from '../Components/Text.vue'
import Linebreak from '../Components/Linebreak.vue'

export default {
    components: {
        Layout,
        Text,
        Highlight,
        Linebreak
    },
    data() {
        return {
            textParts: [],
            text: null
        }
    },
    methods: {
        init() {
            const regex = new RegExp("(\\n|" + this.fixRegex(this.$page.props.entry.highlights.join("|")) + ")", "gm");
            var tmpParts = this.$page.props.entry.log.split(regex);
            //var tmpParts = [];
            for (var part of tmpParts) {
                if (part == "\n") {
                    this.textParts.push({ content: "", component: Linebreak });
                } else {
                    var found = false;
                    for (var highlight of this.$page.props.entry.highlights) {
                        if (part == highlight) {
                            found = true;
                        }
                    }
                    if (found) {
                        this.textParts.push({ content: part, component: Highlight });
                    } else {
                        this.textParts.push({ content: part, component: Text });
                    }
                }
            }
        },
        fixRegex(regex) {
            return regex.replaceAll("(", "\\(")
                .replaceAll(")", "\\)")
                .replaceAll("[", "\\[")
                .replaceAll("]", "\\]")
                .replaceAll("{", "\\{")
                .replaceAll("}", "\\}")
        }
    },
    computed: {

    },
    mounted() {
        this.init();
    },
    watch: {

    }
}
</script>