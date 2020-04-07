<template>
    <div>
        <input type="text" name="address" v-model="address" placeholder="Address">

        <yandex-map
            :coords="mapCoords"
            zoom="12"
            style="width: 600px; height: 600px;"
            :cluster-options="clusterOptions"
            :settings="mapSettings"
            :controls="['fullscreenControl', 'zoomControl']"
            @click="onMapClick"
            ref="map"
        >
            <ymap-marker
                marker-id="1"
                :coords="coords"
                :hint-content="address"
                v-if="coords"
            ></ymap-marker>
        </yandex-map>
    </div>
</template>

<script>
    import { yandexMap, ymapMarker } from 'vue-yandex-maps';
    //import { yandexMap, ymapMarker } from './../../../../helpers/Common/Map/YandexMap';
    import config from "../config";
    import {debounce} from 'lodash';

    export default {
        data() {
            return {
                address: '',

                coords: [],
                mapCoords: [55.753215, 37.622504],
            }
        },

        computed: {
            mapSettings() {
                return config.map;
            },
            clusterOptions() {
                return {1: {clusterDisableClickZoom: true}}
            },
        },

        watch: {
            address: debounce(function(address) {
                ymaps.geocode(address, { results: 1 }).then(res => {
                    const firstGeoObject = res.geoObjects.get(0),
                        // Координаты геообъекта.
                        coords = firstGeoObject.geometry.getCoordinates(),
                        // Область видимости геообъекта.
                        bounds = firstGeoObject.properties.get('boundedBy');

                    this.coords = coords;
                    this.mapCoords = coords;

                    this.$emit('coordinates-changed', {
                        coords: this.coords,
                        address: this.address,
                    });

                    this.$refs.map.setBounds(bounds, {
                        checkZoomRange: true
                    });
                });
            }, 1000),
        },

        /*watch: {
            address: _.debounce(function() {
                this.addressLoading = true;

                ymaps.geocode(`Москва, ${this.address}`).then(res => {
                    let results = res.geoObjects.get(0)
                        .properties.get('metaDataProperty')
                        .GeocoderMetaData;

                    console.log(results);

                    this.addressLoading = false;
                });
            }, 1000)
        },*/

        methods: {
            onMapClick(e) {
                this.coords = e.get('coords');
                this.mapCoords = e.get('coords');

                ymaps.geocode(this.coords, { results: 1 }).then(res => {
                    const firstGeoObject = res.geoObjects.get(0),
                        // Координаты геообъекта.
                        coords = firstGeoObject.geometry.getCoordinates(),
                        // Область видимости геообъекта.
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
            yandexMap, ymapMarker
        }
    }
</script>

<style>

</style>
