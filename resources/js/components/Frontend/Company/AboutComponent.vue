<template>
    <div class="row registration-part">
        <div class="col questionnaire-outer">
            <div class="questionnaire">
                <form @submit.prevent method="POST">
                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="name">Название</label>
                            <input name="name" id="name" placeholder="Название компании" class="" v-model="name">
                        </div>
                    </div>

                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="description">Описание</label>
                            <textarea name="description" id="description" placeholder="Описание компании" class="" v-model="description"></textarea>
                        </div>
                    </div>

                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="workers_count">К-во работников</label>
                            <input name="workers_count" type="number" id="workers_count" placeholder="К-во работников в компании" class="" v-model="workers_count">
                        </div>
                    </div>

                    <div class="questionnaire-inner-container">
                        <div class="photo-input">
                            <div class="photo-input-avatar">
                                <img v-if="logo" class="image_upload_preview avatar" :src="'/storage/' + logo">
                                <div class="photo-input-avatar" v-else>
                                    <img src="/images/userpic.svg" class="image_upload_preview">
                                </div>
                            </div>

                            <avatar-cropper
                                trigger="#pick-logo"
                                :labels="{submit: 'Подтвердить', cancel: 'Отменить'}"
                                :upload-url="route('api.company.about.logo_update', {company: company.slug})"
                                :uploadHeaders="{'X-CSRF-TOKEN': csrfToken}"

                                uploadFormName="logo"
                                @uploaded="onUploaded"
                            />

                            <div class="photo-input-control">
                                <div class="text">Добавьте реальный логотип вашей компании.</div>
                                <label class="btn btn-small btn-white" id="pick-logo">
                                    Загрузить логотип
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="questionnaire-inner-container">
                        <img :src="'/storage/' + cover" width="400" v-if="cover">

                        <div class="photo-input">
                            <image-uploader
                                :debug="1"
                                :autoRotate=true
                                outputFormat="verbose"
                                :preview=false
                                :className="['fileinput', { 'fileinput--loaded' : cover }]"
                                capture="environment"
                                accept="video/*,image/*"
                                doNotResize="['gif', 'svg']"
                                @input="setImage"
                                ref="imageUploader"
                            >
                            </image-uploader>
                        </div>
                    </div>

                    <div class="questionnaire-inner-container">
                        <div class="photo-input">
                            <div class="photo-input-control">
                                <label class="btn btn-small btn-white" id="pick-crop" for="fileInput">
                                    Загрузить фоновую картинку
                                </label>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-large btn-yellow" @click="onSubmit"><span>Обновить</span></button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import AvatarCropper from "vue-avatar-cropper";
    import ImageUploader from "vue-image-upload-resize";

    export default {
        props: ['company'],

        data() {
            return {
                name: this.company ? this.company.name : '',
                description: this.company ? this.company.description : '',
                workers_count: this.company ? this.company.workers_count : '',

                logo: this.company ? this.company.logo : '',
                cover: this.company ? this.company.cover : '',
            }
        },

        methods: {
            setImage(output) {
                let file = this.$refs['imageUploader'].currentFile;

                let data = new FormData();
                data.append('image', file);

                axios.post(this.route('api.company.about.cover_update', {company: this.company.slug}), data)
                    .then(res => {
                        this.cover = res.data.data.url;
                        console.log(res)
                    })
                    .catch(err => {
                        console.log(err)
                        this.setCommonError(err.response.data.message || err.response.data.error);
                    })
            },
            onUploaded(resp) {
                if(!resp || !resp.success) {
                    this.setCommonError('Ошибка загрузки аватара', 2000);
                    return;
                }
                this.logo = resp.data.relative_url;
            },
            onSubmit() {
                axios.put(this.route('api.company.about', {company: this.company.slug}), {
                    name: this.name, description: this.description, workers_count: this.workers_count
                })
                    .then(res => {
                        if(res.data.success) {
                            this.setCommonMessage('Данные успешно обновлены.');
                            window.location.href = this.route('company.show', this.company.slug);
                            return;
                        }
                        this.setCommonError('Ошибка обновления данных.');
                    })
                    .catch(err => {
                        this.setCommonError('Ошибка обновления данных.');
                    })
            },
        },

        components: {AvatarCropper, ImageUploader}
    }
</script>

<style>
    #fileInput {
        display: none;
    }
    .img-preview {
        display: block;
        width: 100%;
    }
</style>
