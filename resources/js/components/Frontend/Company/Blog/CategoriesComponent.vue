<template>
    <div class="task-form-wrap">
        <label class="label">Категории</label>

        <div>
            <treeselect
                :options="categoryOptions"
                v-model="categories"
                :value="categories"
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
            categoriesList: {
                type: Array,
                default: () => []
            },
            initCategories: {
                type: Array,
                default: () => []
            },
        },

        data() {
            return {
                categories: this.initCategories,
            }
        },

        computed: {
            categoryOptions() {
                return this.categoriesList.map(category => ({
                    id: category.id,
                    label: category.name,
                    customLabel: category.name
                }))
            },
        },

        watch: {
            categories() {
                this.$emit('change', this.categories)
            },
        },

        components: {
            Treeselect
        }
    }
</script>

<style scoped>

</style>
