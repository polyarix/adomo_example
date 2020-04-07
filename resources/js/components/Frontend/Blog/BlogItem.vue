<template>
    <article class="post-card">
        <a class="post-card-image-link" :href="url">
            <img class="lazy" alt="" :src="preview" style="">

            <div class="post-card-category"><span class="article-category" v-if="item.main_category">{{ item.main_category.name }}</span></div>
        </a>

        <div class="post-card-content">
            <a class="post-card-content-link" :href="url">
                <header>
                    <h2 class="post-card-title">{{ item.title }}</h2>
                </header>

                <section>
                    <p>{{ item.description }}</p>
                </section>
            </a>

            <footer>
                <ul>
                    <li>
                        <span class="post-card-watch">
                            <svg class="eye">
                                <use xlink:href="/images/sprite-inline.svg#eye"></use>
                            </svg>
                            <span>{{ item.views }}</span>
                        </span>
                    </li>

                    <li>
                        <span class="post-card-date">
                            <time :datetime="dateTime">{{ date }}</time>
                        </span>
                    </li>
                </ul>
            </footer>
        </div>
    </article>
</template>

<script>
    export default {
        props: ['item', 'baseUrl'],

        computed: {
            url() {
                if(this.baseUrl) {
                    return this.baseUrl + '/' + this.item.slug
                }
                return this.route('blog.show', {article: this.item.slug});
            },
            preview() {
                const item = this.item;

                if(item.crop && item.crop.length > 0) {
                    return item.crop
                }
                return item.image;
            },
            date() {
                return this.$moment(this.item.created_at).format('DD.MM.YYYY')
            },
            dateTime() {
                return this.$moment(this.item.created_at).format('YYYY.MM.DD')
            }
        }
    }
</script>

<style scoped>

</style>
