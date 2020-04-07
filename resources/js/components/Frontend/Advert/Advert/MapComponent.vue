<template>
    <div>
        <div class="task-form-wrap wrap-auto">
            <div class="label">Карта с геолокацией</div>

            <span class="invalid-feedback" role="alert" v-if="addressError" style="font-size: 1em;"><strong>Заполните адрес</strong></span>

            <div class="task-map-component">
                <span class="invalid-feedback" role="alert" v-if="mapError">
                    <strong>Укажите адрес на карте</strong>
                </span>

                <yandex-map
                    :coords="mapCoords"
                    zoom="12"
                    style="width: 100%; height: 100%;"
                    :cluster-options="clusterOptions"
                    :settings="mapSettings"
                    :controls="['fullscreenControl', 'zoomControl']"
                    @click="onMapClick"
                    @map-was-initialized="onMapInit"
                    ref="map"
                >
                    <ymap-marker
                        marker-id="1"
                        :coords="coords"
                        :hint-content="address"
                        v-if="hasCoords"
                        :icon="{
                            layout: 'default#image',
                            imageHref: '/images/map-place.svg'
                        }"
                    ></ymap-marker>
                </yandex-map>
            </div>
        </div>

        <district-component
            v-if="districtSelectEnabled"
            :cities="cities"
            :init-city="city.id"
            :init-district="districtProp"
            @changeDistrict="$emit('changeDistrict', $event)"
            :key="city.id"
        />

        <div class="task-form-wrap" v-if="displayAddressInput">
            <div class="form-group" v-if="address">
                <div class="loader" v-if="addressLoading"><img src="/images/ajax-loader.gif" alt=""></div>

                <label>Итоговый адрес</label>
                <p>{{ address }}</p>
            </div>

            <div class="form-group">
                <label for="address">Комментарий к адресу</label>
                <input type="text" id="address" v-model="comment" placeholder="Комментарий">
            </div>
        </div>
    </div>
</template>

<script>
    import { yandexMap, ymapMarker } from 'vue-yandex-maps';
    import config from './../../../../config';
    import {debounce} from 'lodash';
    import DistrictComponent from "./Partials/DistrictComponent";

    export default {
        props: {
            addressError: {
                type: Boolean,
            },
            displayAddressInput: {
                type: Boolean,
                default: true,
            },
            mapError: {type: Boolean},
            cities: {type: Array, default: () => []},
            districtSelectEnabled: {type: Boolean, default: false},
            addressProp: {type: String},
            districtProp: {type: Number, required: false},
            initDistrict: {type: Number, required: false},
            commentProp: {type: String},
            city: {type: Object},
            coordsProp: {
                type: Array,
                default: () => []
            },
            mapCoordsProp: {
                type: Array,
                default: () => [55.753215, 37.622504]
            }
        },

        data() {
            return {
                address: this.addressProp,

                addressLoading: false,

                coords: this.coordsProp,
                mapCoords: this.mapCoordsProp,
                comment: this.commentProp
            }
        },

        computed: {
            hasCoords() {
                return this.coords && this.coords.length > 0
            },
            mapSettings() {
                return config.map;
            },
            clusterOptions() {
                return {1: {clusterDisableClickZoom: true}}
            },
        },

        watch: {
            city() {
                this.mapCoords = [parseFloat(this.city.map_lat), parseFloat(this.city.map_long)]
                this.$refs.map.myMap.container.fitToViewport()
            },
            address() {
                this.$emit('coordinates-changed', {
                    coords: this.coords,
                    address: this.address,
                });
            },
            comment() {
                this.$emit('comment-changed', this.comment)
            }
        },

        methods: {
            onMapInit(map) {
                let search = this.$refs.map.myMap.controls.add('searchControl', {
                    float: 'left',
                    noPlacemark: true,
                    placeholderContent: 'Для поиска начните вводить адрес',
                    position: {left: 10, top: 10},
                });

                search.events
                    .add('resultselect', (e) => {
                        /*this.$refs.map.myMap.geoObjects.each(item => {
                            this.$refs.map.myMap.geoObjects.remove(item);
                            console.log(item)
                        });*/

                        let result = e.get('target').getResultsArray()[e.get('index')];
                        let coords = result.geometry.getCoordinates();
                        this.coords = [coords[0], coords[1]];

                        this.address = result.getAddressLine().split(', ').slice(1).join(', ');

                        //city = this.address.split(', ')[0];

                        e.preventDefault();
                    })
                    .add('resultshow', (e) => {
                        this.$refs.map.myMap.geoObjects.each(item => {
                            this.$refs.map.myMap.geoObjects.remove(item);
                        });

                        e.preventDefault();
                    })
            },
            onMapClick(e) {
                this.coords = e.get('coords');
                this.mapCoords = e.get('coords');

                ymaps.geocode(this.coords, { results: 1 }).then(res => {
                    const firstGeoObject = res.geoObjects.get(0),
                        coords = firstGeoObject.geometry.getCoordinates(),
                        bounds = firstGeoObject.properties.get('boundedBy');

                    this.address = firstGeoObject.getAddressLine().split(', ').slice(1).join(', ');

                    this.$emit('coordinates-changed', {
                        coords: this.coords,
                        address: this.address,
                    });

                    this.$refs.map.setBounds(bounds, {
                        checkZoomRange: true
                    });
                });
            }
        },

        components: {
            DistrictComponent,
            yandexMap, ymapMarker
        }
    }
</script>

<style>
    [class$="-searchbox__input-cell"] {

    }
    /*search input*/
    [class$="-searchbox-input__input"] {
        height: 35px !important;
    }
    /*search button*/
    [class$="-searchbox__button-cell"] {
        height: 100% !important;
    }
    [class$="-searchbox-button"] {
        height: 35px !important;
    }
    [class$="-searchbox-button"] {
        height: 100% !important;
    }
    .ymaps-2-1-75-searchbox__button-cell * {
        height: 35px !important;
        font-size: 17px;
        line-height: 2em;
    }
</style>
