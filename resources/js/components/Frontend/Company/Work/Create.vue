<template>
    <div class="personal-content-inner">
        <div class="alert alert-success" v-if="hasCommonMessage">
            {{ getCommonMessage }}
        </div>
        <div class="alert alert-danger" v-if="hasCommonError">
            {{ getCommonError }}
        </div>

        <div class="main-title">Создать альбом</div>
        <div class="form-wrap">
            <p class="text">Компания с галереей получает в среднем в 3-5 раз больше откликов. Загружайте только реальные фото своих работ.</p>
        </div>
        <form class="create-album-form" @submit.prevent="onSubmit">
            <div class="form-wrap">
                <div class="form-group">
                    <label for="title">Название</label>
                    <input type="text" v-model="title" id="title" placeholder="Укажите название альбома" :class="{ 'is-invalid': isError('title') }">

                    <span class="invalid-feedback" role="alert" v-if="isError('title')">
                        <strong>{{ getError('title') }}</strong>
                    </span>
                </div>
            </div>
            <div class="form-wrap">
                <div class="form-group">
                    <label for="album-discription">Описание</label>
                    <textarea name="discription" id="album-discription" placeholder="Краткое описание" :class="{ 'is-invalid': isError('description') }" v-model="description" />

                    <span class="invalid-feedback" role="alert" v-if="isError('description')">
                        <strong>{{ getError('description') }}</strong>
                    </span>
                </div>
            </div>

            <div class="form-wrap">
                <div class="form-group">
                    <label for="title">Цена</label>
                    <input type="number" v-model="price" id="price" placeholder="Цена" :class="{ 'is-invalid': isError('price') }">

                    <span class="invalid-feedback" role="alert" v-if="isError('price')">
                        <strong>{{ getError('price') }}</strong>
                    </span>
                </div>
            </div>

            <div class="form-wrap">
                <div class="form-group-select">
                    <label for="title">Длительность</label>

                    <div class="select">
                        <select name="duration_type" id="duration_type" v-model="duration_type" :class="{ 'is-invalid': isError('duration_type') }">
                            <option></option>
                            <option v-for="(name, type) in types" :value="type">{{ name }}</option>
                        </select>
                    </div>

                    <span class="invalid-feedback" role="alert" v-if="isError('duration_type')">
                        <strong>{{ getError('duration_type') }}</strong>
                    </span>
                </div>
            </div>

            <div class="form-wrap" v-if="duration_type">
                <div class="form-group">
                    <label for="title">{{ durationType }}</label>
                    <input type="text" v-model="duration" id="duration" placeholder="Длительность" :class="{ 'is-invalid': isError('price') }">

                    <span class="invalid-feedback" role="alert" v-if="isError('price')">
                        <strong>{{ getError('price') }}</strong>
                    </span>
                </div>
            </div>

            <div class="form-wrap">
                <p class="text">Объявления с фото получают в среднем в 3-5 раз больше откликов </p>
                <p class="text">Максимальный размер файла 5 МБ, формат .jpg, .jpeg, .png.</p>
            </div>
            <div class="form-wrap">
                <div class="task-photo-component">
                    <div class="label">Добавьте фото</div>
                </div>

                <uploader
                    v-model="photos"
                    :url="route('api.company.album.photo.upload', {company: company.slug})"
                    title=""
                    @on-success="onSuccess"
                    :params="{_token: csrfToken}"
                />

                <span class="invalid-feedback" role="alert" v-if="isError('photos')">
                    <strong>{{ getError('photos') }}</strong>
                </span>
            </div>

            <!-- Реальные видео-->
            <upload-videos-component @change="onVideosChange" :init-videos="validVideos" />

            <div class="form-wrap">
                <button class="btn btn-big btn-yellow" @click.prevent="onSubmit">Сохранить</button>
                <button class="btn btn-big btn-grey" @click.prevent="onCancel">Отмена</button>
            </div>
        </form>
    </div>
</template>

<script>
    import Uploader from "../../../../helpers/Common/Uploader";
    import UploadVideosComponent from "../../Advert/Advert/UploadVideosComponent";
    import {capitalize} from "../../../../helpers/Common/Str/StrHelpers";

    export default {
        props: ['company', 'album', 'types'],

        data() {
            return {
                title: this.album ? this.album.title : '',
                description: this.album ? this.album.description : '',
                duration_type: this.album ? this.album.duration_type : '',
                price: this.album ? this.album.price : '',
                duration: this.album ? this.album.duration : '',
                photos: [],
                videos: []
            }
        },

        computed: {
            validPhotos() {
                return this.photos.map(el => el.id);
            },
            durationType() {
                return this.duration_type ? capitalize(this.types[this.duration_type]) : ''
            },
            validVideos() {
                return this.album ? this.album.videos.map(video => video.url) : []
            }
        },

        methods: {
            onVideosChange(videos) {
                this.videos = videos;
            },
            onSuccess(e, file) {
                file.id = e.id;
            },
            onSubmit() {
                this.clearErrorsBag();

                if(this.title.length === 0) {
                    this.addError('title', 'Не заполнен заголовок.');
                }
                if(this.description.length === 0) {
                    this.addError('description', 'Не заполнено описание.');
                }
                if(!this.validPhotos || this.validPhotos.length === 0) {
                    this.addError('photos', 'Не добавлено ни одной фотографии.');
                }

                if(!this.isValid()) {
                    this.setCommonError('Не заполнены обязательные поля.', 2000);

                    return false;
                }

                this.clearBag();

                let url = this.album
                    ? this.route('api.company.album.edit', {company: this.company.slug, album: this.album.id})
                    : this.route('api.company.album.create', {company: this.company.slug});

                axios.post(url, {
                    title: this.title,
                    description: this.description,
                    price: this.price,
                    duration: this.duration,
                    duration_type: this.duration_type,
                    photos: this.validPhotos,
                    videos: this.videos
                })
                    .then(res => {
                        if(res.data.success === true) {
                            this.setCommonMessage('Альбом успешно сохранён.');

                            setTimeout(() => {window.location.href = this.route('company.albums', {company: this.company.slug})}, 500);
                            return;
                        }

                        this.setCommonError('Ошибка при сохранении альбома. Повторите ещё раз.')
                    })
                    .catch(err => {
                        let data = err.response.data;

                        this.setCommonError(data.message);
                        for(let key in data.errors) {
                            this.addError(key, data.errors[key][0]);
                        }
                    })
            },
            onCancel() {
                window.history.back();
            },
        },

        created() {
            if(this.album) {
                this.photos = this.album.photos.map(image => {
                    return {url: `/storage/${image.path}`, id: image.id};
                });

                this.videos = this.album.videos.map(video => video.url)
            }
        },

        components: {
            UploadVideosComponent,
            Uploader
        }
    }
</script>

<style scoped>

</style>
