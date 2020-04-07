<template>
    <div class="task-form-wrap wrap-auto">
        <div class="task-map-component">
            <yandex-map
                :coords="coords"
                zoom="13"
                style="width: 100%; height: 275px;"
                :settings="mapSettings"
                :controls="['fullscreenControl', 'zoomControl']"
                @map-was-initialized="onInit"
                ref="map"
            >
                <ymap-marker
                    v-if="allowed"
                    marker-id="1"
                    :coords="coords"
                    :hint-content="address"
                    :icon="{
                        layout: 'default#image',
                        imageHref: '/images/map-place.svg'
                    }"
                ></ymap-marker>
            </yandex-map>
        </div>
    </div>
</template>

<script>
    import { yandexMap, ymapMarker } from 'vue-yandex-maps';
    import config from '../../../../../config';

    export default {
        props: ['coords', 'address', 'allowed', 'radius'],

        computed: {
            mapSettings() {
                return config.map;
            },
        },

        methods: {
            onInit(map) {
                if(this.allowed) {
                    return;
                }

                // Радиус круга в метрах.
                var myCircle = new ymaps.Circle([this.coords, this.radius], {
                    balloonContent: this.address,
                    hintContent: this.address
                }, {
                    fillColor: "#DB709377",
                    // Цвет обводки.
                    strokeColor: "#990066",
                    // Прозрачность обводки.
                    strokeOpacity: 0.8,
                    // Ширина обводки в пикселях.
                    strokeWidth: 3
                });

                // Добавляем круг на карту.
                map.geoObjects.add(myCircle);
            },
        },

        components: {
            yandexMap, ymapMarker
        },
    }
</script>

<style scoped>

</style>
