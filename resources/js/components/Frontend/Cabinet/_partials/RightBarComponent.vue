<template>
    <div class="col right-bar sticky">
        <div class="filling sticky">
            <div class="filling-progress" :data-progress="progress">
                <svg id="progress-svg" width="120" height="120" viewport="0 0 120 120" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <circle r="55" cx="60" cy="60" fill="transparent" stroke-dasharray="345" stroke-dashoffset="0"></circle>
                    <circle id="bar" r="55" cx="60" cy="60" fill="transparent" stroke-dasharray="345" stroke-dashoffset="0" style="stroke-dashoffset: 207.345px;"></circle>
                </svg>
            </div>
            <div class="filling-list">
                <div class="filling-list-item" :class="{current: isRegisterPage}">Регистрация</div>
                <div class="filling-list-item" :class="{current: isContactsPage}">Подтверждение контактов</div>
                <div class="filling-list-item" :class="{current: isPersonalDataPage}">Личные данные</div>

                <template v-if="isExecutor">
                    <div class="filling-list-item" :class="{current: isWorkDataPage}">Рабочие данные</div>
                    <div class="filling-list-item" :class="{current: isCategoriesPage}">Выбор категорий работ</div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import * as BarConstants from './bar_constants';

    export default {
        props: ['type', 'progress', 'page'],

        computed: {
            isCustomer() {
                return this.type === BarConstants.TYPE_CUSTOMER
            },
            isExecutor() {
                return this.type === BarConstants.TYPE_EXECUTOR
            },

            isRegisterPage() {
                return this.page === BarConstants.REGISTER_PAGE;
            },
            isContactsPage() {
                return this.page === BarConstants.CONTACTS_PAGE;
            },
            isPersonalDataPage() {
                return this.page === BarConstants.PERSON_DATA_PAGE;
            },
            isWorkDataPage() {
                return this.page === BarConstants.WORK_DATA_PAGE;
            },
            isCategoriesPage() {
                return this.page === BarConstants.CATEGORIES_PAGE;
            }
        },

        methods: {
            fillingProgress(){
                var val = $(".filling-progress").attr('data-progress');
                var $circle = $('#progress-svg #bar');

                if (isNaN(val)) {
                    val = 100;
                }
                else{
                    var r = $circle.attr('r');
                    var c = Math.PI*(r*2);

                    if (val < 0) { val = 0;}
                    if (val > 100) { val = 100;}

                    var progress = ((100-val)/100)*c;

                    $circle.css({ strokeDashoffset: progress});

                    $(".filling-progress").attr('data-progress', val);
                }
            }
        },

        mounted() {
            this.fillingProgress();
        }
    }
</script>

<style scoped>

</style>
