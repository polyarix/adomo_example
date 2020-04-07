<template>
    <div :class="{ 'adv-card': true, 'task-premium': isPremiumAdvert }">
        <div class="adv-card-img">
            <img :src="preview" alt="">
        </div>

        <a class="adv-card-name" :href="routeName ? route(routeName, advert.slug) : route('advert.task.show', advert.slug)">{{ advert.title }}</a>
        <div class="adv-card-disc">{{ advert.description }}</div>
        <div class="adv-card-info">
            <a class="adv-card-info-who" :href="route('user.details', {id: advert.author.id})" target="_blank">{{ authorName }}</a>

            <div class="adv-card-info-date">
                <div class="date-icon" style="background-image:url(/images/clock-icon.svg)"></div><span>{{ date }}</span>
            </div>
            <div class="adv-card-info-city" v-if="city">
                <div class="place-icon" style="background-image:url(/images/place-icon.svg)"></div><span>{{ districts }}</span>
            </div>
        </div>
        <div class="adv-card-tags">
            <a :href="route('category.tag', tag.slug)" v-for="tag in advert.tags">#{{ tag.name }}</a>
        </div>
        <a class="adv-card-price" :href="route('advert.task.show', advert.slug)">{{ price }}</a>
    </div>
</template>

<script>
    const PRICE_TYPE_SPECIFIC = 'specific'; // определённая
    const PRICE_TYPE_DISCUSS = 'discuss'; // договорная

    export default {
        props: ['advert', 'routeName'],

        computed: {
            districts() {
                if(!this.advert.city) {
                    return '';
                }
                let text = `Работаю в: г.${this.advert.city.name}`;
                let districts = this.advert.city.districts;

                if(!districts) {
                    return text
                }

                return `${text} (${(districts.map(district => district.name).join(', '))})`
            },
            isPremiumAdvert() {
                return !!this.advert.catched_up_at && this.$moment(this.advert.catched_up_to).diff(this.$moment.now()) > 0
            },
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
                return this.advert.city ? this.advert.city.name : this.advert.address.split(',')[0];
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
    .task-premium {
        color: #323232;
        border: 1px solid rgba(254, 198, 43, .5);
        background: rgba(254, 198, 43, 0.2);
    }
</style>
