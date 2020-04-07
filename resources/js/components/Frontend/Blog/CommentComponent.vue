<template>
    <form @submit.prevent="onSubmit">
        <div class="you-comment-title">Ваш комментарий</div>
        <div class="add-comment">
            <div class="user-avatar"><img :src="avatar" alt=""></div>

            <textarea class="add-comment-input" name="" placeholder="Оставте свой комментарий…" v-model="comment" />
            <button v-if="submitButtonVisible"> </button>
        </div>
    </form>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        props: ['articleId', 'baseUrl'],

        data() {
            return {
                comment: ''
            }
        },

        computed: {
            ...mapState('user', ['user']),
            avatar() {
                return '/storage/' + this.user.photo
            },
            submitButtonVisible() {
                return this.comment.length > 1
            }
        },

        methods: {
            onSubmit() {
                let url = this.baseUrl || this.route('api.blog.comment.store', this.articleId);

                axios.post(url, {text: this.comment})
                    .then(res => {
                        const data = res.data;

                        if(data.success === true) {
                            this.comment = '';

                            $(this.buildTemplate(data.data.text, data.data.created_at, data.data.status)).insertBefore('.article-comments form');
                        }
                    })
            },

            buildTemplate(content, date, status = 'moderation') {
                const dateString = this.$moment(date).format('DD.MM.YYYY');

                return `
                    <div class="comment comment-moderation">
                      <span class="moderation-label">${status === 'active' ? '' : 'На модерации'}</span>
                      <div class="comment-author">
                        <div class="comment-author-avatar">
                          <img src="${this.avatar}" alt="">
                        </div>
                        <a href="${this.route('user.details', this.user.id)}" class="comment-author-link">
                          ${this.user.first_name} ${this.user.last_name}
                        </a>
                        <span>${dateString}</span>
                      </div>

                      <div class="comment-content">${content}</div>
                    </div>
                `
            }
        }
    }
</script>

<style scoped>

</style>
