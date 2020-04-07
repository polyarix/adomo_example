<template>
    <div class="services-filter-inner">
        <a
            :class="{'services-filter-item': true, current: isMainPageActive}"
            @click.prevent="pickCategory(null)"
        >Все</a>

        <a
            :class="{'services-filter-item': true, current: isActiveFilter(category.id)}"
            @click.prevent="pickCategory(category.id)"
            v-for="category in categories"
        >{{ category.name }}</a>
    </div>
</template>

<script>
    import {mapGetters, mapMutations, mapState} from "vuex";

    export default {
        props: ['categories'],

        computed: {
            ...mapState('service', ['category']),
            ...mapGetters('service', ['isMainPageActive', 'isSpecificFilterActive']),
        },

        methods: {
            ...mapMutations('service', ['setCategory']),

            isActiveFilter(id) {
                return this.category === id
            },
            pickCategory(id) {
                if(this.category !== id) {
                    this.$emit('categoryChange', id)
                }
                this.setCategory(id);
            }
        }
    }
</script>

<style scoped>
    a:hover {
        cursor: pointer;
    }
</style>
