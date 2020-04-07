<template>
<div>
    <treeselect
        v-model="value"
        :options="tree"
        :disable-branch-nodes="true"
        :show-count="true"
        placeholder="Категория"
    >
    </treeselect>
</div>
</template>

<script>
    // import the component
    import Treeselect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.min.css'

    export default {
        props: ['tree'],

        data() {
            return {
                // define the default value
                value: null,
                // define options
                options: [ {
                    id: 'a',
                    label: 'a',
                    children: [ {
                        id: 'aa',
                        label: 'aa',

                        children: [ {
                            id: 'aa',
                            label: 'aa',
                        }, {
                            id: 'ab',
                            label: 'ab',
                        } ],
                    }, {
                        id: 'ab',
                        label: 'ab',
                    } ],
                }, {
                    id: 'b',
                    label: 'b',
                }, {
                    id: 'c',
                    label: 'c',
                } ],
            }
        },

        computed: {
            normalized() {
                return this.tree.map(el => {
                    if(el.children && el.children.length > 0) {
                        el.children = this.normalizeChildren(el.children)
                    }

                    return el;
                })
            }
        },

        methods: {
            normalizeChildren(el) {
                return this.tree.map(el => {
                    el.label = 'test123';

                    return el;
                })
            }
        },

        created() {

        },

        components: { Treeselect },
    }
</script>

<style scoped>

</style>
