<template>
    <div class="order-card-footer">
        <button class="btn btn-big btn-yellow" @click="onCatchUp">Поднять в топ</button>

        <small style="display: block; font-size: 0.8em; margin-top: 10px;" v-if="hasActivePremium">
            В топе до:
            <b style="font-weight: bold">{{ catchUpDateTo }}</b>
        </small>

        <small style="display: block; font-size: 0.8em; margin-top: 10px;" v-if="hasCatchedUp">
            Последний раз было поднято:
            <b style="font-weight: bold">{{ catchUpDate }}</b>
        </small>

        <div class="modal modal-take-task" style="display: none;" id="pay-premium-modal">
            <div class="modal-title">Хотите поднять вашу услугу в топ?</div>
            <div class="modal-info-box">
                <p>Ваша услуга будет закреплена в верхней части выбранной категории услуги</p>
                <p style="margin: 10px 0"></p>
                <p>Стоимость одного поднятия в топ: <b style="font-weight: bold;">50 рублей</b></p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-small btn-grey" onclick="$.fancybox.close($('#pay-premium-modal'))">Отмена</button>
                <a :href="catchUpUrl" class="btn btn-small btn-yellow" target="_blank">Оплатить</a>
            </div>
        </div>
    </div>
</template>

<script>
    import {STATUS_ACTIVE} from "../../../../../constants";

    export default {
        props: ['order'],

        computed: {
            catchUpUrl() {
                // with params "id" it works incorrect

                return this.route('pay', {
                    type: 'catch_up',
                    entity: 'service',
                    redirect_to: route('advert.task.show', this.order.slug).toString()
                }) + '&id=' + this.order.id
            },
            isPremiumAdvert() {
                return !!this.order.catched_up_at
            },
            hasCatchedUp() {
                return !!this.order.catched_up_at
            },
            hasActivePremium() {
                return this.order.is_premium
            },
            catchUpDate() {
                return this.hasCatchedUp ? this.$moment(this.order.catched_up_at).format('DD.MM.YYYY в H:mm') : ''
            },
            catchUpDateTo() {
                return this.hasCatchedUp ? this.$moment(this.order.catched_up_to).format('DD.MM.YYYY H:mm') : ''
            },
            isActive() {
                return this.order.status === STATUS_ACTIVE
            },
        },

        methods: {
            onCatchUp() {
                $.fancybox.open($('#pay-premium-modal'));
            },
        }
    }
</script>

<style scoped>

</style>
