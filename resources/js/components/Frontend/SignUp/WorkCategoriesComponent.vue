<template>
    <div class="row registration-part">
        <div class="col questionnaire-outer">
            <div class="questionnaire">
                <div class="questionnaire-heading">Заполнение анкеты</div>
                <div class="questionnaire-subtitle">Размещайте достоверную информацию о себе, добавляйте документы подтверждающие личность, сертификаты, которые подтвердят вашу профессиональность. Это поможет быстрее найти исполнителя/заказчика. </div>
                <div class="hr-1"></div>
                <div class="questionnaire-inner-container space-between">
                    <div class="questionnaire-subtitle">Отметьте галочкой категории услуг, в которых вы желаете работать. Уведомления о новых заданиях в выбранных категориях будут приходить вам на электронную почту.</div>
                    <button class="btn btn-big btn-yellow" @click="onAddMoreCategories" v-if="!isUserHasPremium">Купить премиум доступ</button>
                </div>

                <div class="information-alert">
                    <div class="information-alert-img"><img src="/images/warning.svg" alt=""></div>
                    <div class="information-alert-text"><strong>Добавление минимальной цены увеличит ваши шансы! </strong>
                        <p>Исполнители, заполнившие поля стоимости, попадают в выдачу автоподбора заказчиков</p>
                    </div>
                </div>

                <form @submit.prevent="onSubmit">
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
                                <ul class="questionnaire-category-items-list">
                                    <li class="questionnaire-category-items-list-item" v-for="(child, child_index) in category.children" >
                                        <div class="form-check" :class="{'disabled-picker': !canPickMore && !isSelected(child.id)}">
                                            <label :for="'item-id-' + child.id">{{ child.name }}
                                                <input type="checkbox" :id="'item-id-' + child.id" @change.prevent="categoryToggle(child.id, $event)" :value="child.id" :checked="isSelected(child.id)"><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-group" v-if="(canPickMore || isSelected(child.id)) && child.dimension">
                                            <label class="label" :for="'item-id-' + child.dimension.id + '-' + child.id">Минимальная цена "за {{ child.dimension.label }}"</label>
                                            <input type="number" :for="'item-id-' + child.dimension.id + '-' + child.id" :placeholder="'рублей за ' + child.dimension.label" v-model="categoryPrices[child.id]">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Чекбокс-->
                    <div class="questionnaire-inner-container">
                        <div class="form-check">
                            <label for="agree">Я соглашаюсь с правилами использования сервиса, а также с передачей и обработкой моих данных в adomo.ru <br> Я подтверждаю, что все данные заполнены мною верно и несу ответственность за размещение информации на сервисе.
                                <input type="checkbox" id="agree" required="required" v-model="rulesAccepted"><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <!-- submit-->
                    <button class="btn btn-large btn-yellow" @click.prevent="onSubmit"> <span>Завершить регистрацию</span></button>
                </form>
            </div>
        </div>
        <div class="col right-bar">
            <right-bar-component :progress="85" :type="user.type" :page="constants.CATEGORIES_PAGE" />

            <div class="questionnaire-selected-category sticky">
                <div class="hr-2"></div>
                <div class="title">Выбранные категории</div>
                <div class="questionnaire-selected-category-group" v-for="(categoryItems, key) in groupedCategories">
                    <div class="questionnaire-selected-category-group_name">{{ findParent(key).name }}</div>
                    <div class="questionnaire-selected-category-group-item" v-for="selectSubcategory in categoryItems">
                        <button>
                            <span @click="deleteSubcategorySelect(selectSubcategory.id)">×</span>
                        </button>
                        <span>{{ selectSubcategory.name }}</span>
                    </div>
                </div>

                <div class="alert alert-success" v-if="common_message">{{ common_message }}</div>
                <div class="alert alert-danger" v-if="common_error">{{ common_error }}</div>
            </div>
        </div>

        <div class="modal modal-take-task" style="display: none;" id="pay-premium-modal">
            <div class="modal-title">Хотите оплатить премиум доступ?</div>
            <div class="modal-info-box">
                <p>С премиум аккаунтом вы сможете выбрать <em style="font-weight: bold;">неограниченное количество специализаций</em> для вашего аккаунта.</p>
                <p style="margin: 10px 0"></p>
                <p>Стоимость платежа: <b style="font-weight: bold;">100 рублей</b></p>
                <p>Срок действия: <b style="font-weight: bold;">1 месяц</b></p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-small btn-grey" onclick="$.fancybox.close($('#pay-premium-modal'))">Отмена</button>
                <a :href="route('pay', {type: 'premium', 'redirect_to': route('sign-up.categories')})" class="btn btn-small btn-yellow" target="_blank">Оплатить</a>
            </div>
        </div>
    </div>
</template>

<script>
    import RightBarComponent from "../Cabinet/_partials/RightBarComponent";
    import * as BarConstants from './../Cabinet/_partials/bar_constants';

    const API_SAVE_URL = '/api/user/sign_up/categories';

    export default {
        props: ['user', 'categories', 'categoriesList', 'categoriesLimit'],

        data() {
            return {
                selectedCategories: Object.keys(this.categories).map(cat => parseInt(cat)),
                categoryPrices: {},
                rulesAccepted: false,

                maxCategoriesSize: this.categoriesLimit,
                common_error: '',
                common_message: '',
                errors: {},
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

        mounted() {
            $(".questionnaire-category-heading").on("click", function(){
                $(this).toggleClass("open");
                $(this).next().stop();
                $(this).next().slideToggle();
            });

            $(".questionnaire-category-items-list-item .form-check input").on("change", (e) => {
                let parent = $(e.target).closest('.questionnaire-category-items-list-item');
                parent.find(".form-group").stop().slideToggle();
            });

            Object.keys(this.categories).map(categoryId => {
                if(!this.categories[categoryId]) {
                    return;
                }
                this.$set(this.categoryPrices, categoryId, this.categories[categoryId]);
            });

            this.selectedCategories.map(categoryId => {
                let parent = $(`.questionnaire-category-items-list-item .form-check input#item-id-${categoryId}`)
                    .closest('.questionnaire-category-items-list-item');

                parent.find(".form-group").stop().slideToggle();
            });
        },

        methods: {
            onAddMoreCategories() {
                $.fancybox.open($('#pay-premium-modal'));
            },
            categoryToggle(val, e) {
                const isSelected = this.isSelected(val);

                if(this.isPickedMaxCount && !isSelected) {
                    this.setCommonError('Вы выбрали все доступные направления. Докупите дополнительные, или уберите ранее выбранные.');
                    e.target.checked = false;
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }

                if(isSelected) {
                    this.deleteSubcategorySelect(val)
                } else {
                    this.selectedCategories.push(val)
                }
            },

            onSubmit() {
                let errors = {};
                if(!this.selectedCategories || this.selectedCategories.length === 0) {
                    errors['categories'] = 'Не выбрано ни одной категории.';
                    this.common_error = 'Не выбрано ни одной категории.';
                    setTimeout(() => {this.common_error = ''}, 2000)
                    return;
                }
                if(!this.rulesAccepted) {
                    errors['rules_accepted'] = 'Вы не подтвердили согласие с правилами.';
                    setTimeout(() => {this.common_error = ''}, 2000)
                    this.common_error = 'Вы не подтвердили согласие с правилами.';
                }
                this.errors = errors;

                if(Object.keys(errors).length > 0) {
                    return false;
                }

                this.common_message = this.common_error = '';

                axios.post(API_SAVE_URL, {categories: this.selectedCategories, prices: this.categoryPrices})
                    .then(res => {
                        let data = res.data;

                        if(data.success === true) {
                            this.common_message = 'Данные успешно обновлены.';

                            window.location.href = '/home';
                        } else {
                            this.common_error = data.message;
                        }
                    })
                    .catch(err => {
                        let data = err.response.data;

                        this.common_error = data.message;
                        for(let key in data.errors) {
                            this.errors[key] = data.errors[key][0];
                        }
                    })
            },

            findParent(id) {
                return this.categoriesList.filter(category => {
                    return +category.id === +id;
                })[0];
            },
            findChild(id) {
                let pickedCategory = '';

                this.categoriesList.forEach(category => category.children.forEach(subcategory => {
                    if(subcategory.id === id) {
                        pickedCategory = subcategory;
                    }
                }));

                return pickedCategory;
            },
            deleteSubcategorySelect(removeId) {
                this.selectedCategories = this.selectedCategories.filter(selectedId => +selectedId !== +removeId)
            },

            isSelected(catId) {
                return this.selectedCategories.filter(selectedId => +selectedId === +catId).length > 0
            },
            isError(key) {
                return this.getError(key) !== undefined
            },
            getError(key) {
                return this.errors[key]
            },
        },

        components: { RightBarComponent },
    }
</script>

<style scoped>
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .disabled-picker, .disabled-picker * {
        cursor: not-allowed !important;
    }
</style>
