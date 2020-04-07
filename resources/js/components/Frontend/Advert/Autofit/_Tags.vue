<template>
    <div>
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

        <div class="task-form-wrap" v-if="popularTagsList">
            <div class="label">Самые популярные </div>
            <div class="related-searches">
                <a
                    v-for="item in popularTagsList"
                    class="related-searches-item"
                    @click.prevent="handlePopularTag(item)"
                    :href="item.slug"
                    :class="{active: isActive(item)}"
                >{{ item.name }}</a>
            </div>
        </div>
    </div>
</template>

<script>
    import Treeselect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.min.css';

    export default {
        props: {
            multiple: {type: Boolean, default: true},
            category: {type: Number, required: false},
            initTags: {type: Array, default: () => []},
            title: {type: String, required: false, default: 'Теги'}
        },

        data() {
            return {
                tags: this.initTags,
                tagsList: [],
                popularTagsList: [],
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

        methods: {
            handlePopularTag(tag) {
                if(this.tags.filter(tagId => tagId === tag.id).length > 0) {
                    this.tags.splice(this.tags.indexOf(tag.id), 1);
                    return true;
                }
                this.tags.push(tag.id)
            },
            isActive(tag) {
                return this.tags.filter(tagId => tagId === tag.id).length > 0
            }
        },

        watch: {
            tags() {
                this.$emit('change', this.tags)
            },
            category() {
                this.tags = [];

                if(!this.category) {
                    return;
                }

                axios.post(this.route('api.category.autofit_tags'), {category_id: this.category})
                    .then(response => {
                        const res = response.data;

                        if(!res.success) {
                            throw new Error(res.data.error);
                        }
                        const data = res.data;

                        this.tagsList = data.list;
                        this.popularTagsList = data.popular;

                        this.$emit('limit-changed', data.prices);
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
    .active {
        border: 1px solid rgba(3, 155, 229, .9);
        color: #0277bd;
    }
</style>
