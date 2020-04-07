import Vue from 'vue';

Vue.component('profile-details-form', require('./../components/Frontend/SignUp/CommonForm').default);
Vue.component('profile-work-data-form', require('./../components/Frontend/SignUp/WorkDataComponent').default);
Vue.component('work-user-categories-component', require('./../components/Frontend/Cabinet/Profile/WorkCategoriesComponent').default);
Vue.component('profile-services-edit-component', require('./../components/Frontend/Cabinet/Profile/Services/Edit/Form').default);
Vue.component('profile-main-info-component', require('./../components/Frontend/Cabinet/Profile/Main/EditInfoComponent').default);
Vue.component('profile-services-create-component', require('./../components/Frontend/Cabinet/Profile/Services/Create/Form').default);
Vue.component('profile-services-list-component', require('./../components/Frontend/Cabinet/Profile/Services/Index/List').default);
Vue.component('profile-tasks-list-component', require('./../components/Frontend/Cabinet/Profile/Task/Index/List').default);
Vue.component('profile-categories-form', require('./../components/Frontend/SignUp/WorkCategoriesComponent').default);
Vue.component('profile-verification-component', require('./../components/Frontend/Cabinet/Profile/Verification/VerificationComponent').default);

Vue.component('tasks-component', require('./../components/Frontend/Advert/Task/TasksComponent').default);
Vue.component('tasks-filter', require('./../components/Frontend/Advert/Task/Filter').default);
Vue.component('similar-adverts-component', require('./../components/Frontend/Advert/Advert/Order/SimilarAdvertsComponent').default);
Vue.component('order-actions-component', require('./../components/Frontend/Advert/Advert/Order/ActionsComponent').default);

Vue.component('profile-reviews-component', require('./../components/Frontend/Cabinet/Profile/ReviewsComponent').default);
Vue.component('profile-my-reviews-component', require('./../components/Frontend/Cabinet/Profile/MyReviewsComponent').default);
Vue.component('category-picker', require('./../components/Frontend/Advert/Advert/CategoryPicker').default);
Vue.component('category-executors-component', require('./../components/Frontend/Advert/Category/ExecutorsComponent').default);
Vue.component('category-executors-recommended-component', require('./../components/Frontend/Advert/Category/ExecutorsRecommendedComponent').default);
Vue.component('category-orders-component', require('./../components/Frontend/Advert/Category/AdvertsComponent').default);
Vue.component('create-order-component', require('./../components/Frontend/Advert/Advert/CreateOrderComponent').default);
Vue.component('edit-order-component', require('./../components/Frontend/Advert/Advert/EditOrderComponent').default);
Vue.component('order-review-component', require('./../components/Frontend/Advert/Advert/Order/ReviewComponent.vue').default);
