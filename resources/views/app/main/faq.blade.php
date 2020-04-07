@extends('layouts.frontend')

@section('main_class', 'faq-page')
@section('app_class', 'container')

@section('title', meta_title_helper(data_get($configs, 'faq_meta_title', 'Часто задаваемые вопросы')))

@section('meta')
    {!! meta_description_renderer(data_get($configs, 'faq_meta_description', 'О сервисе')) !!}
    {!! meta_keywords_renderer(data_get($configs, 'faq_meta_keywords', 'О сервисе')) !!}
@endsection

@section('main_header')
    <div class="container">
        <div class="breadcrumbs-section">
            <ul class="breadcrumbs">
                <li class="breadcrumbs-item"><a href="{{ url('/') }}">Adomo</a></li>
                <li class="breadcrumbs-item active"> <span>{{ data_get($configs, 'faq_breadcrumb', 'Часто задаваемые вопросы') }}</span></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col faq-page-main">
            <div class="faq">
                <div class="faq-title">{{ data_get($configs, 'faq_title', 'Часто задаваемые вопросы') }}</div>
                <div class="faq-subtitle">{!! data_get($configs, 'faq_text') !!}</div>
                <div class="faq-question-container">
                    @foreach($questions as $question)
                        <div class="faq-question-item" data-group="{{ $question->group }}">
                            <div class="faq-question-item-question">
                                <h3>{{ $question->title }}</h3>
                                <svg class="faq-arrow">
                                    <use xlink:href="/images/sprite-inline.svg#faq-arrow"></use>
                                </svg>
                            </div>
                            <div class="faq-question-item-answer" style="display:none">
                                {!! $question->text !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col faq-page-filter">
            <div class="faq-filter sticky">
                <ul class="faq-filter-list">
                    <li class="faq-filter-item current">
                        <button data-group="all">Все вопросы</button>
                    </li>

                    @foreach($groups as $key => $name)
                        <li class="faq-filter-item">
                            <button data-group="{{ $key }}">{{ $name }}</button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            console.log("done");
            $(".faq-filter-list").on("click",".faq-filter-item button",function(){
                $(".faq-filter-item").removeClass("current");
                $(this).parent().addClass("current");
                clearFaqItem();
                var data = $(this).attr("data-group");
                if(data=="all"){
                    $(".faq-question-item").each(function(){
                        $(this).fadeIn();
                    });
                }else{
                    $(".faq-question-item").each(function(){
                        if($(this).attr("data-group")==data){
                            $(this).fadeIn();
                        }else{
                            $(this).fadeOut();
                        }
                    });
                }
            });
            $(".faq-question-item-question").on("click",function(){
                $(this).toggleClass("open");
                $(this).next(".faq-question-item-answer").stop();
                $(this).next(".faq-question-item-answer").slideToggle();
            });
            function clearFaqItem(){
                $(".faq-question-item-answer").slideUp();
                $(".faq-question-item-question").removeClass("open")
            }
        });
    </script>
@endsection
