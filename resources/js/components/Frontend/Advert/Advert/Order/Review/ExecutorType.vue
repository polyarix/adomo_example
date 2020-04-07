<template>
    <div class="order-feedback-rating">
        <div class="order-feedback-rating-item">
            <star-rating
                v-model="grade"
                :star-size="16"
                inactive-color="#C5C5C5"
                active-color="#FEC62B"
                :show-rating="false"
            />
            <h3>Ваша оценка: {{ grade }}</h3>
        </div>
    </div>
</template>

<script>
    import StarRating from 'vue-star-rating';

    export default {
        data() {
            return {
                grade: 1,
            }
        },

        watch: {
            grade() {
                this.$emit('change', {
                    key: 'grade',
                    value: this.grade
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
