<template>
    <div>
        <div class="task-form-wrap">
            <div class="form-group-select">
                <label for="city">Город</label>
                <div class="select">
                    <select name="city" id="city" class="form-control" v-model="city">
                        <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
                    </select>
                </div>

                <span class="invalid-feedback" role="alert" v-if="isError('city')">
                    <strong>{{ getError('city') }}</strong>
                </span>
            </div>
        </div>

        <div class="task-form-wrap">
            <label class="label">Районы (оставьте пустым, если это относится ко всем)</label>

            <div>
                <treeselect
                    :options="distinctOptions"
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
                return this.cities.filter(city => city.id === this.city)[0].districts
            },
        },

        watch: {
            city() {
                this.$emit('changeCity', this.city);
                this.districts = [];
            },
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
