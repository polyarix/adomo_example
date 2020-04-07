<template>
<div>
    <div class="questionnaire-category-container">
        <div class="questionnaire-category" v-for="(category, index) in categoriesList">
            <a class="questionnaire-category-heading" href="javascript:;">
                <div class="questionnaire-category-heading-icon">
                    <img :src="category.icon_work_category ? '/storage/' + category.icon_work_category : '/images/toolbox-icon.svg'" alt="">
                </div>

                <div class="questionnaire-category-heading-name">{{ category.name }}</div>
                <div class="questionnaire-category-heading-control">
                    <svg class="arrow-down-icon">
                        <use xlink:href="/images/sprite-inline.svg#arrow-down-icon"></use>
                    </svg>
                </div>
            </a>

            <div class="questionnaire-category-items" style="display: none;">
                <div class="questionnaire-category-items">
                    <ul class="questionnaire-category-items-list">
                        <li class="questionnaire-category-items-list-item" v-for="(child, child_index) in category.children">
                            <div class="form-check">
                                <label :for="'item-id-' + child.id">{{ child.name }}
                                    <input type="checkbox" :id="'item-id-' + child.id" v-model="selectedCategories" :value="child.id"><span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group" v-if="child.dimension">
                                <label class="label" :for="'item-id-' + child.dimension.id + '-' + child.id">Минимальная цена "за {{ child.dimension.label }}"</label>
                                <input type="number" :for="'item-id-' + child.dimension.id + '-' + child.id" :placeholder="'рублей за ' + child.dimension.label" v-model="categoryPrices[child.id]">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Чекбокс-->
    <div class="questionnaire-inner-container">
        <div class="form-check">
            <label for="agree">Я соглашаюсь с правилами использования сервиса, а также с передачей и обработкой моих данных в adomo.ru <br> Я подтверждаю, что все данные заполнены мною верно и несу ответственность за размещение информации на сервисе.
                <input type="checkbox" id="agree" required="required" v-model="rulesAccepted" :class="{ 'form-control': true, 'is-invalid': hasError('rules_accepted') }">
                <span class="checkmark"></span>
            </label>

            <span class="invalid-feedback" role="alert" v-if="hasError('rules_accepted')">
                <strong>{{ getError('rules_accepted') }}</strong>
            </span>
        </div>
    </div>
    <!-- submit-->
    <button class="btn btn-large btn-yellow" @click.prevent="onConfirm"> <span>Завершить регистрацию</span></button>
</div>
</template>

<script>
    import * as BarConstants from "../../Cabinet/_partials/bar_constants";

    export default {
        props: ['categoriesList'],

        data() {
            return {
                selectedCategories: [],
                categoryPrices: {},
                rulesAccepted: false
            }
        },

        computed: {
            groupedCategories() {
                let list = [];
                this.selectedCategories.forEach(id => {
                    list.push(this.findChild(id));
                });

                return _.groupBy(list, 'parent_id');
            },

            constants() {
                return BarConstants
            },

            selectedCategoriesCount() {
                return this.selectedCategories.length
            },
            canPickMore() {
                return this.categoriesLimit === -1 || this.selectedCategoriesCount < this.maxCategoriesSize
            },
            isPickedMaxCount() {
                return this.categoriesLimit !== -1 && this.selectedCategoriesCount >= this.maxCategoriesSize
            },
            isUserHasPremium() {
                return !!this.user.premium_to && this.$moment(this.user.premium_to).diff(this.$moment.now()) > 0
            }
        },

        methods: {
            onConfirm() {
                this.clearErrorsBag();
                if(!this.rulesAccepted) {
                    this.addError('rules_accepted', 'Вы не приняли правила.');
                }
                if(!this.isValid()) {
                    this.setCommonError('Заполните обязательные поля.');
                    return false;
                }

                let categories = {};
                this.selectedCategories.map(categoryId => {
                    categories[categoryId] = this.categoryPrices[categoryId] || null;
                });

                this.$emit('next-step', categories)
            }
        },

        mounted() {
            $(".questionnaire-category-heading").on("click", function(){
                $(this).toggleClass("open");
                $(this).next().stop();
                $(this).next().slideToggle();
            });

            $(".questionnaire-category-items-list-item .form-check input").on("change", e => {
                let parent = $(e.target).closest('.questionnaire-category-items-list-item');
                parent.find(".form-group").stop().slideToggle();
            });
        },
    }
</script>

<style scoped>

</style>
