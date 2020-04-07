<template>
    <div class="category-sidebar-inner sticky">
        <div class="category-sidebar-container">
            <div class="sidebar-title">
                Фильтр поиска
                <div class="filter-loader" v-if="isLoading"><img src="/images/ajax-loader.gif" alt=""></div>
            </div>

            <form action="">
                <div class="form-input-range">
                    <div class="form-input-range-label">
                        <label for="range-from">Цена от</label>
                        <label for="range-to">Цена до</label>
                    </div>

                    <div class="form-input-range-inner">
                        <input type="text" id="range-from" placeholder="Минимум" v-model.number="priceFrom"><span></span>
                        <input type="text" id="range-to" placeholder="Максимум" v-model.number="priceTo">
                    </div>
                </div>

                <div class="filter-date">
                    <div class="form-group">
                        <label for="filter-date">Когда</label>
                        <input type="text" id="filter-date" placeholder="Выберите дату" readonly="readonly" class="flatpickr-input" v-model="date">
                        <svg class="calendar-icon"><use xlink:href="/images/sprite-inline.svg#calendar-icon"></use></svg>
                    </div>
                </div>

                <div class="form-group-select">
                    <label for="filter-city">Город</label>
                    <div class="select">
                        <select id="filter-city" v-model="city">
                            <option value="">Все города</option>
                            <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group-select">
                    <label for="filter-city">Район</label>
                    <div class="select">
                        <select id="filter-district" v-model="district">
                            <option value="">Все районы</option>
                            <option v-for="item in districts" :value="item.id">{{ item.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-check">
                    <label for="agree">Только открытые заказы <input type="checkbox" id="agree" required="required" v-model="onlyActive"><span class="checkmark"></span></label>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions, mapGetters, mapMutations } from 'vuex'

    export default {
        props: ['cities'],

        data() {
            return {
                priceFrom: 0,
                priceTo: 0,
                city: window.city.id,
                district: '',
                date: '',
                onlyActive: false,
            }
        },

        created() {
            this.priceFrom = this.price.from;
            this.priceTo = this.price.to;
            this.date = this.stateDate;
            this.city = this.stateCity;
            this.district = this.stateDistrict;
            this.onlyActive = this.stateOnlyActive;
        },

        watch: {
            priceFrom() {
                this.setPriceFrom(this.priceFrom);
            },
            priceTo() {
                this.setPriceTo(this.priceTo);
            },
            date() {
                this.setDate(this.date);
            },
            city() {
                this.setCity(this.city);
            },
            district() {
                this.setDistrict(this.district);
            },
            onlyActive() {
                this.setActiveOnly(this.onlyActive);
            }
        },

        methods: {
            ...mapMutations('filter', [
                'setPriceFrom', 'setPriceTo', 'setDate', 'setCity', 'setDistrict', 'setActiveOnly'
            ])
        },

        computed: {
            ...mapState({
                price: state => state.filter.price,
                stateDistrict: state => state.filter.district,
                stateDate: state => state.filter.date,
                stateCity: state => state.filter.city,
                stateOnlyActive: state => state.filter.onlyActive,
            }),
            ...mapGetters({
                isLoading: 'filter/isLoading'
            }),
            districts() {
                if(!this.city) {
                    return []
                }

                return this.cities.filter(city => city.id === this.city)[0].districts || []
            }
        },

        mounted() {
            $("#filter-date").flatpickr({
                locale: "ru",
                dateFormat: "d-m-Y"
            });
        },
    }
</script>

<style scoped>
.filter-loader {
    width: 20px;
    float: right;
}
</style>
