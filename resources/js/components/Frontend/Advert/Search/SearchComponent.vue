<template>
    <autocomplete
        :search="search"
        :debounce-time="400"
        id="search"
        @submit="onSubmit"
        :get-result-value="getResultValue"
        class="search"
        ref="autocomplete"
    >
        <template #result="{ result, props }">
            <li v-bind="props"><div v-html="getResultValue(result)"></div></li>
        </template>
    </autocomplete>
</template>

<script>
    import Autocomplete from '@trevoreyre/autocomplete-vue'
    import '@trevoreyre/autocomplete-vue/dist/style.css'
    import {stripHtml} from "../../../../helpers/Common/Str/HtmlHelpers";
    import SearchEntityFactory from './EntityFactory'

    export default {
        methods: {
            onSubmit(payload) {
                this.$refs.autocomplete.setValue(stripHtml(payload.title));
                const entity = SearchEntityFactory.build(payload);

                window.location.href = entity.getUrl()
            },

            getResultValue(result) {
                if(typeof result === 'object') {
                    const entity = SearchEntityFactory.build(result);

                    return entity.getDescription()
                }

                return result
            },

            search(input) {
                if (input.length < 1) {
                    return []
                }

                return new Promise(resolve => {
                    if (input.length < 1) {
                        return resolve([])
                    }

                    axios.post('/search', {q: input})
                        .then(response => {
                            resolve(response.data.map(el => {
                                return {
                                    title: this.getHighlight(el, 'title'),
                                    description: this.getHighlight(el, 'description'),
                                    category: el.data.category,
                                    slug: el.data.slug,
                                    type: el.type,
                                }
                            }));
                        })
                })
            },

            getHighlight(result, field) {
                if(result.highlight && result.highlight[field]) {
                    return result.highlight[field].join('')
                }

                return result.data[field];
            },
        },

        mounted() {
            this.$refs.autocomplete.$refs.input.placeholder = 'Что нужно сделать?';
        },

        components: {
            Autocomplete
        }
    }
</script>

<style type="scss">
    #autocomplete {
        width: 600px;
        margin: 0 auto;
    }
    .autocomplete-result-list em {
        font-weight: bold;
        padding: 3px;
    }
    .autocomplete-result-list {
        font-size: 0.9em;
    }
    .autocomplete-result {
        background-image: none;
        padding: 12px 12px 12px 20px;
    }
    .autocomplete-input {
        background-image: url(/img/search.svg);
        background-size: 30px;
    }
    .advert-category {
        font-weight: bold;
        padding: 3px;
        text-decoration: underline;
    }
    .autocomplete {
        width: 100% !important;
    }
    input#search {
        padding: 7px 7px 7px 48px;
        box-shadow: none;
        background-color: transparent;
        color: rgba(50, 50, 50, .5);
        font-size: 0.9em;
    }
    input#search:focus {
        border-color: #323232;
    }
    .autocomplete-result-list {
        border: 1px solid #323232;
    }
    .autocomplete-result-list li:hover {
        cursor: pointer !important;
    }
</style>
