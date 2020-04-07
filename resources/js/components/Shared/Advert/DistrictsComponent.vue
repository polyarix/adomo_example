<template>
    <div class="task-form-wrap">
        <label class="label">{{ title }}</label>

        <div>
            <treeselect
                :options="districtOptions"
                v-model="districts"
                :value="districts"
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
            cities: {
                type: Array,
                default: () => []
            },
            initCity: {type: Number},
            title: {type: String, default: 'Районы'},
            initDistricts: {
                type: Array,
                default: () => []
            },
        },

        data() {
            return {
                city: this.initCity,
                districts: this.initDistricts,
            }
        },

        computed: {
            districtOptions() {
                return this.districtsList.map(district => ({
                    id: district.id,
                    label: district.name,
                    customLabel: district.name
                }))
            },
            districtsList() {
                if(!this.city) {
                    return []
                }

                return this.cities.filter(city => city.id === this.city)[0].districts || []
            },
        },

        watch: {
            districts() {
                this.$emit('changeDistricts', this.districts)
            },
        },

        components: {
            Treeselect
        }
    }
</script>

<style scoped>

</style>
