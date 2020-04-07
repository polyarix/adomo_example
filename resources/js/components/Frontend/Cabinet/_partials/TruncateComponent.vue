<template>
    <p class="slot-wrapper">{{ realText }}
        <slot></slot>

        <span class="truncate-button" v-if="isHided" @click="hided = false">{{ showButton }}</span>
        <span class="truncate-button open" v-else-if="isLong" @click="hided = true">{{ hideButton }}</span>
    </p>
</template>

<script>
    const TRUNCATE_LENGTH = 150;

    export default {
        props: {
            text: {
                type: String,
                required: true
            },
            showButton: {
                type: String,
                default: 'Показать'
            },
            hideButton: {
                type: String,
                default: 'Скрыть'
            },
            maxLength: {
                type: Number,
                default: TRUNCATE_LENGTH
            }
        },

        data() {
            return {
                hided: false,
            }
        },

        computed: {
            realText() {
                if(this.text.length > this.maxLength && this.hided) {
                    return this.text.slice(0, this.maxLength) + '...'
                }

                return this.text;
            },
            isLong() {
                return this.text.length > this.maxLength
            },
            isHided() {
                return this.isLong && this.hided
            }
        },

        filters: {
            truncate(text, stop, clamp) {
                return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '')
            }
        },

        created() {
            this.hided = this.text.length > this.maxLength;
        }
    }
</script>

<style scoped>
    .truncate-button {
        color: silver;
    }
    .truncate-button:hover {
        cursor: pointer;
    }
</style>
