<template>
    <div class="user-rating">
        <div class="user-rating-stars" :data-star="avg">
            <svg class="star" v-for="i in 5">
                <use xlink:href="/images/sprite-inline.svg#star"></use>
            </svg>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['avg'],
    }
</script>

<style scoped>

</style>
