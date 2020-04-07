<template>
<div>
    <div class="questionnaire-inner-container">
        <div class="form-group">
            <label for="name">Название</label>
            <input name="name" id="name" placeholder="Название компании" class="" v-model="name" :class="{ 'form-control': true, 'is-invalid': hasError('name') }">

            <span class="invalid-feedback" role="alert" v-if="hasError('name')">
                <strong>{{ getError('name') }}</strong>
            </span>
        </div>
    </div>

    <div class="questionnaire-inner-container">
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea name="description" id="description" placeholder="Описание компании" class="" v-model="description" :class="{ 'form-control': true, 'is-invalid': hasError('description') }"></textarea>

            <span class="invalid-feedback" role="alert" v-if="hasError('description')">
                <strong>{{ getError('description') }}</strong>
            </span>
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
                :upload-url="route('api.companies.upload_logo')"
                :uploadHeaders="{'X-CSRF-TOKEN': csrfToken}"
                uploadFormName="logo"
                @uploaded="onUploaded"
            />

            <div class="photo-input-control">
                <div class="text">Добавьте реальный логотип вашей компании.</div>
                <label class="btn btn-small btn-white" id="pick-logo" :class="{ 'form-control': true, 'is-invalid': hasError('logo') }">
                    Загрузить логотип
                </label>

                <span class="invalid-feedback" role="alert" v-if="hasError('logo')">
                    <strong>{{ getError('logo') }}</strong>
                </span>
            </div>
        </div>
    </div>

    <!-- submit-->
    <button class="btn btn-large btn-yellow" @click.prevent="onNextStep"><span>Следующий шаг </span></button>
</div>
</template>

<script>
    import AvatarCropper from "vue-avatar-cropper";
    import ImageUploader from "vue-image-upload-resize";

    export default {
        data() {
            return {
                name: '',
                description: '',
                workers_count: '',
                logo: '',
            }
        },

        methods: {
            onNextStep() {
                // validate the data
                this.clearErrorsBag();
                if(this.name.length <= 3) {
                    this.addError('name', 'Название компании должно быть длиннее 3 символов.');
                }
                if(this.description.length <= 3) {
                    this.addError('description', 'Описание компании должно быть длиннее 3 символов.');
                }
                if(this.logo.length === 0) {
                    this.addError('logo', 'Загрузите логотип компании.');
                }

                if(!this.isValid()) {
                    this.setCommonError('Заполните обязательные поля.');
                    return false;
                }

                this.$emit('next-step', this.$data)
            },
            onUploaded(resp) {
                if(!resp || !resp.success) {
                    this.setCommonError('Ошибка загрузки аватара', 2000);
                    return;
                }
                this.logo = resp.data.relative_url;
            },
        },

        components: {AvatarCropper, ImageUploader}
    }
</script>

<style scoped>

</style>
