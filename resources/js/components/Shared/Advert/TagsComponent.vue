<template>
    <div class="task-form-wrap">
        <label class="label">{{ title }}</label>

        <div>
            <treeselect
                :options="tagOptions"
                v-model="tags"
                :value="tags"
                :multiple="multiple"
                placeholder="Выберите из списка или введите вручную"

                clearAllText="Очисти все"
                clearValueText="Удалить значение"
                loadingText="Загрузка..."
                noChildrenText="Нет доступных под-опций"
                noOptionsText="Нет доступных опций"
                noResultsText="Ничего не найдено"
            >
                <div slot="value-label" slot-scope="{ node }">{{ node.raw.customLabel }}</div>
            </treeselect>
        </div>
    </div>
</template>

<script>
    import Treeselect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.min.css';

    export default {
        props: {
            multiple: {
                type: Boolean,
                default: true
            },
            categories: {
                type: Array,
                default: () => []
            },
            initTags: {
                type: Array,
                default: () => []
            },
            title: {type: String, required: false, default: 'Теги'}
        },

        data() {
            return {
                tags: this.initTags,
                tagsList: [],
            }
        },

        computed: {
            tagOptions() {
                return this.tagsList.map(tag => ({
                    id: tag.id,
                    label: tag.name,
                    customLabel: `# ${tag.name}`
                }))
            },
        },

        created() {
            if(this.categories) {
                axios.post(this.route('api.user.cabinet.tags'), {categories: this.categories})
                    .then(res => {
                        this.tagsList = res.data.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        },

        watch: {
            tags() {
                this.$emit('change', this.tags)
            },
            categories() {
                axios.post(this.route('api.user.cabinet.tags'), {categories: this.categories})
                    .then(res => {
                        this.tagsList = res.data.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        },

        components: {
            Treeselect
        }
    }
</script>

<style scoped>

</style>
