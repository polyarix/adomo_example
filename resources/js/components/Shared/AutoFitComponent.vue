<template>
    <div class="autofit" style="display: none;" id="autofit-modal" ref="modal">
        <div class="autofit-title">Автоподбор мастера/бригады       </div>
        <div class="task-form-wrap">
            <div class="label">Выберите категорию</div>

            <treeselect v-model="category" :options="categories" :disable-branch-nodes="true" :show-count="true" placeholder="Категория" />
        </div>

        <div class="task-form-wrap">
            <label class="label">Выберите теги</label>

            <div>
                <treeselect
                    :options="tagOptions"
                    v-model="selectedTags"
                    :value="selectedTags"
                    :multiple="true"
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

        <button class="btn btn-large btn-yellow autofit-submit" @click.prevent="onSubmit">Поиск</button>
    </div>
</template>

<script>
    // import the component
    import Treeselect from '@riophae/vue-treeselect';
    import '@riophae/vue-treeselect/dist/vue-treeselect.min.css'

    export default {
        props: ['categories'],

        data() {
            return {
                tags: [],
                selectedTags: [],
                category: null
            }
        },

        computed: {
            tagOptions() {
                return this.tags.map(tag => ({
                    id: tag.id,
                    label: tag.name,
                    customLabel: `# ${tag.name}`
                }))
            },
        },

        methods: {
            onSubmit() {
                if(!this.category) {
                    return;
                }
                window.location.href = this.route('auto_fit', {category: this.category, tags: this.selectedTags})
            }
        },

        watch: {
            category() {
                this.tags = [];

                axios.post(this.route('api.category.tags'), {category_id: this.category})
                    .then(res => {
                        this.tags = res.data.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        },

        destroyed() {
            console.log('@click="autoFitDisplayed"')
        },

        mounted() {
            window.location.href = this.route('autofit');
        },

        components: {Treeselect}
    }
</script>

<style scoped>
</style>
