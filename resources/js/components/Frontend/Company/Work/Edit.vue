<template>
    <div class="personal-content-inner">
        <div class="alert alert-success" v-if="hasCommonMessage">
            {{ getCommonMessage }}
        </div>
        <div class="alert alert-danger" v-if="hasCommonError">
            {{ getCommonError }}
        </div>

        <div class="main-title">Изменить альбом</div>
        <div class="form-wrap">
            <p class="text">Профиль с галереей получает в среднем в 3-5 раз больше откликов. Загружайте только реальные фото своих работ.</p>
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
                    <label for="album-discription">Описание  </label>
                    <textarea name="discription" id="album-discription" placeholder="Краткое описание" :class="{ 'is-invalid': isError('description') }" v-model="description" />

                    <span class="invalid-feedback" role="alert" v-if="isError('description')">
                        <strong>{{ getError('description') }}</strong>
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
                    :files="photos"
                    :url="route('api.user.cabinet.portfolio.photo.upload')"
                    title=""
                    :limit="30"
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
    import Uploader from "../../../../../helpers/Common/Uploader/Uploader";
    import UploadVideosComponent from "../../../Advert/Advert/UploadVideosComponent";

    export default {
        props: ['album'],

        data() {
            return {
                title: this.album.title,
                description: this.album.description,
                photos: [],
                videos: []
            }
        },

        computed: {
            validPhotos() {
                return this.photos.map(el => el.id);
            },
            validVideos() {
                return this.album.videos.map(video => video.url)
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

                axios.put(this.route('api.user.cabinet.portfolio.update', this.album.id), {
                    title: this.title,
                    description: this.description,
                    photos: this.validPhotos,
                    videos: this.videos
                })
                    .then(res => {
                        if(res.data.success === true) {
                            this.setCommonMessage('Альбом успешно добавлен.');

                            setTimeout(() => {window.location.href = this.route('cabinet.portfolio.index')}, 500);
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
            this.photos = this.album.photos.map(image => {
                return {url: `/storage/${image.path}`, id: image.id};
            });

            this.videos = this.album.videos
        },

        components: {
            UploadVideosComponent,
            Uploader
        }
    }
</script>

<style scoped>

</style>
