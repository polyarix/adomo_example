<template>
<div>
    <div>
        <div class="questionnaire-inner-container">
            <div class="form-group">
                <label for="address">Адрес</label>
                <textarea name="address" id="address" placeholder="Адрес компании" class="" v-model="address" :class="{ 'form-control': true, 'is-invalid': hasError('address') }"></textarea>

                <span class="invalid-feedback" role="alert" v-if="hasError('address')">
                    <strong>{{ getError('address') }}</strong>
                </span>
            </div>
        </div>

        <div class="questionnaire-inner-container">
            <div class="form-group">
                <label for="contacts">Связь</label>
                <textarea name="contacts" id="contacts" placeholder="Связь" class="" v-model="contacts" :class="{ 'form-control': true, 'is-invalid': hasError('contacts') }"></textarea>

                <span class="invalid-feedback" role="alert" v-if="hasError('contacts')">
                    <strong>{{ getError('contacts') }}</strong>
                </span>
            </div>
        </div>

        <div class="questionnaire-inner-container">
            <div class="form-group">
                <label for="schedule">График работы</label>
                <textarea name="schedule" id="schedule" placeholder="График работы" class="" v-model="schedule" :class="{ 'form-control': true, 'is-invalid': hasError('schedule') }"></textarea>

                <span class="invalid-feedback" role="alert" v-if="hasError('schedule')">
                    <strong>{{ getError('schedule') }}</strong>
                </span>
            </div>
        </div>

        <div class="questionnaire-inner-container">
            <div class="form-group">
                <map-component
                    :map-error="isError('coordinates')"
                    @coordinates-changed="onCoordinatesChange"
                    :coords-prop="coords"
                    :map-coords-prop="centerCoords"
                    :display-address-input="false"
                />
            </div>
        </div>
    </div>

    <button class="btn btn-large btn-yellow" @click.prevent="onNextStep"><span>Следующий шаг </span></button>
</div>
</template>

<script>
    import AvatarCropper from "vue-avatar-cropper";
    import ImageUploader from "vue-image-upload-resize";
    import MapComponent from './../../Advert/Advert/MapComponent'

    export default {
        data() {
            return {
                coords: [],
                address: '',
                contacts: '',
                schedule: '',
            }
        },

        computed: {
            centerCoords() {
                /// return default center, Moscow probably
                return [55.753215, 37.622504];
            }
        },

        methods: {
            onCoordinatesChange(payload) {
                this.coords = payload.coords;
            },
            onNextStep() {
                // validate the data
                this.clearErrorsBag();
                if(this.address.length <= 3) {
                    this.addError('address', 'Заполните адрес.');
                }
                if(!this.isValid()) {
                    this.setCommonError('Заполните обязательные поля.');
                    return false;
                }

                this.$emit('next-step', this.$data)
            },
        },

        components: {AvatarCropper, ImageUploader, MapComponent}
    }
</script>

<style scoped>

</style>
