<template>
    <div class="col category-body">
        <div class="people-group" id="autofit-result">
            <!-- Рекомендуемые -->
            <template>
                <executors-recommended-component
                        v-if="results.users.premium.data.length > 0"
                        :init-data="results.users.premium"
                        :category="category"
                />
            </template>

            <template>
                <executors-component
                        v-if="results.users.list.data.length > 0"
                        :init-data="results.users.list"
                        :filters="filters"
                        :category="category"
                >
                    <div class="headline">Специалисты </div>
                </executors-component>
            </template>

            <template>
                <adverts-component
                        v-if="results.services.data.length > 0"
                        :init-data="results.services"
                        :category="category"
                        :filters="filters"
                />
            </template>
        </div>
    </div>
</template>

<script>
    import ExecutorsRecommendedComponent from "./ExecutorsRecommendedComponent";
    import ExecutorsComponent from "./ExecutorsComponent";
    import AdvertsComponent from "./AdvertsComponent";

    export default {
        props: ['category', 'results', 'filters'],

        components: {AdvertsComponent, ExecutorsComponent, ExecutorsRecommendedComponent},
    }
</script>

<style scoped>

</style>
