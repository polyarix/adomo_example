<template>
    <div class="personal-content-inner lk-services-create">
        <div class="main-title">Новая услуга</div>

        <div class="alert alert-success" v-if="hasCommonMessage">
            {{ getCommonMessage }}
        </div>
        <div class="alert alert-danger" v-if="hasCommonError">
            {{ getCommonError }}
        </div>

        <div class="text">Необходимо правильно указать категорию, название объявления и <br>детальное описание, после чего загрузить изображения и указать цену.</div>
        <form action="">
            <!-- Категория-->
            <span class="invalid-feedback" role="alert" v-if="isError('categories')">
                <strong>{{ getError('categories') }}</strong>
            </span>

            <input-category
                :categories-list="categoriesList"
                :categories-selected="validSelectedCategories"
                :show-error="isError('categories')"
                v-for="(category, index) in selectedCategories"
                @categoryPick="onCategoryPick(index, $event)"
                :key="index"
            />

            <button class="btn btn-big btn-dark btn-add-new-category" @click.prevent="onCategoryAdd">Добавить еще категорию</button>
            <!-- Заголовок-->
            <div class="questionnaire-inner-container">
                <div class="form-group">
                    <label for="service-name">Заголовок</label>
                    <input type="text" id="service-name" placeholder="Название услуги" :class="{ 'is-invalid': isError('title') }" v-model="title">

                    <span class="invalid-feedback" role="alert" v-if="isError('title')">
                        <strong>{{ getError('title') }}</strong>
                    </span>
                </div>
            </div>

            <!-- Детальное описание-->
            <div class="questionnaire-inner-container">
                <div class="form-group">
                    <label for="service-discription">Детальное описание</label>
                    <textarea name="" id="service-discription" placeholder="Опишите предоставляемую услугу" :class="{ 'is-invalid': isError('description') }" v-model="description"></textarea>

                    <span class="invalid-feedback" role="alert" v-if="isError('description')">
                        <strong>{{ getError('description') }}</strong>
                    </span>
                </div>
                <div class="form-input-description text offset-top">При заполнении поля, обязательно укажите важные детали: какие работы выполняете, профессиональный опыт, где готовы выполнять работу, наличие инвентаря/инструмента/автомобиля, наличие сертификатов/наград, гарантию на предоставленную работу.</div>
            </div>

            <!-- Город-->
            <city-component :cities="cities" :init-city="city" @changeCity="city = $event" @changeDistricts="selectedDistricts = $event" />

            <!-- Реальные фотографии-->
            <div class="task-form-wrap">
                <div class="task-photo-component">
                    <div class="label">Реальные фотографии</div>
                </div>
                <uploader
                    v-model="photos"
                    :url="route('api.advert.photo.upload')"
                    title=""
                    :limit="10"
                    @on-success="onSuccess"
                    :params="{_token: csrfToken}"
                />
            </div>

            <tags-component :categories="validSelectedCategories" @change="onTagsChange" />

            <!-- Реальные фотографии-->
            <upload-videos-component @change="onVideosChange" />

            <!-- Укажите тип цены-->
            <div class="task-form-wrap">
                <div class="task-price-component">
                    <div class="form-group-radio">
                        <div class="form-group-name">Укажите тип цены</div>

                        <span class="invalid-feedback" role="alert" v-if="isError('price_type')">
                            <strong>{{ getError('price_type') }}</strong>
                        </span>

                        <div class="radio">
                            <input id="price-static" name="price" type="radio" v-model="price_type" value="specific"/>
                            <label class="radio-label" for="price-static">Цена</label>
                            <input :class="{ 'task-price-input': true, 'is-invalid': isError('price_type') }" placeholder="Цена (руб.)" v-model="price"/>
                        </div>
                        <div class="radio">
                            <input id="price-contract" name="price" type="radio" v-model="price_type" value="discuss"/>
                            <label class="radio-label" for="price-contract">Договорная</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- кнопки-->
            <div class="form-wrap">
                <button class="btn btn-big btn-yellow" @click.prevent="onPublish">Опубликовать</button>
                <button class="btn btn-big btn-grey" @click.prevent="onCancel">Отмена</button>
            </div>
        </form>

        <div class="modal modal-message" style="display: none;" id="moderation-modal">
            <div class="modal-message-inner">
                <div class="modal-message-icon"><img src="/images/moderate-icon.svg" alt=""/></div>
                <div class="modal-message-text">
                    <div class="modal-title">Услуга на модерации</div>
                    <p>Она будет доступна после проверки администратором </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import InputCategory from "./InputCategory";
    import Uploader from "../../../../../../helpers/Common/Uploader";
    import UploadVideosComponent from "../../../../Advert/Advert/UploadVideosComponent";
    import TagsComponent from "../../../../../Shared/Advert/TagsComponent";
    import CityComponent from "../../../../../Shared/Advert/CityComponent";

    export default {
        props: ['user', 'categoriesList', 'cities'],

        data() {
            return {
                selectedCategories: [''],
                title: '',
                description: '',
                photos: [],
                selectedDistricts: [],
                videos: [],
                tags: [],
                price: '',
                price_type: 'discuss',
                city: ''
            }
        },

        computed: {
            validSelectedCategories() {
                return this.selectedCategories.filter(el => parseInt(el) > 0);
            },
            validPhotos() {
                return this.photos.map(el => el.id);
            },
            csrfToken() {
                return $('meta[name="csrf-token"]').attr('content')
            }
        },

        created() {
            this.city = window.city.id
        },

        methods: {
            onTagsChange(data) {
                console.log(data);
                this.tags = data;
            },
            onCategoryPick(index, category) {
                this.$set(this.selectedCategories, index, category);
            },
            onCategoryAdd() {
                if(this.validSelectedCategories.length < this.selectedCategories.length) {
                    return;
                }

                this.selectedCategories.push('');
            },
            onVideosChange(videos) {
                this.videos = videos;
            },
            onSuccess(e, file) {
                file.id = e.id;
            },
            onCancel() {
                window.history.back();
            },
            onPublish() {
                this.clearErrorsBag();

                if(this.validSelectedCategories.length === 0) {
                    this.addError('categories', 'Не выбрано ни одной категории.');
                }
                if(this.title.length === 0) {
                    this.addError('title', 'Не заполнен заголовок.');
                }
                if(this.description.length === 0) {
                    this.addError('description', 'Не заполнено описание.');
                }
                if(this.description.length === 0) {
                    this.addError('description', 'Не заполнено описание.');
                }
                if(this.price_type.length === 0 || (this.price_type !== 'discuss' && this.price.length === 0)) {
                    this.addError('price_type', 'Не заполнена цена.');
                }
                if(!this.city) {
                    this.addError('city', 'Город не заполнен');
                }

                if(!this.isValid()) {
                    this.setCommonError('Не заполнены обязательные поля.', 2000);

                    return false;
                }

                this.clearBag();

                axios.post(this.route('api.user.cabinet.services.store'), {
                    categories: this.validSelectedCategories,
                    title: this.title,
                    description: this.description,
                    price_type: this.price_type,
                    price: this.price,
                    photos: this.validPhotos,
                    videos: this.videos,
                    tags: this.tags,
                    city: this.city,
                    districts: this.selectedDistricts,
                })
                    .then(res => {
                        if(res.data.success === true) {
                            $.fancybox.open($("#moderation-modal"));

                            setTimeout(() => {window.location.href = this.route('cabinet.services.index')}, 1000);
                            return;
                        }

                        this.setCommonError('Ошибка при сохранении услуги. Повторите ещё раз.')
                    })
                    .catch(err => {
                        let data = err.response.data;

                        this.setCommonError(data.message);
                        for(let key in data.errors) {
                            this.addError(key, data.errors[key][0]);
                        }
                    })
            },
        },
        components: {TagsComponent, InputCategory, Uploader, UploadVideosComponent, CityComponent},
    }
</script>

<style scoped>
    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>
