<template>
    <div class="row registration-part">
        <div class="col questionnaire-outer">
            <div class="questionnaire">
                <div class="questionnaire-title">Рабочие данные</div>

                <form @submit.prevent method="POST">
                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="address">Адрес</label>
                            <textarea name="address" id="address" placeholder="Адрес компании" class="" v-model="address"></textarea>
                        </div>
                    </div>

                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="contacts">Связь</label>
                            <textarea name="contacts" id="contacts" placeholder="Связь" class="" v-model="contacts"></textarea>
                        </div>
                    </div>

                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="schedule">График работы</label>
                            <textarea name="schedule" id="schedule" placeholder="График работы" class="" v-model="schedule"></textarea>
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

                    <button class="btn btn-large btn-yellow" @click="onSubmit"><span>Обновить</span></button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import MapComponent from './../Advert/Advert/MapComponent'

    export default {
        props: ['company', 'contactsProp'],

        data() {
            return {
                coords: this.getMapCoords(),
                address: this.contactsProp ? this.contactsProp.address : '',
                contacts: this.contactsProp ? this.contactsProp.contacts : '',
                schedule: this.contactsProp ? this.contactsProp.schedule : '',
            }
        },

        computed: {
            centerCoords() {
                if(this.coords && this.coords.length > 0) {
                    return this.coords
                }
                /// return default center, Moscow probably
                return [55.753215, 37.622504];
            }
        },

        methods: {
            onCoordinatesChange(payload) {
                this.coords = payload.coords;
            },
            onSubmit() {
                axios.put(this.route('api.company.contacts', {company: this.company.slug}), {
                    coords: this.coords, address: this.address, contacts: this.contacts, schedule: this.schedule
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
            getMapCoords() {
                let coords = [];
                if(this.contactsProp && this.contactsProp.map_lat && this.contactsProp.map_long) {
                    coords = [this.contactsProp.map_lat, this.contactsProp.map_long];
                }

                return coords;
            }
        },

        components: {MapComponent}
    }
</script>

<style scoped>

</style>
