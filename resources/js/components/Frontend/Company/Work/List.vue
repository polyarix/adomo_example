<template>
    <div class="container-inner">
        <div class="albums-container">
            <album :item="album" v-for="album in albums" :company="company" :key="album.id" />
        </div>
        <div class="btn-container">
            <button class="btn btn-big btn-yellow" v-if="canShowMore" @click.prevent="showMore">Показать еще</button>
        </div>
    </div>
</template>

<script>
    import Album from './Work';

    export default {
        props: ['company'],

        data() {
            return {
                loading: true,
                canShowMore: false,
                page: 1,
                albums: [],
            }
        },

        methods: {
            showMore() {
                this.loading = true;

                axios.post(this.route('api.companies.works.index', {company: this.company.slug}), { company_id: this.company.id, page: this.page })
                    .then(res => {
                        this.albums = this.albums.concat(res.data.data);
                        this.canShowMore = res.data.meta.last_page >= this.page;
                        this.loading  = false;
                    });

                this.page++;
            },
        },

        created() {
            this.showMore();
        },

        components: {Album},
    }
</script>

<style scoped>

</style>
