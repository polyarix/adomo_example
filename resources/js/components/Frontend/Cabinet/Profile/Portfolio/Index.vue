<template>
    <div class="personal-content-inner">
        <div class="main-title">Портфолио</div>
        <p class="text">Профиль с галереей получает в среднем в 3-5 раз больше откликов. Загружайте только реальные фото своих работ.</p>

        <div class="personal-portfolio-container">
            <album v-for="(album, index) in albums" :item="album" :key="album.id" @remove="onRemove(index)" />

            <a class="personal-portfolio-item add-album" :href="route('cabinet.portfolio.create')">
                <div class="add-album-icon" style="background-image:url(/images/add-file-icon.svg)"></div>
                <p>Создать альбом</p>
            </a>
        </div>
    </div>
</template>

<script>
    import Album from "./Item";

    export default {
        data() {
            return {
                albums: []
            }
        },

        created() {
            axios.get(this.route('api.user.cabinet.portfolio.index'))
                .then(res => {
                    this.albums = res.data.data
                })
                .catch(err => {
                    console.log(err)
                })
        },

        methods: {
            onRemove(index) {
                this.albums.splice(index, 1)
            }
        },

        components: {
            Album
        }
    }
</script>

<style scoped>

</style>
