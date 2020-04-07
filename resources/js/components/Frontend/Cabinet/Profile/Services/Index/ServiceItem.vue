<template>
    <div class="adv-card type-2">
        <span class="card-status moderation-status" v-if="isModeration">На модерации</span>
        <span class="card-status reject-status" v-if="isRejected">Отклонено</span>
        <span class="card-status spam-status" v-if="isSpam">Спам</span>
        <span class="card-status closed-status" v-if="isClosed">Закрыто</span>

        <remove-modal v-if="showModal" @confirm="onRemove" @cancel="showModal = false" />

        <div class="adv-card-img">
            <img :src="preview" alt="">
        </div>

        <a class="adv-card-name" :href="route('advert.task.show', service.slug)" target="_blank">
            <span>{{ category }}</span>
            <p>{{ service.title }}</p>
        </a>

        <div class="adv-card-disc">{{ service.description }}</div>
        <div class="adv-card-info">
            <p>{{ date }}</p>
            <div>
                <svg class="eye">
                    <use xlink:href="/images/sprite-inline.svg#eye"></use>
                </svg><span>Просмотры: {{ service.views }}</span>
            </div>
        </div>

        <a class="adv-card-price" :href="route('advert.task.show', service.slug)" target="_blank">{{ price }}</a>

        <div class="adv-card-action">
            <form :action="route('cabinet.services.edit', service.id)">
                <button class="btn-edit">
                    <svg class="reduction-icon">
                        <use xlink:href="/images/sprite-inline.svg#reduction-icon"></use>
                    </svg>
                    <span>Редактировать</span>
                </button>
            </form>

            <button class="btn-remove" @click.prevent="showModal = true">
                <svg class="rubbish-bin-delete-button">
                    <use xlink:href="/images/sprite-inline.svg#rubbish-bin-delete-button"></use>
                </svg><span>Удалить</span>
            </button>
        </div>
    </div>
</template>

<script>
    import RemoveModal from "./RemoveModal";
    import {STATUS_CLOSED, STATUS_MODERATION, STATUS_REJECTED, STATUS_SPAM} from "../../../../../../constants";
    const PRICE_TYPE_SPECIFIC = 'specific'; // определённая
    const PRICE_TYPE_DISCUSS = 'discuss'; // договорная

    export default {
        components: {RemoveModal},
        props: ['service'],

        data() {
            return {
                showModal: false
            }
        },

        methods: {
            onRemove() {
                axios.delete(this.route('api.user.cabinet.services.destroy', this.service.id))
                    .then(res => {
                        if(res.data.success) {
                            this.$emit('removed');
                            return;
                        }

                        this.setCommonError('Что-то пошло не так. Повторите запрос.', 2000)
                    })
                    .catch(err => {
                        this.setCommonError('Произошла какая-то ошибка.');
                    })
                    .finally(() => {
                        this.loading = false;
                        this.showModal = false;
                    })
            }
        },

        computed: {
            category() {
                return this.service.categories.map(cat => cat.name).join(', ')
            },
            preview() {
                return this.service.preview
            },
            date() {
                return this.$moment(this.service.created_at).from(this.$moment());
            },
            price() {
                if(this.isPriceDiscuss) {
                    return 'Обсуждается'
                }

                return `${this.service.price} Р`;
            },
            isPriceSpecific() {
                return this.service.price_type === PRICE_TYPE_SPECIFIC
            },
            isPriceDiscuss() {
                return this.service.price_type === PRICE_TYPE_DISCUSS
            },
            isModeration() {
                return this.service.status === STATUS_MODERATION
            },
            isRejected() {
                return this.service.status === STATUS_REJECTED
            },
            isClosed() {
                return this.service.status === STATUS_CLOSED
            },
            isSpam() {
                return this.service.status === STATUS_SPAM
            }
        },
    }
</script>

<style scoped>
    .card-status {
        display: inline-block;
        position: absolute;
        bottom: 0;
        right: 0;
        margin: 0 15px 15px;
        padding: 5px;
        font-size: .8em;
    }
    .moderation-status {
        color: rgba(255, 145, 3, 0.9);
    }
    .reject-status {
        color: rgba(255, 42, 33, 0.9);
    }
    .spam-status {
        color: rgba(79, 26, 255, 0.9);
    }
    .closed-status {
        color: rgba(255, 42, 33, 0.9);
    }
</style>
