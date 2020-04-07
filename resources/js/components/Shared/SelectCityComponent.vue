<template>
    <div class="modal modal-take-task" style="display: none;" id="select-city-modal">
        <div class="modal-title">Выберите свой город</div>
        <div class="modal-info-box">
            <p>Ваш текущий город: <a href="#">{{ city.name }}</a></p>
        </div>

        <form method="POST" :action="route('set_city')">
            <input type="hidden" name="_token" :value="csrfToken">
            <input type="hidden" name="city" :value="cityId">

            <div class="form-group-select">
                <vue-select label="name" :options="cities" v-model="city" :clearable="false"></vue-select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-small btn-grey" @click.prevent="onClose">Отмена</button>
                <button class="btn btn-small btn-yellow">Сохранить</button>
            </div>
        </form>
    </div>
</template>

<script>
    import VueSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';

    export default {
        props: ['cities', 'currentCity'],

        data() {
            return {
                city: ''
            }
        },

        computed: {
            cityId() {
                return this.city ? this.city.id : ''
            }
        },

        methods: {
            getOptionKey(val) {
                console.log(val);
                return 'id'
            },
            onClose() {
                $.fancybox.close( $('#select-city-modal'));
            }
        },

        created() {
            this.city = this.cities.filter(city => city.name === this.currentCity)[0];
        },

        components: {VueSelect}
    }
</script>

<style scoped>
    .form-group-select {
        margin: 10px 0;
    }
</style>
