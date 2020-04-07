<template>
    <div class="promotion" v-if="loaded && banner">
        <a :href="banner.url" target="_blank"><img :src="image" alt=""></a>
    </div>
</template>

<script>
    export default {
        props: ['tagId', 'initDelay'],

        data() {
            return {
                loaded: false,
                banner: null
            }
        },

        computed: {
            haveBanner() {
                return this.banner && this.banner.length
            },
            image() {
                return `/storage/${this.banner.image}`
            }
        },

        created() {
            const delay = this.initDelay ? this.initDelay * 1000 : 1000;

            setTimeout(() => {
                this.loaded = true;

                axios.post(this.route('api.tag.banner'), {tag_id: this.tagId})
                    .then(res => {
                        this.banner = res.data.data;
                        this.loaded = res.data.count === 1;
                    })
            }, delay)
        }
    }
</script>

<style scoped>

</style>
