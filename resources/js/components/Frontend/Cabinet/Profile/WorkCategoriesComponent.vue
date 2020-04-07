<template>
    <div class="personal-content-inner">
        <div class="main-title">Категории работ</div>
        <div class="selected-categories">
            <div class="selected-categories-item" v-for="selectedCategory in selectedCategories">
                <span>{{ categoryName(selectedCategory) }}</span>
                <button @click="deleteSubcategorySelect(selectedCategory)"> <span>×</span></button>
            </div>
        </div>

        <div class="questionnaire-inner-container space-between">
            <div class="questionnaire-subtitle text">Отметьте галочкой категории услуг, в которых вы желаете работать. Уведомления о новых заданиях в выбранных категориях будут приходить вам на электронную почту.</div>
            <button class="btn btn-big btn-yellow" @click="onAddMoreCategories" v-if="!isUserHasPremium">Купить премиум доступ</button>
        </div>
        <form>
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
                                        <label :for="'item-id-' + child.id" @click="onCategoryToggle(child.id)">{{ child.name }}
                                            <input
                                                type="checkbox"
                                                :id="'item-id-' + child.id"
                                                v-model="selectedCategories"
                                                :value="child.id"
                                            ><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="form-group" v-if="child.dimension">
                                        <label class="label" :for="'item-id-' + child.dimension.id + '-' + child.id">Минимальная цена "за {{ child.dimension.label }}"</label>
                                        <input
                                            type="number"
                                            :for="'item-id-' + child.dimension.id + '-' + child.id"
                                            :placeholder="'рублей за ' + child.dimension.label"
                                            v-model="categoryPrices[child.id]"
                                            @blur="updateCategoryPrice(child.id)"
                                            @keyup="addToPriceUpdateQueue(child.id, $event)"
                                            @keypress.enter.prevent="updateCategoryPrice(child.id)"
                                        >
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>

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
                <a :href="route('pay', {type: 'premium', 'redirect_to': route('cabinet.work_categories')})" class="btn btn-small btn-yellow" target="_blank">Оплатить</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user', 'categories', 'categoriesList', 'selected', 'categoriesLimit'],

        data() {
            return {
                selectedCategories: Object.keys(this.selected).map(cat => parseInt(cat)),
                categoryPrices: {},
                queue: [],
                maxCategoriesSize: this.categoriesLimit,
            }
        },

        computed: {
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

            Object.keys(this.selected).map(categoryId => {
                if(!this.selected[categoryId]) {
                    return;
                }
                this.$set(this.categoryPrices, categoryId, this.selected[categoryId]);
            });

            this.selectedCategories.map(categoryId => {
                let parent = $(`.questionnaire-category-items-list-item .form-check input#item-id-${categoryId}`)
                    .closest('.questionnaire-category-items-list-item');

                parent.find(".form-group").stop().slideToggle();
            });
        },

        methods: {
            addToPriceUpdateQueue(categoryId, e) {
                if(this.queue.includes(categoryId) || e.code === 'Enter') {
                    return;
                }
                this.queue.push(categoryId);
            },
            updateCategoryPrice(categoryId) {
                categoryId = parseInt(categoryId);

                if(!this.queue.includes(categoryId)) {
                    return;
                }

                axios.put(this.route('api.user.cabinet.category_price'), {category_id: categoryId, price: this.categoryPrices[categoryId]})
                    .then(res => {
                        if(res.data.success) {
                            this.setCommonMessage('Цена категории успешно обовлена.');
                        }
                    });

                this.queue = this.queue.filter(id => parseInt(id) !== parseInt(categoryId));
            },
            onAddMoreCategories() {
                $.fancybox.open($('#pay-premium-modal'));
            },
            removeCategory(id) {
                axios.delete(this.route('api.user.cabinet.detach_category'), { data: { category_id: id }})
                    .then(res => {
                        console.log(res.data);

                        if(res.data.success) {
                            this.setCommonMessage('Категория успешно удалена.');
                        } else {
                            this.$vs.notify({
                                title: 'Ошибка.',
                                text: res.data.error,
                                color:'danger',
                                position:'top-right',
                            })
                        }
                    })
            },
            attachCategory(id) {
                axios.post(this.route('api.user.cabinet.attach_category'), {category_id: id})
                    .then(res => {
                        if(res.data.success) {
                            this.setCommonMessage('Категория успешно добавлена.');
                        } else {
                            this.$vs.notify({
                                title: 'Ошибка.',
                                text: res.data.error,
                                color:'danger',
                                position:'top-right',
                            });
                            this.selectedCategories.splice(this.selectedCategories.indexOf(id), 1)
                        }
                    })
            },
            onCategoryToggle: _.debounce(function(id) {
                if(this.selectedCategories.filter(val => val === id).length === 0) {
                    this.removeCategory(id)
                } else {
                    this.attachCategory(id)
                }
            }, 100),

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

                axios.post(API_SAVE_URL, {categories: this.selectedCategories})
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

            categoryName(id) {
                return this.findChild(id).name
            },
            findChild(id) {
                let pickedCategory = '';

                this.categoriesList.forEach(category => category.children ? category.children.forEach(subcategory => {
                    if(subcategory.id === id) {
                        pickedCategory = subcategory;
                    }
                }) : '');

                return pickedCategory;
            },
            deleteSubcategorySelect(removeId) {
                this.selectedCategories = this.selectedCategories.filter(selectedId => +selectedId !== +removeId);

                this.removeCategory(removeId);
            },
        },

        watch: {
            selectedCategories() {

            }
        },
    }
</script>

<style scoped>
    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>
