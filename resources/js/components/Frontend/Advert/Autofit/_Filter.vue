<template>
    <div class="col category-sidebar">
        <!-- can .sticky-->
        <div class="category-sidebar-btn">
            <div class="category-sidebar-btn-inner"><img src="images/category-burger.svg" alt=""/><span>Автоподбор</span></div>
        </div>

        <div class="category-sidebar-inner">
            <div class="autofit" id="autofit">
                <div class="autofit-title">Параметры автоподбора</div>

                <!-- City -->
                <div class="autofit-subtitle"><span>Где?</span></div>
                <div class="task-form-wrap">
                    <div class="form-group-select">
                        <label for="city">Город</label>
                        <div class="select">
                            <select id="city" v-model="city">
                                <option v-for="item in cities" :value="item.id">{{ item.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- District -->
                <!--<div class="task-form-wrap">
                    <div class="form-group-select">
                        <label for="area">Район</label>
                        <div class="select">
                            <select id="area" v-model="district">
                                <option>Все районы</option>
                                <option v-for="item in districts" :value="item.id">{{ item.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>-->

                <districts-component
                    title="Район"
                    @changeDistricts="district = $event"
                    :cities="cities"
                    :init-city="city"
                    :key="city"
                    :multiple="false"
                />

                <!-- Category -->
                <div class="autofit-subtitle"><span>Что делать?</span></div>
                <div class="task-form-wrap" id="category_item">
                    <div class="label">Выберете категорию *</div>
                    <div id="treeselect">
                        <treeselect
                            v-model="category"
                            :options="categories"
                            :disable-branch-nodes="true"
                            :show-count="true"
                            placeholder="Категория"
                            :class="{ 'is-invalid': hasError('category')  }"
                            clearAllText="Очисти все"
                            clearValueText="Удалить значение"
                            loadingText="Загрузка..."
                            noChildrenText="Нет доступных под-опций"
                            noOptionsText="Нет доступных опций"
                            noResultsText="Ничего не найдено"
                        />
                    </div>

                    <div class="photo-input-control">
                        <span class="invalid-feedback" role="alert" v-if="hasError('category')">
                            <strong>{{ getError('category') }}</strong>
                        </span>
                    </div>
                </div>

                <!-- Tags -->
                <tags-component title="Укажите теги" :category="category" @change="onTagsChange" @limit-changed="onLimitChanged" />

                <div class="autofit-subtitle"><span>Кто исполнит?</span></div>
                <div class="form-group-radio">
                    <div class="form-group-name">Выберите исполнителя</div>
                    <div class="radio">
                        <input id="who-1" name="who" type="radio" v-model="executor_type" value="" />
                        <label class="radio-label" for="who-1">Не важно</label>
                    </div>
                    <div class="radio">
                        <input id="who-2" name="who" type="radio" v-model="executor_type" value="individual" />
                        <label class="radio-label" for="who-2">Частный мастер</label>
                    </div>
                    <div class="radio">
                        <input id="who-3" name="who" type="radio" v-model="executor_type" value="brigade" />
                        <label class="radio-label" for="who-3">Бригада</label>
                    </div>
                </div>

                <div class="form-check">
                    <label for="with_reviews">
                        Только с отзывами
                        <input type="checkbox" id="with_reviews" v-model="with_reviews">
                        <span class="checkmark"></span>
                    </label>
                </div>

                <div class="form-group-range task-form-wrap">
                    <div class="label">Цена {{ dimension ? `за "${dimension.label}"` : '' }}</div>

                    <div class="filter-price" id="filter-price">
                        <div class="filter-price-inputs">
                            <div class="form-group">
                                <div class="form-group-inner">
                                    <input
                                        class="form-control"
                                        id="minCost"
                                        type="text"
                                        placeholder="От"
                                        :min="minPrice"
                                        :max="maxPrice"
                                        v-model.number="priceFrom"
                                    />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group-inner">
                                    <input
                                        class="form-control"
                                        id="maxCost"
                                        type="text"
                                        placeholder="До"
                                        :min="minPrice"
                                        :max="maxPrice"
                                        v-model.number="priceTo"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="filter-price-range">
                            <div id="filter-slider" ref="slider"></div>
                        </div>
                    </div>
                </div>
                <div class="btn btn-large btn-yellow autofit-submit" id="autofit-submit" @click="onSubmit">Поиск</div>
            </div>
        </div>
    </div>
</template>

<script>
    import Treeselect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.min.css';
    import DistrictsComponent from "../../../Shared/Advert/DistrictsComponent";
    import TagsComponent from "./_Tags";

    export default {
        props: ['cities', 'categories'],

        data() {
            return {
                city: window.city.id,
                district: '',
                category: null,
                tags: [],
                districts: [],
                executor_type: '',
                with_reviews: false,
                priceFrom: 0,
                priceTo: 1000,
                value: [],

                minPrice: 0,
                maxPrice: 2000
            }
        },

        computed: {
            dimension() {
                const category = this.findChild(this.category);

                if(!category) {
                    return null;
                }
                return category.dimension ? category.dimension : null;
            },
            categoriesList() {
                return this.categories.map(category => ({
                    id: category.id,
                    label: category.name,
                    customLabel: category.name
                }))
            },
            currentCity() {
                return this.cities.filter(city => city.id === this.city)[0]
            },
        },

        methods: {
            onTagsChange(payload) {
                this.tags = payload;
            },
            onLimitChanged(payload) {
                this.priceFrom = payload.min;
                this.priceTo = payload.max;
                this.minPrice = payload.min;
                this.maxPrice = payload.max;

                this.reInitPriceSlider();
            },
            findChild(id) {
                let selectedCategory;

                this.categories.forEach(category => category.children ? category.children.forEach(subcategory => {
                    if(subcategory.id === id) {
                        selectedCategory = subcategory;
                    }
                }) : '');

                return selectedCategory;
            },
            onSubmit() {
                this.clearErrorsBag();

                if(!this.category) {
                    this.addError('category', 'Выберите категорию')
                }

                if(!this.isValid()) {
                    $('#category_item .vue-treeselect__input').focus();
                    this.setCommonError('Не заполнены обязательные поля.', 2000);

                    return false;
                }

                this.clearBag();

                this.$emit('submit', {
                    city: this.city,
                    district: this.district,
                    category: this.category,
                    tags: this.tags,
                    executor_type: this.executor_type,
                    price_from: this.priceFrom,
                    price_to: this.priceTo,
                    with_reviews: !!this.with_reviews
                })
            },
            reInitPriceSlider() {
                const slider = $(this.$refs.slider);

                slider.slider({
                    min: this.minPrice,
                    max: this.maxPrice,
                    values: [this.minPrice, this.maxPrice],
                    range: true,
                    stop: (event, ui) => {
                        this.priceFrom = slider.slider("values", 0);
                        this.priceTo = slider.slider("values", 1);
                    },
                    slide: (event, ui) => {
                        this.priceFrom = slider.slider("values", 0);
                        this.priceTo = slider.slider("values", 1);
                    }
                });
            }
        },

        mounted() {
            var sidebar_btn = $(".category-sidebar-btn");
            var sidebar = $(".category-sidebar");
            var sidebar_time = 0.5;
            var sidebar_start = {
                xPercent: 100
            };
            var sidebar_end = {
                xPercent: 0,
                ease: Power4.easeInOut
            };

            // on submit
            /*$("body").on("click", "#autofit-submit", function() {
                $("#autofit-result").show();
                $(".autofit-info").hide();
                sidebar.removeClass("sidebar-autofit-fix");
                if(!$(".autofit-page").hasClass("has-result")){
                    setTimeout(function(){
                        if($(window).width() < 1280){
                            sidebar_tl.progress(0)
                        }
                        $('html, body').animate({scrollTop:0},500);
                    },500)
                }
                $(".autofit-page").addClass("has-result");

            });*/

            var sidebar_tl = gsap.timeline({ paused: true, reversed: true});
            sidebar_tl.fromTo(sidebar, sidebar_time, sidebar_start, sidebar_end);
            sidebar_btn.on("click",function(){
                sidebar_tl.reversed() ?  sidebar_tl.play() : sidebar_tl.reverse();
            });
            $(window).resize(function() {
                sidebarHandler();
            });
            function sidebarHandler(){
                if( $(window).width() < 1280 ){
                    if(!$(".autofit-page").hasClass("has-result")){
                        sidebar.removeAttr("style").addClass("sidebar-autofit-fix")
                        sidebar_tl.progress( 100 );
                    }else{
                        sidebar_tl.reversed() ? sidebar_tl.reverse() : false;
                    }
                }else{
                    sidebar.removeAttr("style")
                    sidebar_tl.progress( 100 );
                }
            }
            sidebarHandler();

            this.reInitPriceSlider();
        },

        watch: {
            category() {
                this.reInitPriceSlider();

                this.$emit('change-category', this.category ? this.findChild(this.category) : null);
            },
            priceFrom(val) {
                var value1=val;
                var value2=this.priceTo;

                if(parseInt(value1) > parseInt(value2)){
                    value1 = value2;
                    this.priceFrom = value1;
                }
                $("#filter-slider").slider("values",0,value1);
            },
            priceTo(val) {
                var value1 = this.priceFrom;
                var value2 = this.priceTo;

                if (value2 > this.maxPrice) {
                    value2 = this.maxPrice;
                    this.priceTo = this.maxPrice;
                }

                if(parseInt(value1) > parseInt(value2)){
                    value2 = value1;
                    this.priceTo = value2;
                }
                $("#filter-slider").slider("values",1,value2);
            }
        },

        components: {TagsComponent, DistrictsComponent, Treeselect}
    }
</script>

<style scoped>
</style>
