<template>
    <div class="chat-list">
        <div class="chat-list-header">Все сообщения</div>

        <vue-scroll class="chat-list-users" ref="vs" style="height: calc(100% - 75px - 90px)" @handle-scroll="onScrollHandle">
            <thread v-for="inbox in filteredThreads" :inbox="inbox" :key="inbox.id" />
        </vue-scroll>
    </div>
</template>

<script>
    import Thread from "./Thread";
    import {mapState, mapGetters} from 'vuex';

    export default {
        computed: {
            ...mapState('user', ['user']),
            ...mapState('chat', ['threads']),
            ...mapGetters('chat', ['filteredThreads']),
        },

        methods: {
            onScrollHandle(payload) {
                const progress = payload.process;

                if(progress >= 0.5) {
                    this.$store.dispatch('chat/fetchThreads')
                }
            }
        },

        created() {
            this.$store.dispatch('chat/fetchThreads')
        },

        components: {
            Thread
        }
    }
</script>

<style scoped>

</style>
