<template>
    <div class="row">
        <auto-fit-filter :cities="cities" :categories="categories" @submit="onSubmit" @change-category="category = $event" />

        <result v-if="displayResults" :category="category" :results="results" :filters="filters" />
        <div class="col category-body" v-else>
            <div class="autofit-info">
                <div class="headline">Автоподбор мастера или бригады</div>
                <p>Выбор исполнителя может занять немало времени. ADOMO.ru поможет вам упростить эту задачу, просто воспользуйтесь услугой!</p>
            </div>
        </div>
    </div>
</template>

<script>
    import Treeselect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.min.css';
    require('jquery-ui-dist/jquery-ui.min');
    require('jquery-ui-touch-punch');
    require('jquery-ui-dist/jquery-ui.min.css');
    import Result from "./_Result";
    import AutoFitFilter from './_Filter';

    export default {
        props: ['cities', 'categories'],

        data() {
            return {
                category: '',
                results: [],
                filters: [],
                displayResults: false,
            }
        },

        methods: {
            onSubmit(data) {
                this.displayResults = false;
                this.results = [];
                this.filters = data;

                axios.post(this.route('api.autofit'), data)
                    .then(res => {
                        const data = res.data;

                        if(!data.success) {
                            throw new Error(data.error)
                        }

                        this.results = data.data;
                        this.displayResults = true;

                        $('html, body').animate({scrollTop:0},500);
                    })
            }
        },

        mounted() {
            $(document).ready(function(){
                var sidebar_btn = $(".category-sidebar-btn");
                var sidebar = $(".category-sidebar");
                var sidebar_time = 0.5;
                var sidebar_start = {
                    xPercent: 100
                };
                var sidebar_end = {
                    xPercent: 0,
                    ease: Power4.easeInOut
                };

                $("body").on("click", "#autofit-submit", function() {
                    $("#autofit-result").show();
                    $(".autofit-info").hide();
                    sidebar.removeClass("sidebar-autofit-fix");
                    if(!$(".autofit-page").hasClass("has-result")){
                        setTimeout(function(){
                            if($(window).width() < 1280){
                                sidebar_tl.progress(0)
                            }
                            $('html, body').animate({scrollTop:0},500);
                        },500)
                    }
                    $(".autofit-page").addClass("has-result");
                });

                var sidebar_tl = gsap.timeline({ paused: true, reversed: true});
                sidebar_tl.fromTo(sidebar, sidebar_time, sidebar_start, sidebar_end);
                sidebar_btn.on("click",function(){
                    sidebar_tl.reversed() ?  sidebar_tl.play() : sidebar_tl.reverse();
                });
                $(window).resize(function() {
                    sidebarHandler();
                });
                function sidebarHandler(){
                    if( $(window).width() < 1280 ){
                        if(!$(".autofit-page").hasClass("has-result")){
                            sidebar.removeAttr("style").addClass("sidebar-autofit-fix");
                            sidebar_tl.progress( 100 );
                        }else{
                            sidebar_tl.reversed() ? sidebar_tl.reverse() : false;
                        }
                    }else{
                        sidebar.removeAttr("style");
                        sidebar_tl.progress( 100 );
                    }
                }
                sidebarHandler();

            });
        },

        components: {Treeselect, Result, AutoFitFilter}
    }
</script>

<style scoped>

</style>
