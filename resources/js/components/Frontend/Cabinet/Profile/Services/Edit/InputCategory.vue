<template>
    <div class="lk-services-select-category">
        <div class="form-group-select">
            <label :for="'service-category' + prefix">Категория</label>
            <div class="select">
                <select :id="'service-category' + prefix" v-model="category" :class="{ 'is-invalid': showError }">
                    <option :value="''">Выберите категорию</option>
                    <option v-for="category in categoriesList" :value="category.id">{{ category.name }}</option>
                </select>
            </div>
        </div>
        <div class="form-group-select">
            <label :for="'service-subcategory' + prefix">Подкатегория</label>
            <div class="select">
                <select :id="'service-subcategory' + prefix" :disabled="!isCategorySelected" v-model="subCategory">
                    <option value="">Выберите подкатегорию</option>

                    <option v-for="category in subcategories" :value="category.id">{{ category.name }}</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['categoriesList', 'categoriesSelected', 'showError', 'categoryProp', 'subCategoryProp'],

        data() {
            return {
                category: '',
                subCategory: this.subCategoryProp,
                init: false,
            }
        },

        created() {
            if(!this.category && this.subCategory) {
                let parent = this.findParent(this.subCategory);
                this.category = parent.id;
            }
        },

        mounted() {
            setTimeout(() => {this.init = true;}, 100)
        },

        methods: {
            findParent(id) {
                let pickedCategory = '';

                this.categoriesList.forEach(category => {
                    if(!category.children) {
                        return;
                    }

                    category.children.forEach(subcategory => {
                        if(subcategory.id === id) {
                            pickedCategory = category;
                            return;
                        }
                    })
                });

                return pickedCategory;
            }
        },

        computed: {
            isCategorySelected() {
                return Boolean(this.category)
            },
            subcategories() {
                if(!this.isCategorySelected) {
                    return [];
                }

                let category = this.categoriesList.filter(category => category.id === this.category)[0];
                if(!category.children) {
                    return [];
                }

                return category.children.filter(subcategory => {
                    return this.categoriesSelected.indexOf(subcategory.id) === -1 || subcategory.id === +this.subCategory;
                })
            },
            // prefix for build unique id for selects
            prefix() {
                return Math.random()
            }
        },

        watch: {
            category() {
                if(this.init) {
                    this.subCategory = '';
                }

                if(!this.category) {
                    // category was removed
                    this.$emit('categoryPick', null)
                }
            },
            subCategory() {
                this.$emit('categoryPick', this.subCategory)
            }
        }
    }
</script>

<style scoped>
    .is-invalid {
        border-color: #dc3545 !important;
    }
    select:disabled {
        background: silver;
    }
</style>
