<template>
    <div class="order-feedback-rating">
        <div class="order-feedback-rating-item">
            <star-rating
                v-model="quality"
                :star-size="16"
                inactive-color="#C5C5C5"
                active-color="#FEC62B"
                :show-rating="false"
            />
            <h3>Качество: {{ quality }}</h3>
        </div>
        <div class="order-feedback-rating-item">
            <star-rating
                v-model="professionalism"
                :star-size="16"
                inactive-color="#C5C5C5"
                active-color="#FEC62B"
                :show-rating="false"
            />
            <h3>Профессионализм: {{ professionalism }}</h3>
        </div>

        <div class="order-feedback-rating-item">
            <star-rating
                v-model="punctuality"
                :star-size="16"
                inactive-color="#C5C5C5"
                active-color="#FEC62B"
                :show-rating="false"
            />
            <h3>Пунктуальность и вежливость: {{ punctuality }}</h3>
        </div>
    </div>
</template>

<script>
    import StarRating from 'vue-star-rating';

    export default {
        data() {
            return {
                quality: 1,
                professionalism: 1,
                punctuality: 1,
            }
        },

        watch: {
            quality() {
                this.$emit('change', {
                    key: 'quality',
                    value: this.quality
                })
            },
            professionalism() {
                this.$emit('change', {
                    key: 'professionalism',
                    value: this.professionalism
                })
            },
            punctuality() {
                this.$emit('change', {
                    key: 'punctuality',
                    value: this.punctuality
                })
            }
        },

        components: {
            StarRating
        }
    }
</script>

<style scoped>

</style>
