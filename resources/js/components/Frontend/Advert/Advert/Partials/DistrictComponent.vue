<template>
    <div class="task-form-wrap">
        <div class="form-group-select">
            <label class="label" for="district">{{ title }}</label>

            <treeselect
                id="district"
                :options="distinctOptions"
                v-model="district"
                :value="district"
                :multiple="false"
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
            cities: {
                type: Array,
                default: () => []
            },
            initCity: {type: Number},
            title: {type: String, default: 'Район'},
            initDistrict: {
                type: Number,
                required: false
            },
        },

        data() {
            return {
                city: this.initCity,
                district: this.initDistrict,
            }
        },

        computed: {
            distinctOptions() {
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

                console.log(this.cities.filter(city => city.id === this.city))

                return this.cities.filter(city => city.id === this.city)[0].districts || []
            },
        },

        watch: {
            district() {
                this.$emit('changeDistrict', this.district)
            },
            initCity() {
                this.district = null;
            }
        },

        components: {
            Treeselect
        }
    }
</script>

<style scoped>

</style>
