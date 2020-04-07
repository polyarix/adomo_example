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
                                            <input type="checkbox" :id="'item-id-' + child.id" v-model="selectedCategories" :value="child.id"><span class="checkmark"></span>
                                        </label>
                                    </div>

                                    <div class="form-group" v-if="child.dimension">
                                        <label class="label" :for="'item-id-' + child.dimension.id + '-' + child.id">Минимальная цена "за {{ child.dimension.label }}"</label>
                                        <input type="number" :for="'item-id-' + child.dimension.id + '-' + child.id" :placeholder="'рублей за ' + child.dimension.label" v-model="categoryPrices[child.id]" @blur="onBlurPrice(child.id)">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['company', 'categories', 'categoriesList', 'selected', 'categoriesLimit'],

        data() {
            return {
                selectedCategories: Object.keys(this.selected).map(cat => parseInt(cat)),
                categoryPrices: {},
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
            onBlurPrice(categoryId) {
                axios.put(this.route('api.company.category_price', {company: this.company.slug}), {
                    category_id: categoryId, price: this.categoryPrices[categoryId]
                })
                    .then(res => {
                        if(res.data.success) {
                            this.setCommonMessage('Цена категории успешно обовлена.');
                        }
                    })
            },
            onAddMoreCategories() {
                $.fancybox.open($('#pay-premium-modal'));
            },
            removeCategory(id) {
                axios.delete(this.route('api.company.category', {company: this.company.slug}), { data: { category_id: id }})
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
                axios.post(this.route('api.company.category', {company: this.company.slug}), {category_id: id})
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
