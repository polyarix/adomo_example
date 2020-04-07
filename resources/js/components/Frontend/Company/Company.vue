<template>
    <div class="company-card">
        <div class="company-card-avatar"><img :src="'/storage/' + company.logo" alt=""></div>
        <div class="company-card-body">
            <div class="company-card-body-top">
                <a class="company-card-body-info" :href="route('company.show', company.slug)">
                    <div class="company-card-name">{{ company.name }}</div>
                    <div class="company-card-place">{{ company.city.name }}</div>
                    <div class="company-card-people">{{ company.workers_count }}</div>
                </a>

                <write-company-message-component :company='company' action="Предложить работу" v-if="!amICompanyOwner" />
            </div>
            <div class="company-card-body-bottom">
                <p>Компания выполняет:</p>
                <ul>
                    <li v-for="category in company.categories"><a :href="route('companies.index', category.slug)">{{ category.name }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";

    export default {
        props: ['company'],

        computed: {
            ...mapState('user', ['user']),

            amICompanyOwner() {
                return this.user && this.company.user.id === this.user.id
            },
        }
    }
</script>

<style scoped>

</style>
