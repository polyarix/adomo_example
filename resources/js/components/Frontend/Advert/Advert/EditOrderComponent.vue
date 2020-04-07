<template>
    <div class="task-page-body-inner">
        <div class="main-title">Редактирование задания</div>

        <div class="alert alert-success" v-if="common_message">{{ common_message }}</div>
        <div class="alert alert-danger" v-if="common_error">{{ common_error }}</div>

        <div class="task-form-wrap">
            <div class="label">Выбор категории задания</div>
            <div id="treeselect">
                <treeselect
                    v-model="category_value"
                    :options="categories"
                    :disable-branch-nodes="true"
                    :show-count="true"
                    placeholder="Категория"
                    :class="{ 'is-invalid': isError('category')  }"
                />

                <span class="invalid-feedback" role="alert" v-if="isError('category')">
                    <strong>{{ getError('category') }}</strong>
                </span>
            </div>
        </div>

         <div class="task-form-wrap">
            <div class="form-group">
                <label for="task-title">Заголовок задания</label>
                <input type="text" id="task-title" placeholder="Что нужно сделать" :class="{ 'is-invalid': isError('title') }" v-model="title" />

                <span class="invalid-feedback" role="alert" v-if="isError('title')">
                    <strong>{{ getError('title') }}</strong>
                </span>
            </div>
        </div>

        <div class="task-form-wrap">
            <div class="task-price-component">
                <div class="form-group-radio">
                    <div class="form-group-name">Укажите тип цены</div>
                    <div class="radio">
                        <input id="price-static" name="price" type="radio" v-model="price_type" value="specific"/>
                        <label class="radio-label" for="price-static">Цена</label>
                        <input :class="{ 'task-price-input': true, 'is-invalid': isError('title') }" placeholder="Цена (руб.)" v-model="price"/>
                    </div>
                    <div class="radio">
                        <input id="price-contract" name="price" type="radio" v-model="price_type" value="discuss"/>
                        <label class="radio-label" for="price-contract">Договорная</label>
                    </div>

                    <span class="invalid-feedback" role="alert" v-if="isError('price')">
                        <strong>{{ getError('price') }}</strong>
                    </span>
                </div>
            </div>
        </div>

        <!-- Описание задания-->
        <div class="task-form-wrap">
            <div class="form-group">
                <label for="task-discription">Описание задания</label>
                <textarea name="" id="task-discription" placeholder="Подробно опишите ваше задание" :class="{ 'is-invalid': isError('description') }" v-model="description"></textarea>

                <span class="invalid-feedback" role="alert" v-if="isError('description')">
                    <strong>{{ getError('description') }}</strong>
                </span>
            </div>
        </div>

        <div class="task-form-wrap">
            <label class="label">Теги</label>

            <div>
                <treeselect
                    :options="tagOptions"
                    v-model="tags"
                    :value="tags"
                    :multiple="true"
                    placeholder="Выберите из списка или введите вручную"

                    clearAllText="Очисти все"
                    clearValueText="Удалить значение"
                    loadingText="Загрузка..."
                    noChildrenText="Нет доступных под-опций"
                    noOptionsText="Нет доступных опций"
                    noResultsText="Ничего не найдено"
                >
                    <div slot="value-label" slot-scope="{ node }">{{ node.raw.customLabel }}</div>
                </treeselect>
            </div>
        </div>

        <!-- Фото -->
        <div class="task-form-wrap">
            <div class="task-photo-component">
                <div class="label">Добавьте фото</div>
            </div>
            <uploader
                v-model="fileList"
                :url="route('api.advert.photo.upload')"
                title=""
                :limit="10"
                @on-success="onSuccess"
                :params="{_token: csrfToken}"
            />
        </div>

        <!-- Город-->
        <div class="task-form-wrap">
            <div class="form-group-select">
                <label for="city">Город</label>
                <div class="select">
                    <select
                        name="city"
                        id="city"
                        class="form-control"
                        v-model="city"
                    >
                        <option v-for="city in cities" :value="city.id">
                            {{ city.name }}
                        </option>
                    </select>
                </div>

                <span class="invalid-feedback" role="alert" v-if="isError('city')">
                    <strong>{{ getError('city') }}</strong>
                </span>
            </div>
        </div>

        <!-- Адрес и карта-->
        <map-component
            :address-error="isError('address')"
            :map-error="isError('coordinates')"
            :district-select-enabled="true"
            @coordinates-changed="onCoordinatesChange"
            @comment-changed="onCommentChange"
            @changeDistrict="district = $event"
            :address-prop="order.address"
            :comment-prop="order.comment"
            :coords-prop="coords"
            :district-prop="order.district_id"
            :map-coords-prop="coords"
            :city="selectedCity"
            :cities="cities"
        />

        <!-- Дата выполнения задания-->
        <div class="task-form-wrap wrap-auto">
            <div class="task-datework-component">
                <div class="task-datework-component-time">
                    <div class="title">Дата выполнения задания</div>
                    <div class="date-copy" id="date-copy"> </div>
                    <div class="form-group-radio">
                        <div class="form-group-name">Когда нужно выполнить</div>
                        <div class="radio">
                            <input id="when-1" name="when" type="radio" v-model="time_type" value="any" />
                            <label class="radio-label" for="when-1">В любое время</label>
                        </div>
                        <div class="radio">
                            <input id="when-2" name="when" type="radio" v-model="time_type" value="first_half"/>
                            <label class="radio-label" for="when-2" v-if="!isFirstDateHalfDisabled">С 8:00 до 12:00</label>
                        </div>
                        <div class="radio">
                            <input id="when-3" name="when" type="radio" v-model="time_type" value="second_half"/>
                            <label class="radio-label" for="when-3">С 12:00 до 22:00</label>
                        </div>
                    </div>
                </div>

                <div class="task-datework-component-calendar">
                    <input class="datework-date" type="text" id="date-work" hidden="hidden" v-model="date"/>

                    <span class="invalid-feedback" role="alert" v-if="isError('date')">
                        <strong>{{ getError('date') }}</strong>
                    </span>
                </div>
            </div>
        </div>

        <!-- Предоставление жилья на время работ-->
        <div class="task-form-wrap">
            <div class="form-group-radio">
                <div class="form-group-name">Предоставление жилья на время работ</div>
                <div class="radio">
                    <input id="Housing-1" name="Housing" type="radio" :value="true" v-model="house_provision"/>
                    <label class="radio-label" for="Housing-1">Да</label>
                </div>
                <div class="radio">
                    <input id="Housing-2" name="Housing" type="radio" :value="false" v-model="house_provision"/>
                    <label class="radio-label" for="Housing-2">Нет</label>
                </div>
            </div>
        </div>

        <!-- Материалы заказчика или нужна закупка исполнителем-->
        <div class="task-form-wrap wrap-auto">
            <div class="form-group-radio">
                <div class="form-group-name">Материалы заказчика или нужна закупка исполнителем</div>
                <div class="radio">
                    <input id="Materials-1" name="Materials" type="radio" :value="true" v-model="material_provision"/>
                    <label class="radio-label" for="Materials-1">Материалы заказчика</label>
                </div>
                <div class="radio">
                    <input id="Materials-2" name="Materials" type="radio" :value="false" v-model="material_provision"/>
                    <label class="radio-label" for="Materials-2">Нужна закупка исполнителем</label>
                </div>
            </div>
        </div>

        <button class="btn btn-big btn-yellow" @click.prevent="onSubmit">Опубликовать</button>
    </div>
</template>

<script>
    // import the component
    import Treeselect from '@riophae/vue-treeselect';
    import '@riophae/vue-treeselect/dist/vue-treeselect.min.css';
    import Uploader from './../../../../helpers/Common/Uploader/Uploader';
    import {getDateString, getRuDay, getRuMonth} from './../../../../helpers/Date/DateHelpers';
    import MapComponent from "./MapComponent";
    import UploadVideosComponent from "./UploadVideosComponent";

    export default {
        props: ['order', 'categories', 'cities'],

        data() {
            return {
                category_value: this.order.category_id,
                title: this.order.title,
                city: this.order.city_id,
                price: this.order.price,
                price_type: this.order.price_type,
                description: this.order.description,
                address: this.order.address,
                comment: this.order.comment,
                district: this.order.district_id,
                coords: [this.order.map_lat, this.order.map_long],
                time_type: this.order.time_type,
                date: '',
                house_provision: this.order.house_provision,
                material_provision: this.order.materials_provision,

                fileList: [],
                videos: [],

                tags: this.order.tags.map(tag => tag.id),
                tagsList: [],

                common_message: '',
                common_error: '',
                errors: [],
            }
        },

        computed: {
            tagOptions() {
                return this.tagsList.map(tag => ({
                    id: tag.id,
                    label: tag.name,
                    customLabel: `# ${tag.name}`
                }))
            },
            formatBeginDate() {
                return getDateString(new Date(this.order.beginning_date))
            },
            isFirstDateHalfDisabled() {
                const date = new Date();

                return false;

                return date.getHours() >= 12 && this.date === getDateString(date);
            },
            closestDate() {
                let date = new Date();

                if(date.getHours() >= 22) {
                    date.setDate(date.getDate() + 1);
                }

                return getDateString(date);
            },
            minDate() {
                if(this.date) {
                    let date = new Date(this.order.beginning_date);
                    date.setHours(0,0,0,0);

                    let today = new Date();
                    today.setHours(0,0,0,0);

                    if(date < today) {
                        return this.date
                    }
                }

                return 'today';
            },
            photos() {
                return this.fileList.map(file => file.id)
            },
            isAgreedPriceType() {
                return this.price_type === 'discuss';
            },
            csrfToken() {
                return $('meta[name="csrf-token"]').attr('content')
            },
            validVideos() {
                return this.order.videos.map(video => video.url)
            },
            selectedCity() {
                if(!this.city) {
                    return []
                }
                return this.getCityById(this.city);
            }
        },

        methods: {
            getCityById(id) {
                return this.cities.filter(city => city.id === id)[0]
            },
            onCommentChange(val) {
                this.comment = val;
            },
            onCoordinatesChange(payload) {
                this.address = payload.address;
                this.coords = payload.coords;
            },
            fetchTags() {
                axios.post(this.route('api.category.tags'), {category_id: this.category_value})
                    .then(res => {
                        this.tagsList = res.data.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            onSubmit() {
                let errors = {};

                if(this.description.length < 5) {
                    errors['description'] = 'Описание должно быть длиннее 5 сиволов.';
                }
                if(this.title.length < 5) {
                    errors['title'] = 'Заголовок должен быть длиннее 5 сиволов.';
                }
                if(!this.category_value) {
                    errors['category'] = 'Категория не выбрана.';
                }
                if(!this.city) {
                    errors['city'] = 'Город не выбран.';
                }
                if(this.address.length < 5) {
                    errors['address'] = 'Адрес должен быть длиннее 5 сиволов.';
                }
                if(!this.coords) {
                    errors['coords'] = 'Координаты на карте не указаны.';
                }
                if(!this.date) {
                    errors['date'] = 'Дата не указана.';
                }
                if(!this.time_type) {
                    errors['time_type'] = 'Время не указано.';
                }
                this.errors = errors;

                if(Object.keys(errors).length > 0) {
                    return false;
                }

                axios.post(this.route('api.advert.update', {id: this.order.id}), {
                    description: this.description,
                    title: this.title,
                    category: this.category_value,
                    city: this.city,
                    address: this.address,
                    comment: this.comment,
                    district: this.district,
                    coords: this.coords,
                    date: this.date,
                    house_provision: this.house_provision,
                    material_provision: this.material_provision,
                    price_type: this.price_type,
                    price: this.isAgreedPriceType ? null : this.price,
                    time_type: this.time_type,
                    photos: this.photos,
                    videos: this.videos,
                    tags: this.tags
                })
                    .then(res => {
                        const data = res.data;

                        if(data.success === true) {
                            this.setCommonMessage('Объявление успешно обновлено.');
                            setTimeout(() => {
                                window.location.href = this.route('advert.order.show', data.data.slug);
                            }, 2000);
                        }
                    })
                    .catch(err => {
                        this.common_error = err.message;
                        let data = err.response.data;
                        this.setCommonError('Ошибка добавления объявления.');

                        for(let key in data.errors) {
                            this.errors[key] = data.errors[key][0];
                        }
                    })
            },

            onSuccess(e, file) {
                file.id = e.id;
            },
            onVideosChange(videos) {
                this.videos = videos;
            },

            isError(key) {
                return this.getError(key) !== undefined
            },
            getError(key) {
                return this.errors[key]
            },
        },

        created() {
            if(this.order.beginning_date) {
                this.date = this.formatBeginDate;
            } else {
                this.date = this.closestDate;
            }

            this.fileList = this.order.photos.map(image => {
                return {url: `/storage/${image.path}`, id: image.id};
            });

            this.fetchTags();
        },

        mounted() {
            $("#date-work").flatpickr(
                {
                    locale: "ru",
                    dateFormat:"d-m-Y",
                    minDate: this.minDate,
                    inline: true,
                    defaultDate: this.date,
                    onReady: function(selectedDates, dateStr, instance) {
                        let date = `${selectedDates[0].getDate()} ${getRuMonth(instance.currentMonth, true)}`;

                        $("#date-copy").html(date)
                    },
                    onChange: (selectedDates, dateStr, instance) => {
                        let date = `${selectedDates[0].getDate()} ${getRuMonth(instance.currentMonth, true)}`;

                        this.time_type = 'any';
                        $("#date-copy").html(date)
                    }
                }
            );
        },

        watch: {
            category_value() {
                this.tags = [];
                this.fetchTags();
            },
            city() {
                this.district = null
            }
        },

        components: {
            Treeselect, Uploader, MapComponent, UploadVideosComponent
        }
    }
</script>

<style scoped>
    .loader {
        float: right;
    }
</style>
