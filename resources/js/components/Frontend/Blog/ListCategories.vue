<template>
    <div class="container">
        <div class="tabs">
            <div class="tabs-caption">
                <div :class="{'tab-button': true, active: !active}" @click="setActive(null)">Все новости</div>
                <div :class="{'tab-button': true, active: active === category.slug}" @click="setActive(category.slug)" v-for="category in categories" :key="category.id">{{ category.name }}</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['categories'],

        data() {
            return {
                active: ''
            }
        },

        methods: {
            setActive(slug) {
                this.active = slug
            }
        }
    }
</script>

<style scoped>

</style>
