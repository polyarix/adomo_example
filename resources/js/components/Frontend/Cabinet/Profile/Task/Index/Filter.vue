<template>
    <div class="tabs-caption">
        <div
            :class="{'tab-button': true, active: isMainPageActive}"
            @click.prevent="pickCategory(null)"
        >Все</div>

        <div
            :class="{'tab-button': true, active: isActiveFilter(category.id)}"
            @click.prevent="pickCategory(category.id)"
            v-for="category in categories"
        >{{ category.name }}</div>

        <div class="task-card-button btn btn-small btn-yellow" style="margin-top: 0;" @click="onCreateOrderClick" v-if="isCustomer">Создать задание</div>
    </div>
</template>

<script>
    import {mapGetters, mapMutations, mapState} from "vuex";

    export default {
        props: ['categories'],

        computed: {
            ...mapState('task', ['category']),
            ...mapGetters('task', ['isMainPageActive', 'isSpecificFilterActive']),
            ...mapGetters('user', ['isCustomer']),
        },

        methods: {
            ...mapMutations('task', ['setCategory']),

            onCreateOrderClick() {
                window.location.href = this.route('advert.order.create');
            },
            isActiveFilter(id) {
                return this.category === id
            },
            pickCategory(id) {
                if(this.category !== id) {
                    this.$emit('categoryChange', id);
                    if(id) {
                        this.$router.push({ name: 'cabinet.tasks.list', params: { type: id }});
                    } else {
                        this.$router.push({ name: 'cabinet.tasks.index' });
                    }
                }
                this.setCategory(id);
            }
        },

        watch: {
            category(newVal) {
                this.$emit('categoryChange', newVal);
                if(newVal) {
                    this.$router.push({ name: 'cabinet.tasks.list', params: { type: newVal }});
                } else {
                    this.$router.push({ name: 'cabinet.tasks.index' });
                }
            }
        }
    }
</script>

<style scoped>
    .tab-button:hover {
        cursor: pointer;
    }
</style>
