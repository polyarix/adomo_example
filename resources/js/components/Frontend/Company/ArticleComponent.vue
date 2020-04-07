<template>
    <div class="col questionnaire-outer">
        <div class="questionnaire">
            <form @submit.prevent method="POST">
                <div class="questionnaire-inner-container">
                    <div class="form-group">
                        <label for="title">Заголовок</label>
                        <input name="title" id="title" placeholder="Заголовок статьи" class="" v-model="title" :class="{'is-invalid': isError('title')}">

                        <span class="invalid-feedback" role="alert" v-if="isError('title')">
                            <strong>{{ getError('title') }}</strong>
                        </span>
                    </div>
                </div>

                <div class="lk-services-select-category">
                    <categories-component
                        :categories-list="categoriesList"
                        :init-categories="categories"
                        :class="{'is-invalid': isError('categories')}"
                        @change="categories = $event"
                    />
                </div>

                <span class="invalid-feedback" role="alert" v-if="isError('categories')" style="margin-top: -20px; padding-bottom: 14px;">
                    <strong>{{ getError('categories') }}</strong>
                </span>

                <div class="questionnaire-inner-container">
                    <div class="form-group" style="width: 100%">
                        <label for="content">Статья</label>
                        <!--<textarea name="content" id="content" placeholder="Описание компании" class="" v-model="content"></textarea>-->

                        <vue-editor v-model="content" :class="{'is-invalid': isError('content')}"></vue-editor>
                    </div>

                    <span class="invalid-feedback" role="alert" v-if="isError('content')">
                        <strong>{{ getError('content') }}</strong>
                    </span>
                </div>

                <div class="task-form-wrap">
                    <div class="task-photo-component">
                        <div class="label">Превью</div>
                    </div>
                    <uploader
                        v-model="files"
                        :files="filesList"
                        :url="route('api.companies.articles.photo_upload')"
                        :limit="1"
                        @on-success="onSuccess"
                        :params="{_token: csrfToken}"
                        :auto-upload="false"
                        :class="{'is-invalid': isError('preview')}">
                    ></uploader>

                    <span class="invalid-feedback" role="alert" v-if="isError('preview')">
                        <strong>{{ getError('preview') }}</strong>
                    </span>
                </div>

                <button class="btn btn-large btn-yellow" @click="onSubmit"><span>{{ !this.article ? 'Добавить' : 'Обновить' }}</span></button>
            </form>
        </div>
    </div>
</template>

<script>
    import { VueEditor } from "vue2-editor";
    import CategoriesComponent from "./Blog/CategoriesComponent";
    import Uploader from "../../../helpers/Common/Uploader/Uploader";

    export default {
        props: ['article', 'company', 'categoriesList'],

        data() {
            return {
                title: this.article ? this.article.title : '',
                content: this.article ? this.article.content : '',
                categories: this.article ? this.article.categories.map(category => category.id) : [],
                preview: this.article ? `/storage/${this.article.image}` : '',
                files: [],
            }
        },

        computed: {
            file() {
                if(this.files.length > 0) {
                    return this.files[0];
                }
                return null;
            },
            filesList() {
                return this.article && this.article.image ? [{url: `/storage/${this.article.image}`}] : []
            },
        },

        created() {
            if(this.article && this.article.image) {
                this.files.push({url: `/storage/${this.article.image}`})
            }
        },

        methods: {
            onSuccess(data) {
                console.log(data);
            },
            onSubmit() {
                this.clearErrorsBag();

                if(this.title.length === 0) {
                    this.addError('title', 'Не заполнено поле "Заголовок".');
                }
                if(this.content.length === 0) {
                    this.addError('content', 'Не заполнено поле "Статья".');
                }
                if(this.categories.length === 0) {
                    this.addError('categories', 'Не выбраны категории для статьи.');
                }

                if(!this.isValid()) {
                    this.setCommonError('Не заполнены обязательные поля.', 2000);

                    return false;
                }

                this.clearBag();

                let data = new FormData();
                data.append('title', this.title);
                data.append('content', this.content);
                this.categories.map(category => {
                    data.append('categories[]', category);
                });
                data.append('preview', this.file && this.file.blob ? this.file.blob : '');

                let url = '';
                if(this.article) {
                    url = this.route('api.company.article.update', {company: this.company.slug, article: this.article.slug});
                } else {
                    url = this.route('api.company.article.create', {company: this.company.slug});
                }

                axios.post(url, data, {
                    header: {'Content-Type' : 'multipart/form-data'}
                })
                    .then(res => {
                        let data = res.data;

                        if(data.success) {
                            this.setCommonMessage('Статья успешно добавлена.');
                            return window.location.href = this.route('company.article.show', {company: this.company.slug, article: data.data.slug});
                        }

                        this.setCommonError(res.data.error);
                    })
                    .catch(err => {
                        let error = err.message;
                        if(err.response.status === 422) {
                            let data = err.response.data;
                            error = data.message;

                            for(let key in data.errors) {
                                this.addError(key, data.errors[key][0]);
                            }
                            this.$forceUpdate();
                        }
                        this.setCommonError(error);
                    })
            }
        },

        components: {VueEditor, CategoriesComponent, Uploader}
    }
</script>

<style scoped>

</style>
