<template>
    <a class="album-card" :href="route('company.album.show', {album: item.id, company: company.slug})">
        <div class="album-card-img">
            <img class="lazy" :alt="item.title" :src="preview" style="">
            <div class="album-card-img-value">
                <span>{{ item.count }}</span><span>фото</span>
            </div>
        </div>
        <div class="album-card-body">
            <div class="album-name">{{ item.title }}</div>
            <div class="album-discription" v-html="item.description"></div>
            <div class="album-meta">
                <div class="album-date">{{ date }}</div>
            </div>
        </div>
    </a>
</template>

<script>
    export default {
        props: ['item', 'company'],

        computed: {
            preview() {
                return this.item.preview
            },
            date() {
                return this.$moment(this.item.updated_at).format('DD.MM.YYYY')
            }
        }
    }
</script>

<style scoped>

</style>
