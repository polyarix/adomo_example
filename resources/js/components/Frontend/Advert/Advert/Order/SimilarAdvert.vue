<template>
    <div class="task-card">
        <div class="task-card-inner">
            <a class="task-card-name" :href="route('advert.order.show', advert.slug)">{{ advert.title }}</a>

            <div class="task-card-info">
                <a class="task-card-info-who" :href="route('user.details', {id: advert.author.id})">{{ authorName }}</a>
                <div class="task-card-info-date" v-if="advert.beginning_date">
                    <div class="date-icon" style="background-image:url(/images/clock-icon.svg)"></div>
                    <span>{{ date }}</span>
                </div>

                <div class="task-card-info-city">
                    <div class="place-icon" style="background-image:url(/images/place-icon.svg)"></div><span>{{ city }}</span>
                </div>
            </div>
            <div class="task-card-absolute">
                <a class="task-card-price" :href="route('advert.order.show', advert.slug)">{{ price }}</a>
                <div class="task-card-status">{{ status }}</div>
            </div>
            <a class="btn btn-small btn-dark" :href="route('advert.order.show', advert.slug)">Посмотреть задание</a>
        </div>
    </div>
</template>

<script>
    const PRICE_TYPE_SPECIFIC = 'specific'; // определённая
    const PRICE_TYPE_DISCUSS = 'discuss'; // договорная

    import { normalize as normalizeStatus } from "../../../../../helpers/Advert/statusesHelper";

    export default {
        props: ['advert'],

        computed: {
            authorName() {
                return `${this.advert.author.first_name} ${this.advert.author.last_name}`
            },
            date() {
                return this.$moment(this.advert.created_at).format("D MMMM");
            },
            address() {
                return this.advert.address;
            },
            city() {
                return this.advert.address.split(',')[0];
            },
            preview() {
                return this.advert.preview;
            },
            price() {
                if(this.isPriceDiscuss) {
                    return 'Обсуждается'
                }

                return `${this.advert.price} Р`;
            },
            status() {
                return normalizeStatus(this.advert.status)
            },
            isPriceSpecific() {
                return this.advert.price_type === PRICE_TYPE_SPECIFIC
            },
            isPriceDiscuss() {
                return this.advert.price_type === PRICE_TYPE_DISCUSS
            }
        }
    }
</script>

<style scoped>

</style>
