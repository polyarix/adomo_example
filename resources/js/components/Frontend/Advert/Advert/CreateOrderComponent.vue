<template>
    <div class="row">
        <div class="col task-page-body">
            <div class="task-page-body-inner">
                <div class="main-title">Создание задания</div>

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
                            clearAllText="Очисти все"
                            clearValueText="Удалить значение"
                            loadingText="Загрузка..."
                            noChildrenText="Нет доступных под-опций"
                            noOptionsText="Нет доступных опций"
                            noResultsText="Ничего не найдено"
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
                    ></uploader>
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
                    @change-district="district = $event"
                    :address-prop="address"
                    :coords-prop="coords"
                    :map-coords-prop="getCoordinates"
                    :city="selectedCity"
                    :cities="cities"
                />

                <!-- Дата выполнения задания-->
                <div class="task-form-wrap wrap-auto">
                    <div class="task-datework-component">
                        <div class="task-datework-component-time">
                            <div class="title">Дата выполнения задания</div>
                            <div class="form-group-date">
                                <div class="form-group">
                                    <input type="text" id="date-work-copy" placeholder="Выберите дату"/>
                                    <svg class="calendar-icon">
                                        <use xlink:href="/images/sprite-inline.svg#calendar-icon"></use>
                                    </svg>
                                </div>
                            </div>
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
                            <input id="Housing-1" name="Housing" type="radio" value="1" v-model="house_provision"/>
                            <label class="radio-label" for="Housing-1">Да</label>
                        </div>
                        <div class="radio">
                            <input id="Housing-2" name="Housing" type="radio" value="0" v-model="house_provision"/>
                            <label class="radio-label" for="Housing-2">Нет</label>
                        </div>
                    </div>
                </div>

                <!-- Материалы заказчика или нужна закупка исполнителем-->
                <div class="task-form-wrap wrap-auto">
                    <div class="form-group-radio">
                        <div class="form-group-name">Материалы заказчика или нужна закупка исполнителем</div>
                        <div class="radio">
                            <input id="Materials-1" name="Materials" type="radio" value="1" v-model="material_provision"/>
                            <label class="radio-label" for="Materials-1">Материалы заказчика</label>
                        </div>
                        <div class="radio">
                            <input id="Materials-2" name="Materials" type="radio" value="0" v-model="material_provision"/>
                            <label class="radio-label" for="Materials-2">Нужна закупка исполнителем</label>
                        </div>
                    </div>
                </div>

                <div class="task-form-wrap" v-if="selectedExecutor">
                    <div class="form-group-name">Вы выбрали исполнителя </div>
                    <div class="selected-workman">
                        <a :href="route('user.details', selectedExecutor.id)" target="_blank">
                            {{ selectedExecutor.first_name }} {{ selectedExecutor.last_name }}
                        </a>
                        <button class="btn-x-remove" @click="selectedExecutor = ''">×</button>
                    </div>
                </div>

                <button class="btn btn-big btn-yellow" @click.prevent="onSubmit">Опубликовать</button>
            </div>
        </div>

        <div class="col task-page-sidebar">
            <div class="task-page-recommend" v-if="showRecommended && recommended.length > 0">
                <div class="headline">Рекомендуемые исполнители</div>

                <recommended-user
                    v-for="user in recommended"
                    :user="user"
                    :key="user.id"
                    :executor-id="selectedExecutor.id"
                    @remove="selectedExecutor = ''"
                    @select="selectedExecutor = $event"
                />
            </div>

            <slot></slot>
        </div>
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
    import DistrictComponent from "./Partials/DistrictComponent";
    import RecommendedUser from "./Order/User/RecommendedUser";

    export default {
        props: ['category', 'categories', 'cities', 'executor', 'order', 'showRecommended'],

        data() {
            return {
                category_value: this.category ? this.category.id : null,
                title: '',
                city: 1,
                price: '',
                price_type: 'specific',
                description: '',
                address: '',
                coords: [],
                time_type: 'any', // any | first_half | second_half
                date: '',
                house_provision: 0,
                material_provision: 0,
                comment: '',
                district: '',

                fileList: [],
                videos: [],
                recommended: [],

                tags: null,
                tagsList: [],

                selectedExecutor: '',

                common_message: '',
                common_error: '',
                errors: [],

                currentCity: window.city
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
            selectedExecutorId() {
                if(this.executor) {
                    return this.executor
                }
                return this.selectedExecutor ? this.selectedExecutor.id : null
            },
            getCoordinates() {
                if(!this.coords || this.coords.length === 0) {
                    return [this.currentCity.map_lat, this.currentCity.map_long];
                }

                return [this.coords[0], this.coords[1]]
            },
            isFirstDateHalfDisabled() {
                const date = new Date();

                return date.getHours() >= 12 && this.date === getDateString(date);
            },
            closestDate() {
                let date = new Date();

                if(date.getHours() >= 22) {
                    date.setDate(date.getDate() + 1);
                }

                return getDateString(date);
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
            selectedCity() {
                if(!this.city) {
                    return []
                }
                return this.getCityById(this.city);
            }
        },

        watch: {
            city() {
                const city = this.getCityById(this.city);
                this.currentCity = city;
                this.coords = [];
                window.coords = this.getCoordinates
            },
            category_value() {
                this.tags = [];

                axios.post(this.route('api.category.tags'), {category_id: this.category_value})
                    .then(res => {
                        this.tagsList = res.data.data
                    })
                    .catch(err => {
                        console.log(err)
                    });

                if(!this.showRecommended) {
                    return;
                }

                if(!this.category_value) {
                    this.recommended = [];
                    return;
                }

                axios.post(this.route('api.advert.recommended'), {category: this.category_value})
                    .then(res => {
                        this.recommended = res.data.data
                    })
            }
        },

        methods: {
            onCommentChange(val) {
                this.comment = val;
            },
            getCityById(id) {
                return this.cities.filter(city => city.id === id)[0]
            },
            onCoordinatesChange(payload) {
                console.log('changed coordinates');
                this.address = payload.address;
                this.coords = payload.coords;
            },
            onVideosChange(videos) {
                this.videos = videos;
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
                if(!this.isAgreedPriceType && !Boolean(this.price)) {
                    errors['price'] = 'Цена не заполнена.';
                }
                this.errors = errors;

                if(Object.keys(errors).length > 0) {
                    return false;
                }

                axios.post(this.route('api.advert.store'), {
                    description: this.description,
                    title: this.title,
                    category: this.category_value,
                    city: this.city,
                    address: this.address,
                    coords: this.coords,
                    date: this.date,
                    house_provision: this.house_provision,
                    material_provision: this.material_provision,
                    price_type: this.price_type,
                    price: this.isAgreedPriceType ? null : this.price,
                    time_type: this.time_type,
                    photos: this.photos,
                    executor: this.selectedExecutorId,
                    videos: this.videos,
                    comment: this.comment,
                    district: this.district,
                    tags: this.tags
                })
                    .then(res => {
                        const data = res.data;

                        if(data.success === true) {
                            this.common_message = 'Объявление успешно создано и отправлено на модерацию.';
                            window.location.href = this.route('advert.order.show', data.data.slug);
                            return;
                        }
                    })
                    .catch(err => {
                        this.common_error = err.message;
                        let data = err.response.data;
                        this.setCommonError('Ошибка добавления объявления.')

                        for(let key in data.errors) {
                            this.errors[key] = data.errors[key][0];
                        }
                    })
            },

            onSuccess(e, file) {
                file.id = e.id;
            },

            isError(key) {
                return this.getError(key) !== undefined
            },
            getError(key) {
                return this.errors[key]
            },

            onDateChange(selectedDates, dateStr, instance) {
                let date = `${selectedDates[0].getDate()} ${getRuMonth(instance.currentMonth, true)}`;

                this.date = dateStr;
                this.time_type = 'any';
                $("#date-copy").html(date)
            }
        },

        created() {
            if(this.order) {
                this.title = this.order.title;
                this.city = this.order.city_id;
                this.price = this.order.price;
                this.price_type = this.order.price_type;
                this.description = this.order.description;
                this.address = this.order.address;
                this.house_provision = this.order.house_provision ? '1' : '0';
                this.material_provision = this.order.materials_provision ? '1' : '0';
                this.address = this.order.address;
                this.coords = [parseFloat(this.order.map_lat), parseFloat(this.order.map_long)];
            } else {
                this.city = window.city.id;
            }

        },

        mounted() {
            $("#date-work-copy").flatpickr(
                {
                    locale: "ru",
                    dateFormat:"d-m-Y",
                    minDate: "today",
                    defaultDate: this.closestDate,
                    onReady: function(selectedDates, dateStr, instance) {
                        if(!selectedDates[0]) {
                            return 'today'
                        }

                        let date = `${selectedDates[0].getDate()} ${getRuMonth(instance.currentMonth, true)}`;

                        $("#date-copy").html(date)
                    },
                    onChange: this.onDateChange
                }
            );
            $("#date-work").flatpickr(
                {
                    locale: "ru",
                    dateFormat:"d-m-Y",
                    minDate: "today",
                    inline: true,
                    defaultDate: this.closestDate,
                    onReady: function(selectedDates, dateStr, instance) {
                        if(!selectedDates[0]) {
                            return 'today'
                        }

                        let date = `${selectedDates[0].getDate()} ${getRuMonth(instance.currentMonth, true)}`;

                        $("#date-copy").html(date)
                    },
                    onChange: this.onDateChange
                }
            );

            this.date = this.closestDate;
        },

        components: {
            RecommendedUser,
            Treeselect, Uploader, MapComponent, UploadVideosComponent, DistrictComponent
        }
    }
</script>

<style>
</style>
