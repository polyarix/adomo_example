<template>
    <div class="container-inner">
        <div class="albums-container">
            <album :item="album" :user="user" v-for="album in albums" :key="album.id" />
        </div>
        <div class="btn-container">
            <button class="btn btn-big btn-yellow" v-if="canShowMore" @click.prevent="showMore">Показать еще </button>
        </div>
    </div>
</template>

<script>
    import Album from "./ProfileAlbum";

    export default {
        props: ['user'],

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

                axios.post(this.route('api.user.albums.index'), { user_id: this.user.id, page: this.page })
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
